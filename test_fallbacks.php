<?php

// Bootstrap Laravel using absolute paths
require 'c:/Users/lenovo/OneDrive/Desktop/GlutenFree_Guide/vendor/autoload.php';
$app = require_once 'c:/Users/lenovo/OneDrive/Desktop/GlutenFree_Guide/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\ChatbotController;
use Illuminate\Http\Request;

$controller = new ChatbotController();

echo "=========================================================\n";
echo "TESTING GLUTO ADVANCED NEW FEATURES & INTENTS\n";
echo "=========================================================\n\n";

// 1. Single Prompt Queries
$singleQueries = [
    "Bonjour",
    "Chercher du pain sans gluten",
    "recette rapide",
    "magasins à Tanger",
    "restaurants à Casablanca",
    "mal au ventre après gluten",
    "Quels aliments autorisés ?",
    "Quels aliments interdits ?",
    "Le riz contient-il du gluten ?",
    "merci"
];

foreach ($singleQueries as $q) {
    echo "--- User: $q ---\n";
    
    $request = Request::create('/chatbot', 'POST', [
        'messages' => [
            ['role' => 'user', 'content' => $q]
        ]
    ]);
    $app->instance('request', $request);
    
    try {
        $response = $controller->chat($request);
        $data = json_decode($response->getContent(), true);
        echo "Gluto:\n" . $data['message'] . "\n\n";
    } catch (\Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n\n";
    }
}

// 2. Geolocation Proximity Queries
echo "=========================================================\n";
echo "TESTING GEOLOCATION PROXIMITY QUERIES\n";
echo "=========================================================\n\n";

// A. Without coordinates
echo "--- Proximity without coordinates ---\n";
$requestNoCoords = Request::create('/chatbot', 'POST', [
    'messages' => [
        ['role' => 'user', 'content' => "magasin proche de moi"]
    ]
]);
$app->instance('request', $requestNoCoords);
try {
    $response = $controller->chat($requestNoCoords);
    $data = json_decode($response->getContent(), true);
    echo "Gluto:\n" . $data['message'] . "\n\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n\n";
}

// B. With coordinates (Casablanca region approximately)
echo "--- Proximity WITH coordinates (Casablanca 33.5731, -7.5898) ---\n";
$requestWithCoords = Request::create('/chatbot', 'POST', [
    'messages' => [
        ['role' => 'user', 'content' => "restaurants autour de moi"]
    ],
    'latitude' => 33.5731,
    'longitude' => -7.5898
]);
$app->instance('request', $requestWithCoords);
try {
    $response = $controller->chat($requestWithCoords);
    $data = json_decode($response->getContent(), true);
    echo "Gluto:\n" . $data['message'] . "\n\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n\n";
}


// 3. Contextual Continuation Queries
echo "=========================================================\n";
echo "TESTING CONTEXTUAL CONTINUATION FLOWS\n";
echo "=========================================================\n\n";

$contextTests = [
    "Cœliaque continuation with extra words" => [
        ['role' => 'user', 'content' => "C’est quoi la maladie cœliaque ?"],
        ['role' => 'assistant', 'content' => "🩺 La maladie cœliaque est..."],
        ['role' => 'user', 'content' => "plus de details"]
    ],
    "Generic Recipe Fallback continuation" => [
        ['role' => 'user', 'content' => "recette facile"],
        ['role' => 'assistant', 'content' => "1️⃣ Omelette fromage & légumes\n⏱️ 10 min\n\n2️⃣ Pancakes sans gluten\n⏱️ 15 min\n\n3️⃣ Salade quinoa poulet\n⏱️ 20 min\n\n4️⃣ Brownie sans gluten\n⏱️ 25 min"],
        ['role' => 'user', 'content' => "détails"]
    ],
    "Magasin continuation" => [
        ['role' => 'user', 'content' => "Magasins à Casablanca"],
        ['role' => 'assistant', 'content' => "📍 Adresses..."],
        ['role' => 'user', 'content' => "details"]
    ]
];

foreach ($contextTests as $label => $history) {
    echo "--- Context Test: $label ---\n";
    echo "User sent: " . end($history)['content'] . " (previous query: " . $history[0]['content'] . ")\n";
    
    $request = Request::create('/chatbot', 'POST', [
        'messages' => $history
    ]);
    $app->instance('request', $request);
    
    try {
        $response = $controller->chat($request);
        $data = json_decode($response->getContent(), true);
        echo "Gluto:\n" . $data['message'] . "\n\n";
    } catch (\Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n\n";
    }
}
