<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Location;
use App\Models\ChatConversation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    // Compact system prompt for Groq — no mention of tools/functions to avoid model narrating its process.
    private string $groqSystemPrompt = <<<EOT
Tu es Gluto, l'assistant virtuel officiel du Guide Sans Gluten Maroc 🌾

═══ LANGUE
Réponds dans la langue de l'utilisateur : français, darija (latin ou arabe) ou arabe.
En darija sois naturel : labas, wasfa, fin kayn, machi mushkil, saha w3afiya, kifach, bghit...

═══ PRÉSENTATION DES DONNÉES
Quand ce prompt contient des sections marquées "DONNÉES RÉELLES", présente ces données directement dans ta réponse, de manière naturelle et bien formatée.
Ne mentionne jamais "search_products", "search_recipes", "search_locations" ou tout autre nom technique dans ta réponse.
Ne dis pas comment tu as trouvé les données — présente-les simplement.

═══ DOMAINES D'EXPERTISE
• Maladie cœliaque : auto-immune, traitement = régime sans gluten strict à vie
• Aliments INTERDITS : blé, seigle, orge, triticale et dérivés
• Aliments AUTORISÉS : riz, maïs, quinoa, sarrasin, légumineuses, viandes, poissons, fruits, légumes
• Contamination croisée, lecture d'étiquettes, logo épi de blé barré
• Substituts, marques GF au Maroc (Schär, Céréal, Genius, Barkat)
• Cuisine marocaine adaptée, nutrition, lifestyle, voyages
• Toute question de santé ou de bien-être

═══ STYLE
Chaleureux, bienveillant, emojis adaptés. Réponds à TOUTES les questions sans exception.
Pour questions médicales sensibles : info générale utile + recommander un professionnel.
EOT;

    public function chat(Request $request)
    {
        $request->validate([
            'messages' => 'required|array',
            'conversation_id' => 'nullable|integer',
        ]);

        $messages = $request->input('messages');
        $conversationId = $request->input('conversation_id');

        // Find last user message and the previous subject query for continuation/fallback processing
        $lastUserMessage = '';
        $previousSubjectQuery = '';
        $previousAssistantContent = '';

        $reversed = array_reverse($messages);
        foreach ($reversed as $msg) {
            if (isset($msg['role']) && $msg['role'] === 'user') {
                $content = trim($msg['content']);
                if (empty($lastUserMessage)) {
                    $lastUserMessage = $content;
                } else {
                    // Check if this previous user message was an actual query, not a 'plus' continuation
                    $normalizedPrev = mb_strtolower(trim(preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $content)));
                    $normalizedPrev = preg_replace('/\s+/', ' ', $normalizedPrev);
                    if (!preg_match('/\b(plus|more|encore|détails|details|explique|continue|mazid|chrah|tafssil)\b/i', $normalizedPrev) && !preg_match('/زيد|المزيد|عطني مزيد/u', $content)) {
                        $previousSubjectQuery = $content;
                        break;
                    }
                }
            }
        }

        foreach ($reversed as $msg) {
            if (isset($msg['role']) && $msg['role'] === 'assistant') {
                $previousAssistantContent = $msg['content'] ?? '';
                break;
            }
        }

        $apiKey  = config('groq.api_key');
        $model   = config('groq.model', 'llama-3.3-70b-versatile');
        $timeout = (int) config('groq.timeout', 30);
        $latitude  = $request->input('latitude');
        $longitude = $request->input('longitude');

        $assistantResponseText = '';

        if (empty($apiKey)) {
            Log::info('Groq API key is missing. Using local rule-based response fallback.');

            $normalizedLast = mb_strtolower(trim(preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $lastUserMessage)));
            $normalizedLast = preg_replace('/\s+/', ' ', $normalizedLast);
            $isContinuation = preg_match('/\b(plus|more|encore|détails|details|explique|continue|mazid|chrah|tafssil)\b/i', $normalizedLast)
                || preg_match('/زيد|المزيد|عطني مزيد/u', $lastUserMessage);

            $queryToProcess = $isContinuation ? $previousSubjectQuery : $lastUserMessage;
            $assistantResponseText = $this->getRuleBasedResponse($queryToProcess, $isContinuation, $latitude, $longitude, $previousAssistantContent);
        } else {
            // Strategy: pre-fetch real DB data and inject into context BEFORE calling Groq.
            // This removes dependency on model's tool-calling format (which varies across models)
            // and prevents hallucination entirely — the model only formats data we provide.
            $dbContext      = $this->prefetchDatabaseContext($lastUserMessage, $latitude, $longitude);
            $systemContent  = $this->groqSystemPrompt . ($dbContext ? "\n\n" . $dbContext : '');

            // Keep only the last 8 messages to stay well within token limits
            $recentMessages = array_slice($messages, -8);
            $groqMessages   = [['role' => 'system', 'content' => $systemContent]];
            foreach ($recentMessages as $msg) {
                if (($msg['role'] ?? '') === 'system') {
                    continue;
                }
                $groqMessages[] = [
                    'role'    => $msg['role'],
                    'content' => $msg['content'] ?? '',
                ];
            }

            $endpoint = 'https://api.groq.com/openai/v1/chat/completions';
            $headers  = [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ];

            // Model fallback chain — each has its own daily quota on Groq free tier
            $modelsToTry = array_unique([
                $model,                    // primary (config: llama-3.1-70b-versatile)
                'llama-3.3-70b-versatile', // resets nightly UTC
                'mixtral-8x7b-32768',      // separate quota
                'llama-3.1-8b-instant',    // highest TPM, last resort
            ]);

            $lastError   = 'Unknown error';
            $gotResponse = false;

            try {
                foreach ($modelsToTry as $tryModel) {
                    if ($gotResponse) {
                        break;
                    }

                    $response     = Http::timeout($timeout)
                        ->withoutVerifying()
                        ->withHeaders($headers)
                        ->post($endpoint, [
                            'model'    => $tryModel,
                            'messages' => $groqMessages,
                            // No 'tools' key — data is already in the system context
                        ]);
                    $responseData = $response->json();

                    if (!$response->successful()) {
                        $errorMsg  = $responseData['error']['message'] ?? $response->body();
                        $lastError = "[{$tryModel}] {$errorMsg}";

                        if ($response->status() === 429) {
                            Log::info("Groq rate limit on {$tryModel}, switching to next model.");
                            continue;
                        }
                        continue;
                    }

                    $rawText = $responseData['choices'][0]['message']['content'] ?? '';

                    // Strip any stray <function=...> tags the model might output
                    $rawText = preg_replace('/<function=\w+>.*?(?:<\/function>|(?=<function)|\z)/s', '', $rawText);

                    $assistantResponseText = trim($rawText);
                    $gotResponse           = true;
                }

                if (!$gotResponse) {
                    Log::warning('All Groq models exhausted. Last error: ' . $lastError);
                    $assistantResponseText = $this->getRuleBasedResponse($lastUserMessage, false, $latitude, $longitude, $previousAssistantContent);
                }
            } catch (\Exception $e) {
                Log::warning('Groq API Error: ' . $e->getMessage() . ' - Falling back to local rule-based response.');
                $assistantResponseText = $this->getRuleBasedResponse($lastUserMessage, false, $latitude, $longitude, $previousAssistantContent);
            }
        }

        // Persistent DB Storage
        $conversation = null;
        if ($conversationId) {
            $conversation = ChatConversation::where('user_id', Auth::id())->find($conversationId);
        }

        if (!$conversation) {
            // Clean up the text for title
            $cleanTitle = strip_tags($lastUserMessage);
            $words = explode(' ', $cleanTitle);
            $title = implode(' ', array_slice($words, 0, 5));
            if (empty(trim($title))) {
                $title = "Nouvelle discussion";
            }
            if (mb_strlen($title) > 40) {
                $title = mb_substr($title, 0, 37) . '...';
            }

            $conversation = ChatConversation::create([
                'user_id' => Auth::id(),
                'title' => $title,
                'messages' => [],
            ]);
        }

        $history = $conversation->messages ?? [];
        $history[] = ['role' => 'user', 'content' => $lastUserMessage];
        $history[] = ['role' => 'assistant', 'content' => $assistantResponseText];

        $conversation->messages = $history;
        $conversation->save();

        return response()->json([
            'message' => $assistantResponseText,
            'conversation_id' => $conversation->id,
        ]);
    }

    /**
     * Local rule-based fallback response engine
     */
    private function getRuleBasedResponse(string $query, bool $isContinuation = false, $latitude = null, $longitude = null, string $previousAssistantContent = ''): string
    {
        // Remove emojis, symbols, and punctuation, preserving letters, numbers, and spaces
        $cleanQuery = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $query);
        // Normalize and trim
        $normalized = mb_strtolower(trim($cleanQuery));
        // Collapse multiple spaces into one
        $normalized = preg_replace('/\s+/', ' ', $normalized);

        // If it's a "plus" / "continue" follow-up request
        if ($isContinuation) {
            // 0. Generic recipes fallback continuation
            if (preg_match('/\b(omelette|pancakes|quinoa|brownie|idees rapides|idees rapides sans gluten)\b/i', $previousAssistantContent) || preg_match('/\b(omelette|pancakes|quinoa|brownie)\b/i', $normalized)) {
                return "🍽️ **Détails de nos suggestions rapides sans gluten :**\n\n" .
                    "1️⃣ **Omelette fromage & légumes**\n" .
                    "⏱️ 10 min\n" .
                    "🧂 Ingrédients : 3 œufs, poignée d'épinards, dés de tomate, fromage râpé sans gluten.\n" .
                    "👨‍🍳 Préparation : Battre les œufs, verser dans une poêle chaude, ajouter les légumes et le fromage, cuire 5 min.\n\n" .
                    "2️⃣ **Pancakes sans gluten**\n" .
                    "⏱️ 15 min\n" .
                    "🧂 Ingrédients : 1 tasse de farine sans gluten, 1 œuf, 1 tasse de lait, 1 c.à.s de sucre.\n" .
                    "👨‍🍳 Préparation : Mélanger les ingrédients, cuire à la poêle chaude 2 min par face.\n\n" .
                    "3️⃣ **Salade quinoa poulet**\n" .
                    "⏱️ 20 min\n" .
                    "🧂 Ingrédients : Quinoa cuit, blanc de poulet grillé, concombre, huile d'olive, jus de citron.\n" .
                    "👨‍🍳 Préparation : Mélanger le quinoa cuit tiède avec le poulet coupé et le concombre, assaisonner.\n\n" .
                    "4️⃣ **Brownie sans gluten**\n" .
                    "⏱️ 25 min\n" .
                    "🧂 Ingrédients : 100g de chocolat, 50g de beurre, 2 œufs, 30g de farine d'amande.\n" .
                    "👨‍🍳 Préparation : Faire fondre le chocolat et le beurre, incorporer les œufs et la farine, cuire 15 min à 180°C.\n\n" .
                    "Bon appétit 😋";
            }

            // 1. Celiac Disease
            if (preg_match('/\b(cœliaque|celiaque|intolérant|intolérance|symptôme|symptome|maladie|définition|definition)\b/i', $normalized)) {
                return "🩺 **Informations complémentaires sur la Maladie Cœliaque & le quotidien :**\n\n" .
                    "- **Symptômes fréquents** : Diarrhées, ballonnements chroniques, fatigue persistante, perte de poids, anémie.\n" .
                    "- **Complications** : Carences nutritionnelles sévères, ostéoporose, atteintes neurologiques en l'absence de traitement.\n" .
                    "- **Aliments strictement interdits** : Blé, seigle, orge (pain classique, pâtes, gâteaux, bières).\n" .
                    "- **Contamination croisée** : Éviter absolument d'utiliser les mêmes ustensiles ou huiles de friture que pour les aliments contenant du gluten.\n" .
                    "- **Conseils du quotidien** : Lisez systématiquement toutes les étiquettes, préparez des aliments bruts/naturels et cuisinez maison pour plus de sécurité ! 🌾🥗\n\n" .
                    "⚠️ *Je ne suis pas médecin. Pour un diagnostic ou un traitement, consultez un professionnel de santé.*";
            }

            // 2. Recipes
            if (preg_match('/\b(recette|recettes|cuisine|cuisiner|plat|plats|dessert|desserts|repas|gâteau|gateau|gateaux|gâteaux|dîner|diner|déjeuner|dejeuner|petit-déjeuner|petit-dejeuner)\b/i', $normalized)) {
                return "🍽️ **Astuces et conseils de préparation supplémentaires :**\n\n" .
                    "- **Variantes gourmandes** : Ajoutez des pépites de chocolat sans gluten, des morceaux de fruits frais (myrtilles, pommes) ou du zeste de citron à la pâte.\n" .
                    "- **Toppings suggérés** : Nappez de sirop d'érable, de miel pur, de purée d'amande ou de noix concassées.\n" .
                    "- **Conservation** : Conservez les restes dans une boîte hermétique au réfrigérateur pendant 2 jours ou congelez-les séparément. Réchauffez à la poêle ou au grille-pain.\n" .
                    "- **Alternatives Vegan / Sans Lactose** : Remplacez les œufs par de la compote de pommes (50g par œuf) ou des graines de lin moulues avec de l'eau. Utilisez du lait d'amande, de coco ou de soja. 👨‍🍳🥗";
            }

            // 3. Locations
            if (preg_match('/\b(magasin|magasins|boutique|boutiques|supermarché|adresse|adresses|restaurant|restaurants|resto|restos|casablanca|casa|rabat|marrakech|kech|tanger|fès|fes|agadir|oujda|nador|meknès|meknes|tétouan|tetouan)\b/i', $normalized)) {
                return "📍 **Conseils de visite et détails supplémentaires :**\n\n" .
                    "- **Horaires & Contacts** : La plupart des établissements de notre guide sont ouverts de 9h à 20h. Nous vous conseillons de cliquer sur le lien de la fiche de l'établissement pour vérifier les horaires à jour et appeler avant de vous déplacer.\n" .
                    "- **Produits disponibles** : Boulangeries fraîches, épicerie fine sans gluten, farines spéciales et alternatives saines.\n" .
                    "- **Conseils de visite** : Pensez à préciser au personnel que vous suivez un régime sans gluten strict (en mentionnant le risque de contamination croisée) pour un service 100% sécurisé ! 📍🛍️";
            }

            // 4. Medical / sensitive questions
            if (preg_match('/\b(diagnostic|médicament|medicament|guerir|guérir|traitement|malade|docteur|medecin|médecin)\b/i', $normalized)) {
                return "⚠️ **Rappel important de sécurité médicale :**\n\n" .
                    "Les symptômes digestifs ou généraux liés au gluten (ballonnements, fatigue, douleurs) nécessitent des examens médicaux précis (prise de sang pour les anticorps IgA anti-transglutaminase, puis biopsie intestinale) avant d'exclure totalement le gluten de votre alimentation.\n\n" .
                    "N'arrêtez jamais de consommer du gluten avant de passer ces tests, au risque de fausser le diagnostic médical. Veuillez consulter votre médecin traitant ou un gastro-entérologue pour un suivi rigoureux. 🩺";
            }

            return "Je ne dispose pas encore d'informations supplémentaires sur ce sujet précis 😔\n\nN'hésitez pas à me poser une autre question ! 🌾";
        }

        // --- DARIJA : SALUTATIONS ---
        if (
            preg_match('/\b(labas|la bas|lbas|kif dayr|kif dar|wach rak|ash khbarek|sbah lkhir|msa lkhir|kif rak|kif nta|kif nti|wa3likoum|waalikoum)\b/i', $normalized)
            || preg_match('/لاباس|كيفاش|آش خبارك|صباح الخير|مساء الخير|كيف داير|واش راك/u', $query)
        ) {
            return "لاباس 😊 Ana **Gluto**, l'assistant bla gluten d Maroc !\n\n" .
                "Nqder n3awnek :\n" .
                "🛒 Tjibu produits bla gluten\n" .
                "🍽️ Wsfat (recettes) bla gluten\n" .
                "📍 Magazinat w restorat\n" .
                "🩺 M3lumat 3la mard celiaque\n\n" .
                "Kifach nqderك naawen ? 😊";
        }

        // --- DARIJA : MERCI / AU REVOIR ---
        if (
            preg_match('/\b(shokran|choukran|barak allahou|ma3 sslama|b slama|beslama|b khir)\b/i', $normalized)
            || preg_match('/شكرا|بارك الله|مع السلامة/u', $query)
        ) {
            return "Bla jmil 😊 Saha w3afiya ! N9der n3awnek mera okhra 🌾";
        }

        if (
            preg_match('/\b(beslama|ma3 sslama|b slama|bslama)\b/i', $normalized)
            || preg_match('/مع السلامة|بسلامة/u', $query)
        ) {
            return "Beslama 👋 T9der tji mera okhra, dima hna ! 💚";
        }

        // --- DARIJA : C'EST QUOI GLUTO / PRÉSENTATION ---
        if (
            preg_match('/\b(chkoun nta|chkoun anta|shno nta|men nta|gluto|anta chkoun)\b/i', $normalized)
            || preg_match('/شكون نتا|من نتا|شنو نتا/u', $query)
        ) {
            return "Ana Gluto 🤖, l'assistant virtuel officiel dyal **Guide Sans Gluten Maroc**.\n\n" .
                "Mssemmit lich nsaawdek f kul chi y9edd bla gluten f lmaghrib 😊";
        }

        // --- DARIJA : MALADIE CELIAQUE ---
        if (
            preg_match('/\b(mard celiaque|celiaque|gluten mrid|bkl gluten|kidayr lmard|ash hiya|shno hiya l celiaque|sensitivity|tasasiya)\b/i', $normalized)
            || preg_match('/مرض|سيلياك|حساسية الغلوتين/u', $query)
        ) {
            return "🩺 **L mard celiaque** (مرض السيلياك) hiya marda auto-immune ktshad b gluten.\n\n" .
                "L gluten k9der ydher f :\n" .
                "❌ Khobz, pâtes, couscous (lli 3mlu b bl6)\n" .
                "❌ Ka3ba w hlwa b dqi3 3adi\n" .
                "❌ Bière classique\n\n" .
                "L 3ilaj wahd : régime bla gluten m3a t6ul 3omrek.\n\n" .
                "⚠️ *Ana machi tbib. Ila 3andek a3rad, mchi 3and docteur !*";
        }

        // --- DARIJA : WAJA3 LBTOUN ---
        if (
            preg_match('/\b(wja3 lbtoun|btoun k9ub|btoun gonfl|l3yan m3a gluten|klit w mrit|m3dti|m3da)\b/i', $normalized)
            || preg_match('/وجع البطن|البطن منفوخ|تعبان/u', $query)
        ) {
            return "🩺 Wja3 lbtoun wla tenfokh men b3d ma tkol gluten y9eder ykun 3lamet intolérance.\n\n" .
                "⚠️ **Muhim** : Matqt3ch gluten qbel ma tchouf tbib — ila qte3tih, l tests ma y3ti3uch ntija sahiha.\n\n" .
                "Mchi 3and docteur basch iddi lek t7alil ddem (IgA anti-tTG). 🩺";
        }

        // --- DARIJA : RECHERCHE WASFA (RECETTE) ---
        if (
            preg_match('/\b(wasfa|wsfat|3tini wasfa|bghit wasfa|kifach ndiru|kifach diru|ta3mir|recette darija)\b/i', $normalized)
            || preg_match('/وصفة|كيفاش دير/u', $query)
        ) {
            $darijaRecipeQuery = preg_replace('/\b(wasfa|wsfat|3tini|bghit|kifach ndiru|kifach diru|ta3mir|dyal|d|bla gluten)\b/iu', ' ', $normalized);
            $darijaRecipeQuery = trim(preg_replace('/\s+/', ' ', $darijaRecipeQuery));

            // Map common Darija food words to French for DB search
            $darijaMap = ['khobz' => 'pain', 'ka3ba' => 'gateau', 'hlwa' => 'dessert', 'ftour' => 'petit dejeuner', 'beid' => 'oeufs', 'djaj' => 'poulet', 'roz' => 'riz'];
            foreach ($darijaMap as $darija => $french) {
                $darijaRecipeQuery = str_replace($darija, $french, $darijaRecipeQuery);
            }

            $recipes = $this->searchRecipes(empty(trim($darijaRecipeQuery)) ? 'recette' : $darijaRecipeQuery);
            if (!empty($recipes)) {
                $response = "🍽️ **Hna wasfa men 3andna f site** 😊\n\n";
                foreach ($recipes as $recipe) {
                    $response .= "🍽️ **[{$recipe['nom']}]({$recipe['lien']})**\n\n";
                    $response .= "⏱️ {$recipe['temps']} min\n\n";
                    $response .= "🧂 Ingrédients :\n";
                    foreach ($recipe['ingredients'] as $ing) {
                        $response .= "- {$ing}\n";
                    }
                    $response .= "\n👨‍🍳 Étapes :\n";
                    foreach ($recipe['steps'] as $idx => $step) {
                        $response .= ($idx + 1) . ". {$step}\n";
                    }
                    $response .= "\nSaha w3afiya 😋\n\n---\n\n";
                }
                return rtrim($response, "\n-");
            }
            return "🍽️ Ma l9itch wasfa f base dyal site daba 😔\n\n" .
                "Yallah nchofu recettes kollhom : **[Rubrique Recettes](/recipes)**\n\n" .
                "Wla kteb liya shno bghiti n3amel w ana n3awnek ! 😊";
        }

        // --- DARIJA : CHERCHER PRODUIT ---
        if (
            preg_match('/\b(fin njibu|wfin nshri|bghit njib|bghit nshri|fin kayn|wain kayn|khobz bla gluten|biscwit bla|ka3ba bla|hlwa bla)\b/i', $normalized)
            || preg_match('/فين نجيبو|واين كاين|خبز بلا غلوتان/u', $query)
        ) {
            $darijaProductMap = ['khobz' => 'pain', 'ka3ba' => 'gateau', 'hlwa' => 'biscuit', 'biscwit' => 'biscuit', 'farine' => 'farine'];
            $productQuery = $normalized;
            foreach ($darijaProductMap as $d => $f) {
                $productQuery = str_replace($d, $f, $productQuery);
            }
            $productQuery = preg_replace('/\b(fin njibu|wfin nshri|bghit|njib|nshri|fin kayn|wain kayn|bla gluten)\b/iu', ' ', $productQuery);
            $productQuery = trim(preg_replace('/\s+/', ' ', $productQuery)) ?: 'pain';

            $products = $this->searchProducts($productQuery);
            if (!empty($products)) {
                $response = "🛒 **Hna produits li l9ina f site :**\n\n";
                foreach ($products as $prod) {
                    $response .= "- **[{$prod['nom']}]({$prod['lien']})** — {$prod['prix']}\n";
                    $response .= "  {$prod['description']}\n\n";
                }
                $response .= "Click 3la produit basch tchouf détails 😊";
                return $response;
            }
            return "Ma l9inch had produit f site daba 😔\n\nYallah nchofu produits kollhom : **[Rubrique Produits](/products)**";
        }

        // --- DARIJA : CHERCHER MAGASIN / RESTAURANT ---
        if (
            preg_match('/\b(fin kayn magazin|wain kayn restoran|fin njibu f|hanout bla gluten|resto bla gluten|maghaza)\b/i', $normalized)
            || preg_match('/فين كاين|مجزن|ريسطورة/u', $query)
        ) {
            $darijaCity = null;
            if (preg_match('/\b(casa|casablanca|dar lbida)\b/i', $normalized))
                $darijaCity = 'Casablanca';
            elseif (preg_match('/\b(rbat|rabat)\b/i', $normalized))
                $darijaCity = 'Rabat';
            elseif (preg_match('/\b(marrakech|kech|merrakch)\b/i', $normalized))
                $darijaCity = 'Marrakech';
            elseif (preg_match('/\b(tanja|tanger)\b/i', $normalized))
                $darijaCity = 'Tanger';
            elseif (preg_match('/\b(fas|fes|fès)\b/i', $normalized))
                $darijaCity = 'Fès';
            elseif (preg_match('/\b(agadir)\b/i', $normalized))
                $darijaCity = 'Agadir';

            if ($darijaCity) {
                $locations = $this->searchLocations($darijaCity);
                if (!empty($locations)) {
                    $response = "📍 **Hna 3nawin f {$darijaCity} :**\n\n";
                    foreach ($locations as $loc) {
                        $response .= "- **[{$loc['nom']}]({$loc['lien']})**\n";
                        $response .= "  📍 {$loc['adresse']}\n\n";
                    }
                    $response .= "Click bach tchouf ficha kamilha 😊";
                    return $response;
                }
                return "Ma l9inch 3nawin f {$darijaCity} daba 😔\n\nYallah nchofu : **[Rubrique Adresses](/locations)**";
            }
            return "📍 F anya mdina bghiti nqleblak ? 😊\n\nKteb smiyya lmdina (ex: Casablanca, Rabat, Marrakech...)";
        }

        // --- GESTION DES MESSAGES COURTS (français) ---
        if (preg_match('/\b(bonjour|salut|coucou|hello|hey|bonsoir|hi)\b/i', $normalized)) {
            return "Bonjour 😊 Je suis Gluto.\n" .
                "Je peux vous aider à trouver :\n" .
                "🛒 des produits sans gluten\n" .
                "🍽️ des recettes\n" .
                "📍 des magasins\n" .
                "🩺 des informations sur la maladie cœliaque";
        }

        if (preg_match('/\b(merci|shokran|choukran)\b/i', $normalized)) {
            return "Avec plaisir 😊";
        }

        if (preg_match('/\b(bye|au revoir|adieu|ciao|beslama)\b/i', $normalized)) {
            return "À bientôt 👋 Prenez soin de vous 💚";
        }

        if (preg_match('/\b(qui es-tu|ton nom|qui tu es|tu es qui|gluto|présente-toi|presente)\b/i', $normalized)) {
            return "Je suis Gluto, l'assistant virtuel officiel du Guide Sans Gluten Maroc. 😊";
        }

        // --- QUESTIONS MÉDICALES SENSIBLES ---
        if (
            preg_match('/\b(diagnostic|traitement|médicament|medicament|urgence|grave|malade|guérir|guerir|docteur|medecin|médecin|dwa|tbib|dktour|mrid|mrida|l3iyan)\b/i', $normalized)
            || preg_match('/\b(est ce que je suis malade|quel medicament prendre|quel médicament prendre|comment guerir|comment guérir|3tini dawa|kifach n3alaj)\b/i', $normalized)
        ) {
            return "⚠️ Je ne suis pas médecin et je ne peux pas poser de diagnostic médical.\n\n" .
                "Les symptômes ou questions concernant la santé nécessitent l'avis d'un professionnel. Je vous recommande de consulter un professionnel de santé pour un diagnostic précis. 🩺";
        }

        // --- FAQ INTELLIGENTE ---
        if (preg_match('/\b(riz|roz)\b/i', $normalized)) {
            return "Non 😊 Le riz est naturellement sans gluten. (Roz : bla gluten ✅)";
        }
        if (preg_match('/\b(pomme de terre|pommes de terre|batata)\b/i', $normalized)) {
            return "Oui ✅ Les pommes de terre sont naturellement sans gluten. (Batata : bla gluten ✅)";
        }
        if (preg_match('/\b(frite|frites)\b/i', $normalized)) {
            return "Oui si elles ne sont pas contaminées par une huile utilisée pour des aliments contenant du gluten.";
        }
        if (preg_match('/\b(chocolat)\b/i', $normalized)) {
            return "Certains chocolats sont sans gluten, mais il faut vérifier les ingrédients.";
        }
        if (preg_match('/\b(couscous|kseksou)\b/i', $normalized)) {
            return "❌ Le couscous traditionnel contient du gluten car il est fabriqué à partir de blé.\n\n" .
                "**Alternative** : couscous de maïs ou de millet — bla gluten ✅";
        }
        if (preg_match('/\b(avoine)\b/i', $normalized)) {
            return "Seulement si elle est certifiée sans gluten.";
        }
        if (preg_match('/\b(commencer|débuter|kifach nbda)\b/i', $normalized)) {
            return "Commencez par éviter le blé, l'orge et le seigle puis privilégiez les aliments naturels sans gluten.";
        }
        if (preg_match('/\b(autorisé|autorise|autorisés|autorises|permis|conseillé|conseille|conseillés|conseilles|manger|consommer)\b/i', $normalized) && preg_match('/\b(aliment|aliments|nourriture|produit|produits)\b/i', $normalized)) {
            return "🍎 **Aliments naturellement sans gluten (autorisés) :**\n\n" .
                "- **Féculents** : Riz, pomme de terre, maïs, quinoa, sarrasin, manioc.\n" .
                "- **Protéines** : Viandes fraîches, poissons, œufs, tofu (nature).\n" .
                "- **Produits laitiers** : Lait nature, yaourt nature, certains fromages.\n" .
                "- **Fruits & Légumes** : Tous les fruits et légumes frais, surgelés ou en conserve au naturel.\n" .
                "- **Matières grasses** : Huiles végétales, beurre nature.\n\n" .
                "Privilégiez les aliments bruts pour éviter toute contamination croisée ! 🍏";
        }
        if (preg_match('/\b(interdit|interdits|éviter|eviter|proscrit|proscrits|danger|dangereux)\b/i', $normalized) && preg_match('/\b(aliment|aliments|nourriture|produit|produits)\b/i', $normalized)) {
            return "🚫 **Aliments contenant du gluten (strictement interdits) :**\n\n" .
                "- **Céréales interdites** : Blé (froment, épeautre, kamut), seigle, orge (s'en souvenir avec le moyen mnémotechnique **SABO** : Seigle, Avoine*, Blé, Orge).\n" .
                "- **Produits dérivés** : Pain classique, pâtes, pizzas, gâteaux, biscuits, chapelure.\n" .
                "- **Boissons** : Bière classique (malt d'orge).\n" .
                "- **Pièges fréquents** : Plats cuisinés industriels, sauces liées à la farine, cubes de bouillon, charcuterie industrielle.\n\n" .
                "⚠️ Lisez toujours attentivement les étiquettes à la recherche du logo 'Épi de blé barré' ou de la mention 'Sans Gluten' !";
        }

        // --- MALADIE CŒLIAQUE & AUTOMATIC INTENT DETECTION: MAL AU VENTRE ---
        if (preg_match('/\b(mal au ventre|mal de ventre|ventre gonflé|douleur abdominale|douleurs abdominales)\b/i', $normalized)) {
            return "🩺 Les maux de ventre ou ballonnements après la consommation de gluten peuvent être le signe d'une intolérance au gluten (maladie cœliaque) ou d'une sensibilité au gluten non cœliaque.\n\n" .
                "Il est important d'en parler à un médecin pour réaliser des examens appropriés.\n\n" .
                "⚠️ **Avertissement médical** : Je ne suis pas médecin. N'arrêtez pas le gluten avant d'avoir consulté un professionnel et effectué des tests sanguins, car cela pourrait fausser le diagnostic. 🩺";
        }

        if (preg_match('/\b(cœliaque|celiaque|intolérant|intolérance|symptôme|symptome|allergie|causes|cause)\b/i', $normalized)) {
            return "🩺 La maladie cœliaque est une maladie auto-immune déclenchée par le gluten.\n\n" .
                "Le gluten provoque une réaction immunitaire qui abîme l'intestin grêle.\n\n" .
                "Le traitement reconnu est un régime sans gluten strict à vie.\n\n" .
                "⚠️ Je ne suis pas médecin. Pour un diagnostic ou un traitement, consultez un professionnel de santé.";
        }

        // --- STORES NEAR ME / AROUND ME ---
        if (preg_match('/\b(proche|proximité|proximite|autour|near|près de moi|pres de moi|proximité|proximite)\b/i', $normalized)) {
            if ($latitude !== null && $longitude !== null) {
                $locations = $this->searchNearestLocations($latitude, $longitude);
                if (!empty($locations)) {
                    $response = "📍 Voici les établissements sans gluten proches de vous :\n\n";
                    foreach ($locations as $loc) {
                        $response .= "- **[{$loc['nom']}]({$loc['lien']})**\n";
                        $response .= "  📍 {$loc['adresse']}\n";
                        $response .= "  📏 {$loc['distance']} km environ\n\n";
                    }
                    $response .= "Activez votre localisation pour obtenir des résultats plus précis 😊";
                    return $response;
                } else {
                    return "📍 Je n'ai pas accès à votre position exacte 😔\n" .
                        "Pouvez-vous préciser votre ville ou quartier ?";
                }
            } else {
                return "📍 Je n'ai pas accès à votre position exacte 😔\n" .
                    "Pouvez-vous préciser votre ville ou quartier ?";
            }
        }

        // --- LOCATIONS SEARCH ---
        $city = null;
        if (preg_match('/\b(casablanca|casa)\b/i', $normalized))
            $city = 'Casablanca';
        elseif (preg_match('/\b(rabat)\b/i', $normalized))
            $city = 'Rabat';
        elseif (preg_match('/\b(marrakech|kech)\b/i', $normalized))
            $city = 'Marrakech';
        elseif (preg_match('/\b(tanger)\b/i', $normalized))
            $city = 'Tanger';
        elseif (preg_match('/\b(fès|fes)\b/i', $normalized))
            $city = 'Fès';
        elseif (preg_match('/\b(agadir)\b/i', $normalized))
            $city = 'Agadir';
        elseif (preg_match('/\b(oujda)\b/i', $normalized))
            $city = 'Oujda';
        elseif (preg_match('/\b(nador)\b/i', $normalized))
            $city = 'Nador';
        elseif (preg_match('/\b(meknès|meknes)\b/i', $normalized))
            $city = 'Meknès';
        elseif (preg_match('/\b(tétouan|tetouan)\b/i', $normalized))
            $city = 'Tétouan';

        if ($city !== null) {
            $locations = $this->searchLocations($city);
            if (!empty($locations)) {
                $response = "📍 Voici les adresses sans gluten trouvées à {$city} :\n\n";
                foreach ($locations as $loc) {
                    $response .= "- **[{$loc['nom']}]({$loc['lien']})**\n";
                    $response .= "  📍 {$loc['adresse']}\n\n";
                }
                $response .= "N'hésitez pas à consulter leur fiche détaillée 😊";
                return $response;
            } else {
                return "Je ne dispose pas encore de cette information 😔\n\nN'hésitez pas à chercher dans une autre ville ou à me poser une autre question ! 🌾";
            }
        }

        // If they ask for store/location generally without a city or trigger where to buy
        if (preg_match('/\b(magasin|magasins|boutique|boutiques|supermarché|adresse|adresses|restaurant|restaurants|resto|restos|boulangerie|boulangeries|café|cafes|cafés|où acheter|ou acheter|où trouver|ou trouver)\b/i', $normalized)) {
            return "Pour vous aider à trouver des magasins, boulangeries ou restaurants sans gluten, de quelle ville parlez-vous ? 📍\n\nVous pouvez me préciser par exemple : *Casablanca*, *Rabat*, *Marrakech*, *Tanger*... 😊";
        }

        // --- PRODUCTS SEARCH ---
        if (preg_match('/\b(produit|produits|pain|pains|farine|farines|pâte|pâte|pates|gâteau|gateau|biscuit|biscuits|chocolat|chocolats|acheter|trouver|chercher)\b/i', $normalized) && !preg_match('/\b(recette|recettes|cuisine|cuisiner|préparer|preparer|faire)\b/i', $normalized)) {
            // Extract a clean keyword to search using word boundaries
            $wordsToRemove = ['chercher', 'acheter', 'trouver', 'du', 'des', 'de', 'le', 'la', 'un', 'une', 'sans', 'gluten', 'produit', 'produits'];
            $pattern = '/\b(' . implode('|', $wordsToRemove) . ')\b/iu';
            $cleanProductQuery = preg_replace($pattern, ' ', $normalized);
            $cleanProductQuery = trim(preg_replace('/\s+/', ' ', $cleanProductQuery));

            if (empty($cleanProductQuery)) {
                $cleanProductQuery = 'pain';
            }

            $products = $this->searchProducts($cleanProductQuery);
            if (!empty($products)) {
                $response = "🛒 Voici les produits sans gluten trouvés :\n\n";
                foreach ($products as $prod) {
                    $response .= "- **[{$prod['nom']}]({$prod['lien']})** — {$prod['prix']}\n";
                    $response .= "  {$prod['description']}\n\n";
                }
                $response .= "Cliquez sur un produit pour voir les détails 😊";
                return $response;
            } else {
                return "Je n'ai pas trouvé ce produit pour le moment 😔";
            }
        }

        // --- RECIPES SEARCH ---
        if (preg_match('/\b(recette|recettes|cuisine|cuisiner|plat|plats|dessert|desserts|repas|gâteau|gateau|gateaux|gâteaux|dîner|diner|déjeuner|dejeuner|petit-déjeuner|petit-dejeuner|pain|pains|pizza|pizzas|préparer|preparer|faire|snack|snacks|rapide|rapides|facile|faciles|déjeuner|dejeuner)\b/i', $normalized)) {
            // Extract a clean keyword to search using word boundaries
            $wordsToRemove = ['recette', 'recettes', 'sans', 'gluten', 'idée', 'idées', 'de', 'du', 'des', 'le', 'la', 'un', 'une', 'cherche', 'trouver', 'comment', 'faire', 'préparer', 'preparer'];
            $pattern = '/\b(' . implode('|', $wordsToRemove) . ')\b/iu';
            $cleanRecipeQuery = preg_replace($pattern, ' ', $normalized);
            $cleanRecipeQuery = trim(preg_replace('/\s+/', ' ', $cleanRecipeQuery));

            if (empty($cleanRecipeQuery)) {
                $cleanRecipeQuery = 'recette';
            }

            $recipes = $this->searchRecipes($cleanRecipeQuery);
            if (!empty($recipes)) {
                $response = "";
                foreach ($recipes as $recipe) {
                    $response .= "🍽️ **[{$recipe['nom']}]({$recipe['lien']})**\n\n";
                    $response .= "⏱️ Temps : {$recipe['temps']} min\n\n";
                    $response .= "🧂 Ingrédients :\n";
                    foreach ($recipe['ingredients'] as $ing) {
                        $response .= "- {$ing}\n";
                    }
                    $response .= "\n👨‍🍳 Étapes :\n";
                    foreach ($recipe['steps'] as $idx => $step) {
                        $stepNum = $idx + 1;
                        $response .= "{$stepNum}. {$step}\n";
                    }
                    $response .= "\nBon appétit 😋\n\n-------------------------\n\n";
                }
                $response = rtrim($response, "\n-");
                return $response;
            } else {
                return "🍽️ Je n'ai pas trouvé de recette exacte dans notre base, mais voici quelques idées rapides sans gluten 😊\n\n" .
                    "1️⃣ Omelette fromage & légumes\n" .
                    "⏱️ 10 min\n\n" .
                    "2️⃣ Pancakes sans gluten\n" .
                    "⏱️ 15 min\n\n" .
                    "3️⃣ Salade quinoa poulet\n" .
                    "⏱️ 20 min\n\n" .
                    "4️⃣ Brownie sans gluten\n" .
                    "⏱️ 25 min\n\n" .
                    "Vous pouvez aussi explorer notre rubrique Recettes pour plus d'idées 🍽️";
            }
        }

        // --- HELP / AIDE ---
        if (
            preg_match('/\b(help|aide|support|assistance|chno t9der dir|kifach t3awen)\b/i', $normalized)
            || preg_match('/مساعدة|help/u', $query)
        ) {
            return "🆘 **Je peux vous aider avec :**\n\n" .
                "🛒 **Produits** → \"pain bla gluten\", \"farine sans gluten\"\n" .
                "🍽️ **Recettes** → \"3tini wasfa\", \"recette ftor\", \"dessert bla gluten\"\n" .
                "📍 **Adresses** → \"fin kayn magasin f casa\", \"magasins à Rabat\"\n" .
                "🩺 **Santé** → \"chno hiya celiac\", \"a3rad intolerance gluten\"\n" .
                "🌾 **Aliments** → \"wach riz fih gluten\", \"chno n9der nakol\"\n" .
                "⚡ **Lifestyle** → \"healthy tips\", \"meal prep bla gluten\"\n\n" .
                "Posez votre question en français, darija ou arabe 😊";
        }

        // --- CHNO HOWA GLUTEN (c'est quoi le gluten) ---
        if (
            preg_match('/\b(chno howa gluten|c est quoi gluten|kesquoi gluten|what is gluten|gluten c quoi|gluten kif kif|définition gluten|definition gluten)\b/i', $normalized)
            || preg_match('/ما هو الغلوتان|شنو هو الغلوتان/u', $query)
        ) {
            return "🌾 **Chno howa gluten ?**\n\n" .
                "Le **gluten** est une protéine qu'on trouve dans certaines céréales :\n" .
                "❌ **Blé (bl6)** — d9i9 3adi, khobz, pasta, semoule\n" .
                "❌ **Orge (ch3ir)** — bière classique\n" .
                "❌ **Seigle (jdar)** — certains pains\n" .
                "❌ **Triticale** — hybride blé/seigle\n\n" .
                "Chez les personnes cœliaques, le gluten déclenche une réaction auto-immune qui abîme l'intestin grêle.\n\n" .
                "✅ **Bla gluten** : riz, maïs, quinoa, sarrasin, millet, pomme de terre, légumineuses.\n\n" .
                "💬 Tape **plus** / **mazid** pour avoir plus de détails ! 🌾";
        }

        // --- FINA KAYN GLUTEN (où y a-t-il du gluten) ---
        if (
            preg_match('/\b(fina kayn gluten|fina kayn f lmakla|ou y a gluten|ou trouve gluten|sources gluten|gluten fina|gluten f chno)\b/i', $normalized)
            || preg_match('/فين كاين الغلوتان|أين يوجد الغلوتان/u', $query)
        ) {
            return "🚫 **Fina kayn gluten f lmakla :**\n\n" .
                "**⚠️ Sources évidentes :**\n" .
                "- Khobz 3adi (pain classique)\n" .
                "- Pasta / ma9arona 3adiya\n" .
                "- Couscous (semoule de blé)\n" .
                "- Msemen, mlawi, harcha (b d9i9 bl6)\n" .
                "- Ka3ba, biscwit, crêpes classiques\n" .
                "- Bière / bira (malt d'orge)\n\n" .
                "**⚠️ Sources cachées (les pièges) :**\n" .
                "- Sauce soja classique\n" .
                "- Bouillon en cube (certains)\n" .
                "- Charcuterie industrielle\n" .
                "- Certains médicaments (excipients)\n" .
                "- Plats cuisinés industriels\n\n" .
                "✅ **L9i produits bla gluten** dans notre rubrique **[Produits](/products)**";
        }

        // --- WACH FIH GLUTEN (un produit contient-il du gluten) ---
        if (preg_match('/\b(wach fih gluten|wach had produit fih|fih gluten wla la|ma fihch gluten|wach safe|safe l celiac|gluten wla bla)\b/i', $normalized)) {
            return "🏷️ **Kif t3raf wach produit fih gluten :**\n\n" .
                "1️⃣ Qra **liste des ingrédients** — tsenn 3la : blé, froment, orge, seigle, malt\n" .
                "2️⃣ Chof **logo épi de blé barré** 🌾 (certifié sans gluten < 20 ppm)\n" .
                "3️⃣ Qra mention : **\"Peut contenir des traces de gluten\"** ⚠️\n" .
                "4️⃣ Fabri3 f hanout **section bio/diététique** — souvent kayna produits bla gluten\n\n" .
                "✅ **Cherche produit f notre base** : tape le nom du produit et je cherche pour toi ! 🛒";
        }

        // --- CHNO N9DER NAKOL (que puis-je manger) ---
        if (preg_match('/\b(chno n9der nakol|chno n9der nakol bla gluten|quoi manger bla gluten|chno nakol|aliments autorises|aliments permis|n9der nakol|nakol chno)\b/i', $normalized)) {
            return "🍎 **Chno n9der nakol bla gluten :**\n\n" .
                "✅ **Féculents** : Riz (roz), batata, maïs, quinoa, sarrasin, millet\n" .
                "✅ **Protéines** : Djaj (poulet), l7am (viande), 7out (poisson), beid (œufs)\n" .
                "✅ **Légumineuses** : L3des (lentilles), 7miss (pois chiches), loubia (haricots)\n" .
                "✅ **Produits laitiers** : L7lib (lait), danone 3adi, fromage nature\n" .
                "✅ **Fruits & légumes** : Kol chi 6abi3i ✅\n" .
                "✅ **Matières grasses** : Zit (huile), zebda (beurre) nature\n\n" .
                "❌ **Hta t9ra étiquette** : méfiance avec les produits industriels !\n\n" .
                "💡 Tape **recette** ou **wasfa** pour avoir des idées de repas ! 🍽️";
        }

        // --- BDAL L FARINE / SUBSTITUTS ---
        if (preg_match('/\b(bdal l farine|substitut farine|alternative farine|farine sans gluten|remplacer farine|bdal d9i9|chno nbdal b d9i9)\b/i', $normalized)) {
            return "🌾 **Bdal l farine 3adiya (substituts sans gluten) :**\n\n" .
                "🌾 **Farine de riz** — polyvalente, goût neutre ✅\n" .
                "🌽 **Farine de maïs (maïzena)** — idéale pour épaissir les sauces ✅\n" .
                "🥜 **Farine d'amande** — riche, pour gâteaux et muffins ✅\n" .
                "🥥 **Farine de coco** — absorbante, pour desserts ✅\n" .
                "🫘 **Farine de pois chiche (7miss)** — pour crêpes, beignets ✅\n" .
                "🌿 **Sarrasin (blé noir)** — pour galettes, crêpes ✅\n" .
                "🪴 **Fécule de pomme de terre** — pour lier les sauces ✅\n\n" .
                "💡 **Conseil** : Pour les gâteaux, mélangez 2-3 farines pour un meilleur résultat !\n\n" .
                "🛒 Cherche **farine** dans notre site pour voir les produits disponibles !";
        }

        // --- L7OBOB / CEREALES AVEC/SANS GLUTEN ---
        if (preg_match('/\b(l7obob|cereales|céréales|wach l7obob fihom gluten|graines|7obob)\b/i', $normalized)) {
            return "🌾 **L7obob (céréales) — avec ou sans gluten :**\n\n" .
                "❌ **Fihom gluten :**\n" .
                "- Blé / bl6 (froment, épeautre, kamut)\n" .
                "- Orge / ch3ir\n" .
                "- Seigle / jdar\n" .
                "- Triticale\n\n" .
                "✅ **Bla gluten :**\n" .
                "- Riz / roz ✅\n" .
                "- Maïs ✅\n" .
                "- Quinoa ✅\n" .
                "- Sarrasin / blé noir ✅ (malgré le nom !)\n" .
                "- Millet ✅\n" .
                "- Sorgho ✅\n" .
                "- Teff ✅\n" .
                "- Amarante ✅\n\n" .
                "⚠️ **Avoine** : bla gluten seulement si certifiée sans gluten !";
        }

        // --- L3DES / LENTILLES ---
        if (preg_match('/\b(l3des|lentilles|lentille)\b/i', $normalized)) {
            return "✅ **L3des (lentilles) : bla gluten !**\n\n" .
                "Les lentilles sont naturellement sans gluten et très nutritives.\n\n" .
                "⚠️ Attention à la contamination croisée lors du traitement industriel — " .
                "choisissez des lentilles certifiées sans gluten si vous êtes très sensible.\n\n" .
                "💡 L3des idéales pour : soupe, salade, 7rira bla gluten, burger végétarien !";
        }

        // --- MA9ARONA / PASTA SANS GLUTEN ---
        if (preg_match('/\b(ma9arona|pasta|pâtes|pattes|pasta gluten free|ma9arona bla gluten)\b/i', $normalized)) {
            return "🍝 **Ma9arona bla gluten :**\n\n" .
                "✅ Il existe des pâtes sans gluten à base de :\n" .
                "- Riz (ma9arona dyal roz)\n" .
                "- Maïs (ma9arona dyal maïs)\n" .
                "- Quinoa\n" .
                "- Lentilles (ma9arona dyal l3des)\n" .
                "- Pois chiches (ma9arona dyal 7miss)\n\n" .
                "🛒 Cherche **pâtes** ou **pasta** dans notre rubrique [Produits](/products) pour voir les références disponibles !";
        }

        // --- FTOR (PETIT DÉJEUNER) ---
        if (
            preg_match('/\b(ftor|petit.dej|petit dejeuner|breakfast|sbah)\b/i', $normalized)
            && !preg_match('/\b(recette|wasfa|kifach)\b/i', $normalized)
        ) {
            $recipes = $this->searchRecipes('petit dejeuner');
            if (!empty($recipes)) {
                $response = "☀️ **Idées ftor (petit-déjeuner) bla gluten :**\n\n";
                foreach (array_slice($recipes, 0, 2) as $r) {
                    $response .= "🍽️ **[{$r['nom']}]({$r['lien']})** — ⏱️ {$r['temps']} min\n\n";
                }
                $response .= "\n💡 **Idées rapides :** Beid (œufs), fromage, fruits, yaourt, smoothie, pain bla gluten grillé.\n\n";
                $response .= "Tape **wasfa ftor** pour une recette complète ! 😊";
                return $response;
            }
            return "☀️ **Idées ftor bla gluten :**\n\n" .
                "🥚 Beid m3a zebda (œufs au beurre)\n" .
                "🍞 Khobz bla gluten grillé + fromage frais\n" .
                "🥣 Yaourt nature + fruits + miel\n" .
                "🥞 Pancakes bla gluten (wasfa sahla)\n" .
                "🍌 Smoothie f7a w lben\n" .
                "🥑 Pain bla gluten + avocat\n\n" .
                "Tape **3tini wasfa pancakes** pour la recette ! 😋";
        }

        // --- GHDA / LUNCH ---
        if (
            preg_match('/\b(ghda|lunch|déjeuner|dejeuner|midi|menu midi)\b/i', $normalized)
            && !preg_match('/\b(recette|wasfa|kifach)\b/i', $normalized)
        ) {
            return "🍽️ **Idées ghda (déjeuner) bla gluten :**\n\n" .
                "🫕 Tajine (m3a roz ou batata bedel semoule) ✅\n" .
                "🍗 Poulet grillé (djaj m7ammar) + salade ✅\n" .
                "🥗 Salade quinoa + légumes + thon ✅\n" .
                "🫘 L3des b zzit w l7amra (salade lentilles) ✅\n" .
                "🍚 Riz (roz) m3a légumes sautés ✅\n" .
                "🐟 7out f ferran (poisson au four) + batata m7ammra ✅\n\n" .
                "🛒 Explore notre rubrique **[Recettes](/recipes)** pour plus d'idées ! 😊";
        }

        // --- 3CHA / DINER ---
        if (
            preg_match('/\b(3cha|diner|dîner|soiree|soir|dinner|kel barra|nakol f l3cha)\b/i', $normalized)
            && !preg_match('/\b(recette|wasfa|nakol barra|restaurant)\b/i', $normalized)
        ) {
            return "🌙 **Idées 3cha (dîner) léger bla gluten :**\n\n" .
                "🥗 Salade composée (salade mrakba) ✅\n" .
                "🥚 Omelette légumes (omelette m3a khodra) ✅\n" .
                "🍵 Soupe l3des (7rira bla gluten) ✅\n" .
                "🐟 Filet de poisson vapeur + légumes ✅\n" .
                "🫘 7miss m3a zzit (pois chiches à l'huile d'olive) ✅\n" .
                "🥣 Yaourt + fruits secs ✅\n\n" .
                "Tape **3tini wasfa** + ce que tu veux préparer ! 🍽️";
        }

        // --- SNACK ---
        if (preg_match('/\b(snack|grignoter|en.cas|collation|coupe faim|manger entre|gouter)\b/i', $normalized)) {
            return "🍎 **Snacks sains bla gluten :**\n\n" .
                "🍌 Fruits frais (f7a) — banana, tuffa7, bur9an...\n" .
                "🥜 L9aouia / lo7 (amandes, noix, cajous)\n" .
                "🧀 Fromage + fruits (jben + f7a)\n" .
                "🥕 Légumes crus + houmous (7miss)\n" .
                "🍫 Chocolat noir > 70% (sans gluten souvent ✅)\n" .
                "🫙 Yaourt nature + miel\n" .
                "🌽 Pop-corn nature ✅\n" .
                "🌾 Galettes de riz (roz) ✅\n\n" .
                "🛒 Cherche **biscuits bla gluten** dans [Produits](/products) pour plus d'options !";
        }

        // --- MSEMEN / MLAWI BLA GLUTEN ---
        if (preg_match('/\b(msemen|mlawi|meloui|harcha|baghrir|beghrir)\b/i', $normalized)) {
            return "🫓 **Msemen bla gluten — wasfa :**\n\n" .
                "⏱️ 30 min | 👥 8-10 pièces\n\n" .
                "🧂 **Ingrédients :**\n" .
                "- 200g farine de riz\n" .
                "- 100g fécule de maïs (maïzena)\n" .
                "- 50g farine de sorgho ou millet\n" .
                "- 1 c.café sel\n" .
                "- 1 c.café levure instantanée\n" .
                "- Eau tiède (qdar)\n" .
                "- Huile + beurre pour la cuisson\n\n" .
                "👨‍🍳 **Préparation :**\n" .
                "1. Mélanger les farines + sel + levure\n" .
                "2. Ajouter l'eau tiède petit à petit, pétrir 10 min\n" .
                "3. Laisser reposer 20 min\n" .
                "4. Former des boules, étaler finement, plier en carré\n" .
                "5. Cuire à la poêle avec beurre + huile\n\n" .
                "🍯 Servir avec miel + beurre — Saha w3afiya 😋";
        }

        // --- PIZZA BLA GLUTEN ---
        if (preg_match('/\b(pizza bla gluten|pizza sans gluten|pizza gluten free)\b/i', $normalized)) {
            $recipes = $this->searchRecipes('pizza');
            if (!empty($recipes)) {
                $r = $recipes[0];
                return "🍕 **[{$r['nom']}]({$r['lien']})**\n\n⏱️ {$r['temps']} min\n\n" .
                    "Clique sur le lien pour voir la recette complète ! 😊\n\n" .
                    "💡 Pour la pâte à pizza bla gluten : farine de riz + maïzena + psyllium + levure.";
            }
            return "🍕 **Pâte à pizza bla gluten — recette rapide :**\n\n" .
                "⏱️ 45 min | 👥 2 personnes\n\n" .
                "🧂 **Ingrédients pâte :**\n" .
                "- 200g farine de riz\n" .
                "- 50g maïzena\n" .
                "- 1 c.café psyllium (optionnel, pour lier)\n" .
                "- 1 sachet levure\n" .
                "- 1 c.café sel, 1 c.soupe huile d'olive\n" .
                "- 120ml eau tiède\n\n" .
                "👨‍🍳 Mélanger, pétrir, étaler, garnir, cuire 200°C pendant 15-20 min.\n\n" .
                "Saha w3afiya 🍕😋";
        }

        // --- NAKOL BARRA / RESTAURANT ---
        if (
            preg_match('/\b(nakol barra|restaurant|resto|manger dehors|manger au restaurant|kel barra|sortir manger|fast food bla gluten|fast food)\b/i', $normalized)
            && !preg_match('/\b(fin kayn|wain kayn|adresse)\b/i', $normalized)
        ) {
            return "🍽️ **Conseils pour manger barra (au restaurant) bla gluten :**\n\n" .
                "✅ **Avant de partir :**\n" .
                "- Appele le restaurant, demande s'il a un menu sans gluten\n" .
                "- Utilise **Find Me Gluten Free** app pour trouver des restos adaptés\n\n" .
                "✅ **Au restaurant :**\n" .
                "- Précise : *\"Je suis cœliaque, j'ai besoin d'un repas sans gluten\"*\n" .
                "- Méfie-toi des fritures partagées (contamination croisée)\n" .
                "- Évite les sauces (souvent liées à la farine)\n" .
                "- Salades sans croûtons, viandes grillées, riz = safe\n\n" .
                "✅ **Fast food** : certains ont des options GF (vérifier à chaque fois !)\n\n" .
                "📍 Cherche des **restaurants GF près de toi** dans [Adresses](/locations) 😊";
        }

        // --- 7AFLA / PARTY ---
        if (preg_match('/\b(7afla|hafla|fête|fete|mariage|anniversaire|party|invitation)\b/i', $normalized)) {
            return "🎉 **Chno nakol f 7afla bla gluten :**\n\n" .
                "🥗 Salades composées (salade mrakba) — safe ✅\n" .
                "🍗 Tajine (demander sans épaississant) ✅\n" .
                "🍢 Brochettes (méchoui) ✅\n" .
                "🐟 Poisson grillé ✅\n" .
                "🫘 Mezze : 7miss, zaalouk, taktouka ✅\n" .
                "🍰 **Gâteau** : apporte le tien certifié bla gluten !\n\n" .
                "💡 **Astuce** : Préviens l'hôte/organisateur à l'avance de ton régime.\n" .
                "En cas de doute, emporte des snacks de secours (fruits, chocolat noir, galettes de riz).";
        }

        // --- SAFAR / VOYAGE ---
        if (preg_match('/\b(safar|voyage|voyager|travel|vacances|trip|avion|l9itar|autocar)\b/i', $normalized)) {
            return "✈️ **Chno nakol f safar bla gluten :**\n\n" .
                "🎒 **À préparer avant de partir :**\n" .
                "- Galettes de riz (disponibles partout)\n" .
                "- Fruits secs / lo7 (amandes, noix)\n" .
                "- Chocolat noir > 70%\n" .
                "- Barres énergétiques certifiées GF\n" .
                "- Fruits frais\n\n" .
                "🌍 **Sur place :**\n" .
                "- Cherche \"gluten-free\" ou \"sin gluten\" (Espagne) ou \"senza glutine\" (Italie)\n" .
                "- App **Find Me Gluten Free** pour restos adaptés\n" .
                "- Riz, pommes de terre, viandes grillées = généralement safe\n\n" .
                "📝 **Tip** : Traduis \"Je suis cœliaque\" dans la langue locale avant de partir !";
        }

        // --- MEAL PREP ---
        if (preg_match('/\b(meal prep|préparer à l avance|preparer avance|batch cooking|nih3z makla|njihez wajbat)\b/i', $normalized)) {
            return "📦 **Meal prep bla gluten — plan semaine :**\n\n" .
                "**Dimanche soir :** prépare pour toute la semaine !\n\n" .
                "🍚 **Féculents** : Fais cuire riz, quinoa, lentilles en grande quantité\n" .
                "🍗 **Protéines** : Grille du poulet, cuis des œufs durs, prépare du thon\n" .
                "🥦 **Légumes** : Rôtis au four (batata, carottes, courgettes)\n" .
                "🥗 **Sauces** : Vinaigrette maison (huile + vinaigre + moutarde GF)\n" .
                "🥙 **Assemblage** : Combine selon les jours pour des repas variés\n\n" .
                "📅 **Plan type :**\n" .
                "- Lundi : Riz + poulet + légumes\n" .
                "- Mardi : Salade quinoa + thon\n" .
                "- Mercredi : Soupe lentilles\n" .
                "- Jeudi : Omelette + salade\n" .
                "- Vendredi : Tajine (préparé en avance)\n\n" .
                "💡 Conserve dans des boîtes hermétiques au frigo (3-4 jours max) !";
        }

        // --- GLUTEN FREE = HEALTHY ? ---
        if (preg_match('/\b(gluten free.?healthy|gluten free.?séhat|séhat bla gluten|healthy bla gluten|wach gluten free sahih|bla gluten mzyan|meilleur santé|meilleure sante)\b/i', $normalized)) {
            return "💡 **Wach gluten free = healthy automatiquement ?**\n\n" .
                "❌ **Machi dima !** Voici pourquoi :\n\n" .
                "- Les produits \"gluten free\" industriels contiennent souvent plus de sucre, graisses et additifs pour compenser la texture\n" .
                "- Un biscuit GF n'est pas forcément plus sain qu'un fruit frais\n" .
                "- Pour quelqu'un **sans maladie cœliaque**, éviter le gluten n'apporte aucun bénéfice prouvé\n\n" .
                "✅ **Mais pour les cœliaques et intolérants :** le régime GF est ESSENTIEL et améliore la santé significativement.\n\n" .
                "🌿 **Ce qui est vraiment healthy :** manger des aliments naturels (fruits, légumes, protéines, légumineuses) — qu'ils soient GF ou non ! 😊";
        }

        // --- ALLERGIE VS INTOLERANCE ---
        if (
            preg_match('/\b(allergie vs intolérance|allergie w intolerance|différence allergie|فرق allergie|difference allergy|allergy vs celiac)\b/i', $normalized)
            || preg_match('/الفرق بين/u', $query)
        ) {
            return "🩺 **Allergie vs Intolérance vs Maladie Cœliaque :**\n\n" .
                "| | Allergie au blé | Sensibilité (SGNC) | Maladie Cœliaque |\n" .
                "|---|---|---|---|\n" .
                "| Type | Allergique (IgE) | Intolérance | Auto-immune |\n" .
                "| Lésions intestinales | ❌ Non | ❌ Non | ✅ Oui |\n" .
                "| Urgence possible | ✅ Oui (choc) | ❌ Non | ❌ Non |\n" .
                "| Régime strict | Selon gravité | Oui | Toute la vie |\n\n" .
                "⚠️ **Ana machi tbib** — pour savoir lequel tu as, consulte un médecin ! 🩺";
        }

        // --- KLIT GLUTEN B GHALAT (mangé du gluten par accident) ---
        if (preg_match('/\b(klit gluten b ghalat|mangé gluten accident|gluten b ghalat|3an ghalat klit|accidentally gluten|gluten par erreur)\b/i', $normalized)) {
            return "😰 **Klit gluten b ghalat — chno ndir ?**\n\n" .
                "1️⃣ **Reste calme** — les symptômes varient selon les personnes\n" .
                "2️⃣ **Boire beaucoup d'eau** — pour faciliter l'élimination\n" .
                "3️⃣ **Repos** — le corps a besoin de récupérer\n" .
                "4️⃣ **Évite les aliments lourds** — mange léger : riz, bouillon, fruits\n" .
                "5️⃣ **Note ce qui s'est passé** — pour identifier la source de contamination\n\n" .
                "⏰ **Les symptômes** durent généralement 1-3 jours pour les symptômes digestifs, mais les lésions intestinales prennent plus de temps à guérir.\n\n" .
                "⚠️ *Ana machi tbib. Si les symptômes sont graves, consulte un médecin.*";
        }

        // --- LIFESTYLE / MOTIVATION / SPORT ---
        if (preg_match('/\b(lifestyle|motivation|sport|yoga|bien.être|bienetre|ra7a nafssiya|9a3ida|routine|sehha d nfs)\b/i', $normalized)) {
            return "⚡ **Healthy lifestyle m3a régime bla gluten :**\n\n" .
                "🏃 **Sport** : Dima mzyan ! Fais attention aux barres protéinées (vérifier GF)\n" .
                "🧘 **Yoga / méditation** : Excellent pour gérer le stress du régime\n" .
                "😴 **Sommeil** : 7-8h — essentiel pour la récupération intestinale\n" .
                "💧 **Hydratation** : Boire 1,5-2L d'eau par jour\n" .
                "🥗 **Manger varié** : Ne mange pas toujours la même chose !\n" .
                "📱 **Apps utiles** : Find Me Gluten Free, Yummly GF, Al Imsak\n\n" .
                "💬 Tape **plan l simana** pour un plan repas sur 7 jours ! 😊";
        }

        // --- STRESS ---
        if (preg_match('/\b(stress|anxiété|anxiete|qll l stress|stress dyal regime|stressé|m9elqe)\b/i', $normalized)) {
            return "🧘 **Kif t9ll l stress m3a régime bla gluten :**\n\n" .
                "😤 Il est normal de se sentir stressé — le régime GF demande beaucoup d'attention !\n\n" .
                "✅ **Conseils pratiques :**\n" .
                "- **Prépare à l'avance** : meal prep → moins de stress quotidien\n" .
                "- **Trouve ta communauté** : groupes Facebook cœliaques Maroc\n" .
                "- **Simplifie** : mange naturel (riz, viande, légumes) sans trop calculer\n" .
                "- **Lis les étiquettes** une fois → mémorise tes produits de confiance\n" .
                "- **Respiration / yoga** : 10 min le matin = grosse différence\n\n" .
                "💚 Tu n'es pas seul(e) — la communauté GF est là ! 😊";
        }

        // --- ENERGY / TA9A ---
        if (
            preg_match('/\b(energique|energétique|ta9a|énergie|energie|fatigue|tired|m3iyan|fatigué|nrja3 ta9a)\b/i', $normalized)
            && !preg_match('/\b(cœliaque|celiaque|symptome|maladie)\b/i', $normalized)
        ) {
            return "⚡ **Chno nakol bach nkon energique bla gluten :**\n\n" .
                "🌅 **Ftor (matin)** : Beid + f7a + yaourt → énergie stable\n" .
                "🌿 **Féculents complexes** : Quinoa, roz complet, patate douce\n" .
                "🥜 **Protéines** : Légumineuses, poulet, poisson, œufs\n" .
                "🍫 **Magnésium** : Chocolat noir, amandes (prévient la fatigue)\n" .
                "💊 **Fer & B12** : Les cœliaques sont souvent carencés → demander une analyse\n" .
                "💧 **Hydratation** : Déshydratation = fatigue (bois assez d'eau !)\n\n" .
                "⚠️ Si fatigue persistante, fais vérifier tes carences (fer, B12, vitamine D) chez le médecin 🩺";
        }

        // --- PLAN SIMANA / WEEKLY MEAL PLAN ---
        if (preg_match('/\b(plan l simana|plan semaine|weekly plan|meal plan|plan repas|programme repas|plan hebdo)\b/i', $normalized)) {
            return "📅 **Plan repas bla gluten — 1 semaine :**\n\n" .
                "**LUNDI**\n" .
                "☀️ Ftor: Beid m3a khobz bla gluten + jben\n" .
                "🍽️ Ghda: Riz + djaj m7ammar + salade\n" .
                "🌙 3cha: Soupe l3des\n\n" .
                "**MARDI**\n" .
                "☀️ Ftor: Yaourt + fruits + miel\n" .
                "🍽️ Ghda: Salade quinoa + thon\n" .
                "🌙 3cha: Omelette légumes\n\n" .
                "**MERCREDI**\n" .
                "☀️ Ftor: Pancakes bla gluten\n" .
                "🍽️ Ghda: Tajine djaj (sans sauce farine)\n" .
                "🌙 3cha: 7miss + pain bla gluten\n\n" .
                "**JEUDI-VENDREDI-SAMEDI-DIMANCHE** : Varie avec riz, poisson, légumes...\n\n" .
                "💡 Tape **3tini wasfa** + un plat pour la recette complète ! 🍽️";
        }

        // --- MARQUES / BRANDS GF ---
        if (preg_match('/\b(marque|marques|marca|brand|meilleure marque|ahssan marque|marque gluten free)\b/i', $normalized)) {
            return "🏷️ **Marques / Marcas gluten free connues au Maroc :**\n\n" .
                "🇩🇪 **Schär** — Large gamme : pain, pasta, biscuits, gâteaux\n" .
                "🇬🇧 **Genius** — Pain et viennoiseries\n" .
                "🇫🇷 **Céréal** — Spécialiste GF français\n" .
                "🇺🇸 **Bob's Red Mill** — Farines et céréales\n" .
                "🇮🇹 **Glutafin** — Pasta et farines\n" .
                "🇲🇦 **Produits locaux** — Cherche dans magasins bio et diététiques\n\n" .
                "🛒 **Wfin t9ta3hom au Maroc :**\n" .
                "- Carrefour (section diététique)\n" .
                "- Magasins bio\n" .
                "- Pharmacies et parapharmacies\n" .
                "- Commandes en ligne\n\n" .
                "🛒 Cherche dans notre [Rubrique Produits](/products) ! 😊";
        }

        // --- SUPERMARKET / WFIN NSHRI ---
        if (
            preg_match('/\b(supermarket|supermarché|supermarche|wfin nshri|wfin n9ta3|grandes surfaces|hyper|carrefour|acima|marjane)\b/i', $normalized)
            && !preg_match('/\b(fin kayn|adresse|magasin bla gluten)\b/i', $normalized)
        ) {
            return "🛒 **Wfin t9ta3 produits bla gluten f Maroc :**\n\n" .
                "🏬 **Grandes surfaces :**\n" .
                "- Carrefour → section diététique / bio\n" .
                "- Marjane → rayon spécialisé\n" .
                "- Acima → selon les villes\n\n" .
                "🌿 **Magasins bio :** Meilleure sélection GF certifiée\n\n" .
                "💊 **Pharmacies / Parapharmacies** : certains produits GF médicaux\n\n" .
                "💻 **En ligne :** Jumia, Avito (vendeurs spécialisés)\n\n" .
                "📍 Cherche des **magasins spécialisés** dans [Adresses](/locations) 😊";
        }

        // --- DEFAULT FALLBACK ---
        return "Machi mushkil 😊 Hna ach n9der n3awnek bih :\n\n" .
            "🛒 **Produits** → tape le nom du produit\n" .
            "🍽️ **Recettes** → \"3tini wasfa\" ou \"recette + plat\"\n" .
            "📍 **Adresses** → \"fin kayn magasin f [ville]\"\n" .
            "🌾 **Info gluten** → \"chno howa gluten\", \"wach riz fih gluten\"\n" .
            "🩺 **Santé** → \"chno hiya celiac\", \"a3rad intolerance\"\n" .
            "🆘 **Aide** → tape **help**\n\n" .
            "Kifach n9der n3awnek ? 😊";
    }

    /**
     * Pre-fetch real DB data (products / recipes / locations) based on keyword detection
     * and return a formatted block ready to be injected into the Groq system prompt.
     * This prevents model hallucination: Groq only formats data we provide.
     */
    private function prefetchDatabaseContext(string $query, $latitude = null, $longitude = null): string
    {
        $normalized = mb_strtolower(trim(preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $query)));
        $normalized = preg_replace('/\s+/', ' ', $normalized);

        // --- Location: city detected ---
        $cityMap = [
            'casablanca|casa|dar lbida'       => 'Casablanca',
            'rabat|rbat'                      => 'Rabat',
            'marrakech|kech|merrakch'         => 'Marrakech',
            'tanger|tanja'                    => 'Tanger',
            'fès|fes|fas'                     => 'Fès',
            'agadir'                          => 'Agadir',
            'oujda'                           => 'Oujda',
            'nador'                           => 'Nador',
            'meknes|meknas|meknès'            => 'Meknès',
            'tetouan|ttouan|tétouan'          => 'Tétouan',
            'el jadida|eljadida'              => 'El Jadida',
            'kenitra|kénitra'                 => 'Kénitra',
            'salé|sale'                       => 'Salé',
        ];

        foreach ($cityMap as $pattern => $city) {
            if (preg_match('/\b(' . $pattern . ')\b/i', $normalized)) {
                $locations = $this->searchLocations($city);
                if (!empty($locations)) {
                    $lines = ["📍 DONNÉES RÉELLES — Établissements sans gluten à {$city} (source: base de données du site) :"];
                    foreach ($locations as $loc) {
                        $lines[] = "• {$loc['nom']} — {$loc['adresse']}  Lien: {$loc['lien']}";
                    }
                    $lines[] = "(Utilise UNIQUEMENT ces données. N'invente aucun autre établissement.)";
                    return implode("\n", $lines);
                }
                return "📍 Aucun établissement sans gluten trouvé dans notre base pour {$city}.";
            }
        }

        // --- Location: near me ---
        if ($latitude !== null && $longitude !== null
            && preg_match('/\b(près|proche|autour|near|pres|qrib|3andi)\b/i', $normalized)) {
            $locations = $this->searchNearestLocations($latitude, $longitude);
            if (!empty($locations)) {
                $lines = ["📍 DONNÉES RÉELLES — Établissements proches (source: base de données) :"];
                foreach ($locations as $loc) {
                    $lines[] = "• {$loc['nom']} — {$loc['adresse']} ({$loc['distance']} km)  Lien: {$loc['lien']}";
                }
                $lines[] = "(Utilise UNIQUEMENT ces données. N'invente aucun autre établissement.)";
                return implode("\n", $lines);
            }
        }

        // --- Recipe request ---
        if (preg_match('/\b(recette|wasfa|wsfat|recipe|plat|dessert|gâteau|gateau|pizza|tajine|couscous|msemen|mlawi|harcha|ftor|breakfast|ftour|3tini|kifach|wasfa dyal|idée repas|idee repas)\b/i', $normalized)) {
            $recipeQuery = preg_replace('/\b(recette|wasfa|wsfat|recipe|sans gluten|bla gluten|idée|idee|donne|donnez|cherche|une|des|de|du|le|la|3tini|bghit|sahla|wsri3a|rapide|facile|dyal)\b/iu', ' ', $normalized);
            $recipeQuery = trim(preg_replace('/\s+/', ' ', $recipeQuery)) ?: 'recette';
            $recipes     = $this->searchRecipes($recipeQuery);
            if (!empty($recipes)) {
                $lines = ["🍽️ DONNÉES RÉELLES — Recettes sans gluten (source: base de données du site) :"];
                foreach ($recipes as $r) {
                    $ings  = array_slice($r['ingredients'], 0, 5);
                    $steps = array_slice($r['steps'], 0, 3);
                    $lines[] = "• **{$r['nom']}** — Temps: {$r['temps']} min  Lien: {$r['lien']}";
                    $lines[] = "  Ingrédients: " . implode(', ', $ings) . (count($r['ingredients']) > 5 ? '...' : '');
                    if (!empty($steps)) {
                        $lines[] = "  Étapes: " . implode(' | ', $steps);
                    }
                }
                $lines[] = "(Présente ces recettes avec leurs ingrédients et étapes. N'invente aucun autre plat.)";
                return implode("\n", $lines);
            }
            return ''; // Let Groq suggest from general knowledge when DB is empty
        }

        // --- Product request (not recipe) ---
        if (preg_match('/\b(produit|pain|farine|pâte|pates|biscuit|chocolat|yaourt|lait|confiture|sauce|gateau|gâteau|céréale|cereale|beurre|huile|vinaigre|pasta|spaghetti|cracker|granola)\b/i', $normalized)
            && !preg_match('/recette|wasfa|recipe|comment faire|kifach/i', $normalized)) {

            $productQuery = preg_replace('/\b(produit|produits|acheter|trouver|chercher|sans|gluten|bla|des|du|de|le|la|un|une|les|ou|fin|wfin|njibu|nshri)\b/iu', ' ', $normalized);
            $productQuery = trim(preg_replace('/\s+/', ' ', $productQuery)) ?: 'pain';
            $products     = $this->searchProducts($productQuery);
            if (!empty($products)) {
                $lines = ["🛒 DONNÉES RÉELLES — Produits sans gluten (source: base de données du site) :"];
                foreach ($products as $p) {
                    $lines[] = "• **{$p['nom']}** — {$p['prix']}  Lien: {$p['lien']}";
                    $lines[] = "  {$p['description']}";
                }
                $lines[] = "(Présente uniquement ces produits. N'invente aucun autre produit.)";
                return implode("\n", $lines);
            }
            return ''; // No DB results — Groq answers from general knowledge
        }

        return ''; // No DB lookup needed — Groq answers freely from its knowledge
    }

    private function searchProducts(string $query): array
    {
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        return $products->map(function ($product) {
            return [
                'nom' => $product->name,
                'prix' => $product->price . ' MAD',
                'description' => substr(strip_tags($product->description), 0, 100) . '...',
                'lien' => route('products.show', $product->id),
            ];
        })->toArray();
    }

    private function searchRecipes(string $query): array
    {
        $normalizedQuery = mb_strtolower(trim($query));

        if (in_array($normalizedQuery, ['dessert', 'desserts', 'gâteau', 'gateau', 'sweet', 'gourmand', 'sucré', 'sucre', 'hlwa', 'ka3ba'])) {
            $recipes = Recipe::approved()
                ->where(function ($q) {
                    $q->where('name', 'like', '%chocolat%')
                        ->orWhere('name', 'like', '%brownie%')
                        ->orWhere('name', 'like', '%pancake%')
                        ->orWhere('ingredients', 'like', '%sucre%')
                        ->orWhere('ingredients', 'like', '%chocolat%');
                })
                ->limit(5)
                ->get();
        } elseif (in_array($normalizedQuery, ['plat', 'plats', 'repas', 'dîner', 'diner', 'déjeuner', 'dejeuner', 'salé', 'sale', 'wajba', 'makla'])) {
            $recipes = Recipe::approved()
                ->where(function ($q) {
                    $q->where('name', 'like', '%pizza%')
                        ->orWhere('ingredients', 'like', '%tomate%')
                        ->orWhere('ingredients', 'like', '%sel%');
                })
                ->limit(5)
                ->get();
        } else {
            $recipes = Recipe::approved()
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('ingredients', 'like', "%{$query}%");
                })
                ->limit(5)
                ->get();
        }

        return $recipes->map(function ($recipe) {
            return [
                'nom' => $recipe->name,
                'difficulte' => $recipe->difficulty ?? 'Facile',
                'temps' => $recipe->prep_time ?? 15,
                'ingredients' => is_array($recipe->ingredients) ? $recipe->ingredients : json_decode($recipe->ingredients, true) ?? [],
                'steps' => is_array($recipe->steps) ? $recipe->steps : json_decode($recipe->steps, true) ?? [],
                'lien' => route('recipes.show', $recipe->id),
            ];
        })->toArray();
    }

    private function searchLocations(string $city): array
    {
        $locations = Location::approved()
            ->where('city', 'like', "%{$city}%")
            ->limit(5)
            ->get();

        return $locations->map(function ($location) {
            return [
                'nom' => $location->name,
                'adresse' => $location->address,
                'ville' => $location->city,
                'lien' => route('locations.show', $location->id),
            ];
        })->toArray();
    }

    private function searchNearestLocations(float $latitude, float $longitude): array
    {
        $locations = Location::approved()
            ->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$latitude, $longitude, $latitude])
            ->orderBy('distance', 'asc')
            ->limit(5)
            ->get();

        return $locations->map(function ($loc) {
            return [
                'nom' => $loc->name,
                'adresse' => $loc->address,
                'distance' => round($loc->distance, 1),
                'lien' => route('locations.show', $loc->id),
            ];
        })->toArray();
    }

    public function indexConversations()
    {
        $conversations = ChatConversation::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get(['id', 'title', 'updated_at']);

        return response()->json($conversations)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    public function storeConversation()
    {
        $conversation = ChatConversation::create([
            'user_id' => Auth::id(),
            'title' => 'Nouvelle discussion',
            'messages' => [],
        ]);

        return response()->json($conversation);
    }

    public function showConversation(ChatConversation $conversation)
    {
        if ((int) $conversation->user_id !== (int) Auth::id()) {
            abort(403);
        }

        return response()->json($conversation);
    }

    public function updateConversation(Request $request, ChatConversation $conversation)
    {
        if ((int) $conversation->user_id !== (int) Auth::id()) {
            return response()->json(['error' => 'Interdit.'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:100',
        ]);

        try {
            $conversation->update(['title' => $request->input('title')]);

            return response()->json([
                'id' => $conversation->id,
                'title' => $conversation->title,
            ]);
        } catch (\Throwable $e) {
            Log::error('updateConversation: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la mise à jour.'], 500);
        }
    }

    public function destroyConversation(ChatConversation $conversation)
    {
        if ((int) $conversation->user_id !== (int) Auth::id()) {
            return response()->json(['error' => 'Interdit.'], 403);
        }

        try {
            $conversation->delete();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('destroyConversation: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la suppression.'], 500);
        }
    }
}
