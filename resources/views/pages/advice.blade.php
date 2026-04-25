@extends('main')

@section('title', __('Conseils d\'Experts - Guide Gluten-Free'))

@section('content')
<section class="section pt-5 mt-5 overflow-hidden">
    <div class="container py-5 mt-4">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 text-center" data-aos="fade-up">
                <span class="badge bg-soft text-main px-4 py-2 rounded-pill mb-4 border border-color shadow-sm animate-bounce-slow">
                    <i class="fas fa-user-md me-2 text-success"></i>{{ __('Expertise Médicale Certifiée') }}
                </span>
                <h1 class="display-3 fw-bold mb-4 brand-font text-gradient">{{ __('Conseils de Spécialistes') }}</h1>
                <p class="lead opacity-75 fs-4 mb-5 mx-auto" style="max-width: 800px;">
                    {{ __('La maladie cœliaque nécessite une approche multidisciplinaire. Nos experts partenaires vous guident vers une vie saine et sans compromis.') }}
                </p>
                <div class="d-flex justify-content-center gap-3 mb-5">
                    <a href="#adviceAccordion" class="btn btn-main btn-lg rounded-pill px-5 shadow-lg">{{ __('Lire les recommandations') }}</a>
                    <a href="#experts" class="btn btn-soft-secondary btn-lg rounded-pill px-5">{{ __('Nos experts') }}</a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center" id="expert-advice">
            <div class="col-lg-9 mx-auto">
                <div class="accordion accordion-flush custom-modern-accordion shadow-2xl rounded-5 overflow-hidden border border-color glass" id="adviceAccordion">
                    
                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold fs-5 p-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                <span class="icon-circle bg-soft text-main me-3"><i class="fas fa-stethoscope"></i></span>
                                {{ __('1. Suivi médical régulier (Gastro-entérologue)') }}
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#adviceAccordion">
                            <div class="accordion-body p-4 glass shadow-sm rounded-4">
                                <div class="px-md-4">
                                    <p class="mb-4 fs-6 opacity-75">{{ __('Le diagnostic n’est que la première étape. Un suivi rigoureux permet de vérifier la cicatrisation de l’intestin :') }}</p>
                                    <div class="row g-4 mb-4">
                                        <div class="col-md-6">
                                            <div class="p-3 rounded-4 border border-color bg-white-adaptive shadow-sm h-100">
                                                <h6 class="fw-bold text-main mb-2"><i class="fas fa-vial me-2 text-primary"></i>{{ __('Analyses de sang') }}</h6>
                                                <p class="small opacity-75 mb-0">{{ __('Mesurer le taux d’anticorps (anti-transglutaminase) pour confirmer le succès du régime.') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 rounded-4 border border-color bg-white-adaptive shadow-sm h-100">
                                                <h6 class="fw-bold text-main mb-2"><i class="fas fa-bone me-2 text-warning"></i>{{ __('Densitométrie osseuse') }}</h6>
                                                <p class="small opacity-75 mb-0">{{ __('Vérifier l’absence d’ostéoporose liée à la malabsorption du calcium.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-soft rounded-4 border border-color">
                                        <p class="small text-main fw-bold mb-0">
                                            <i class="fas fa-info-circle me-2"></i>{{ __('Fréquence conseillée : Tous les 6 à 12 mois selon l’évolution des symptômes.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold fs-5 p-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                <span class="icon-circle bg-soft text-success me-3"><i class="fas fa-leaf"></i></span>
                                {{ __('2. Régime strict sans gluten (Nutritionniste)') }}
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#adviceAccordion">
                            <div class="accordion-body p-4 glass shadow-sm rounded-4">
                                <div class="px-md-4">
                                    <div class="alert alert-warning border-0 rounded-4 shadow-sm mb-4">
                                        <div class="d-flex gap-3">
                                            <i class="fas fa-exclamation-triangle mt-1"></i>
                                            <p class="mb-0 fw-bold">{{ __('Le seul traitement est l’éviction totale et définitive du gluten.') }}</p>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <h6 class="text-danger fw-bold border-bottom pb-3 mb-3"><i class="fas fa-times-circle me-2"></i>{{ __('Interdits (SABOT)') }}</h6>
                                            <div class="d-flex flex-wrap gap-2 mb-3">
                                                <span class="badge bg-danger rounded-pill px-3">{{ __('Seigle') }}</span>
                                                <span class="badge bg-danger rounded-pill px-3">{{ __('Avoine') }}</span>
                                                <span class="badge bg-danger rounded-pill px-3">{{ __('Blé') }}</span>
                                                <span class="badge bg-danger rounded-pill px-3">{{ __('Orge') }}</span>
                                                <span class="badge bg-danger rounded-pill px-3">{{ __('Triticale') }}</span>
                                            </div>
                                            <p class="small italic text-muted">{{ __('Attention aux sauces, bouillons cubes et charcuteries.') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-success fw-bold border-bottom pb-3 mb-3"><i class="fas fa-check-circle me-2"></i>{{ __('Alternatives Sûres') }}</h6>
                                            <p class="small opacity-75">{{ __('Riz, Maïs, Quinoa, Sarrasin, Pois chiche, Pommes de terre, Légumineuses, Viandes et Poissons frais.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold fs-5 p-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                <span class="icon-circle bg-soft text-danger me-3"><i class="fas fa-shield-virus"></i></span>
                                {{ __('3. Éviter la contamination croisée') }}
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#adviceAccordion">
                            <div class="accordion-body p-4 glass shadow-sm rounded-4">
                                <div class="px-md-4">
                                    <div class="row g-4">
                                        <div class="col-md-4 text-center" data-aos="zoom-in">
                                            <div class="p-4 rounded-5 border border-color bg-white-adaptive shadow-sm h-100 hover-up transition-all">
                                                <div class="fs-1 mb-3">🔪</div>
                                                <h6 class="fw-bold mb-2">{{ __('Ustensiles') }}</h6>
                                                <p class="x-small opacity-75 mb-0">{{ __('Utilisez une planche à découper et un grille-pain dédiés.') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center" data-aos="zoom-in" data-aos-delay="100">
                                            <div class="p-4 rounded-5 border border-color bg-white-adaptive shadow-sm h-100 hover-up transition-all">
                                                <div class="fs-1 mb-3">🧊</div>
                                                <h6 class="fw-bold mb-2">{{ __('Rangement') }}</h6>
                                                <p class="x-small opacity-75 mb-0">{{ __('Placez les produits sans gluten en haut des placards.') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center" data-aos="zoom-in" data-aos-delay="200">
                                            <div class="p-4 rounded-5 border border-color bg-white-adaptive shadow-sm h-100 hover-up transition-all">
                                                <div class="fs-1 mb-3">🧼</div>
                                                <h6 class="fw-bold mb-2">{{ __('Hygiène') }}</h6>
                                                <p class="x-small opacity-75 mb-0">{{ __('Lavez-vous les mains après avoir manipulé du blé.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold fs-5 p-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                <span class="icon-circle bg-soft text-purple me-3"><i class="fas fa-capsules"></i></span>
                                {{ __('4. Corriger les carences nutritionnelles') }}
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#adviceAccordion">
                            <div class="accordion-body p-4 glass shadow-sm rounded-4">
                                <div class="px-md-4">
                                    <p class="mb-4 opacity-75">{{ __('La malabsorption intestinale provoque souvent des carences invisibles. Priorisez :') }}</p>
                                    <div class="d-flex flex-column gap-3">
                                        <div class="d-flex align-items-center gap-3 p-3 rounded-4 bg-white-adaptive border border-color shadow-sm">
                                            <div class="icon-circle-sm bg-danger-soft text-danger"><i class="fas fa-tint"></i></div>
                                            <div class="flex-grow-1"><h6 class="fw-bold mb-0 text-main">{{ __('Fer') }}</h6> <small class="opacity-50">{{ __('Contre l’anémie (viande rouge, lentilles)') }}</small></div>
                                        </div>
                                        <div class="d-flex align-items-center gap-3 p-3 rounded-4 bg-white-adaptive border border-color shadow-sm">
                                            <div class="icon-circle-sm bg-primary-soft text-primary"><i class="fas fa-sun"></i></div>
                                            <div class="flex-grow-1"><h6 class="fw-bold mb-0 text-main">{{ __('Calcium & Vitamine D') }}</h6> <small class="opacity-50">{{ __('Pour la solidité des os') }}</small></div>
                                        </div>
                                        <div class="d-flex align-items-center gap-3 p-3 rounded-4 bg-white-adaptive border border-color shadow-sm">
                                            <div class="icon-circle-sm bg-success-soft text-success"><i class="fas fa-bolt"></i></div>
                                            <div class="flex-grow-1"><h6 class="fw-bold mb-0 text-main">{{ __('Magnésium & Vitamine B12') }}</h6> <small class="opacity-50">{{ __('Pour lutter contre la fatigue') }}</small></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold fs-5 p-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                <span class="icon-circle bg-soft text-info me-3"><i class="fas fa-brain"></i></span>
                                {{ __('5. Soutien psychologique et éducation') }}
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#adviceAccordion">
                            <div class="accordion-body p-4 glass shadow-sm rounded-4">
                                <div class="px-md-4">
                                    <p class="mb-4 opacity-75">{{ __('Vivre sans gluten peut être difficile :') }}</p>
                                    <div class="row g-4 mb-4">
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white-adaptive rounded-4 border border-color shadow-sm">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="mb-2"><i class="fas fa-exclamation-circle text-warning me-2"></i>{{ __('Stress social (sorties, voyages)') }}</li>
                                                    <li><i class="fas fa-utensils text-danger me-2"></i>{{ __('Frustration alimentaire') }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white-adaptive rounded-4 border border-color shadow-sm">
                                                <h6 class="fw-bold text-main mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Conseils :') }}</h6>
                                                <ul class="small list-unstyled mb-0 opacity-75">
                                                    <li>{{ __('Rejoindre des associations de patients') }}</li>
                                                    <li>{{ __('S’informer et apprendre à cuisiner sans gluten') }}</li>
                                                    <li>{{ __('Consulter si besoin un psychologue') }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold fs-5 p-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                                <span class="icon-circle bg-soft text-warning me-3"><i class="fas fa-baby"></i></span>
                                {{ __('6. Cas particuliers (enfants et adolescents)') }}
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#adviceAccordion">
                            <div class="accordion-body p-4 glass shadow-sm rounded-4">
                                <div class="px-md-4">
                                    <div class="d-flex flex-column gap-3">
                                        <div class="p-3 bg-white-adaptive rounded-4 border border-color shadow-sm d-flex align-items-center gap-3">
                                            <i class="fas fa-chart-line text-primary"></i>
                                            <span>{{ __('Surveiller la croissance') }}</span>
                                        </div>
                                        <div class="p-3 bg-white-adaptive rounded-4 border border-color shadow-sm d-flex align-items-center gap-3">
                                            <i class="fas fa-school text-info"></i>
                                            <span>{{ __('Adapter l’alimentation à l’école') }}</span>
                                        </div>
                                        <div class="p-3 bg-white-adaptive rounded-4 border border-color shadow-sm d-flex align-items-center gap-3">
                                            <i class="fas fa-user-tie text-secondary"></i>
                                            <span>{{ __('Informer les enseignants') }}</span>
                                        </div>
                                    </div>
                                    <div class="alert alert-info border-0 rounded-4 mt-4 shadow-sm">
                                        <i class="fas fa-long-arrow-alt-right me-2"></i>{{ __('Le diagnostic précoce évite des complications à long terme.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold fs-5 p-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven">
                                <span class="icon-circle bg-soft text-danger me-3"><i class="fas fa-vial"></i></span>
                                {{ __('7. Importance du dépistage familial') }}
                            </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#adviceAccordion">
                            <div class="accordion-body p-4 glass shadow-sm rounded-4">
                                <div class="px-md-4">
                                    <p class="mb-4 opacity-75">{{ __('La maladie peut être héréditaire :') }}</p>
                                    <div class="p-4 bg-white-adaptive rounded-5 border border-color shadow-sm">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <i class="fas fa-check-circle text-success fs-5"></i>
                                            <span class="fw-bold">{{ __('Tester les membres de la famille proche') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fas fa-check-circle text-success fs-5"></i>
                                            <span class="fw-bold">{{ __('Surtout si symptômes digestifs ou fatigue chronique') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold fs-5 p-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight">
                                <span class="icon-circle bg-soft text-success me-3"><i class="fas fa-globe-africa"></i></span>
                                {{ __('8. Mode de vie recommandé') }}
                            </button>
                        </h2>
                        <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#adviceAccordion">
                            <div class="accordion-body p-4 glass shadow-sm rounded-4">
                                <div class="px-md-4">
                                    <div class="row g-4">
                                        <div class="col-md-3 col-6 text-center">
                                            <div class="p-3 bg-white-adaptive rounded-4 border border-color shadow-sm hover-up transition-all">
                                                <div class="fs-2 mb-2">🏃‍♀️</div>
                                                <span class="small fw-bold">{{ __('Activité physique régulière') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 text-center">
                                            <div class="p-3 bg-white-adaptive rounded-4 border border-color shadow-sm hover-up transition-all">
                                                <div class="fs-2 mb-2">🥗</div>
                                                <span class="small fw-bold">{{ __('Alimentation équilibrée') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 text-center">
                                            <div class="p-3 bg-white-adaptive rounded-4 border border-color shadow-sm hover-up transition-all">
                                                <div class="fs-2 mb-2">😴</div>
                                                <span class="small fw-bold">{{ __('Bon sommeil') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 text-center">
                                            <div class="p-3 bg-white-adaptive rounded-4 border border-color shadow-sm hover-up transition-all">
                                                <div class="fs-2 mb-2">🚭</div>
                                                <span class="small fw-bold">{{ __('Éviter le tabac') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-5 g-4" id="experts">
            <div class="col-12 text-center mb-5" data-aos="fade-up">
                <h2 class="brand-font fw-bold display-5">{{ __('Rencontrez nos Experts') }}</h2>
                <p class="opacity-75 fs-5">{{ __('Les avis qui guident notre communauté.') }}</p>
            </div>

            @php
                $experts = [
                    ['name' => 'Dr. Hassan Belabbes', 'role' => 'Gastro-entérologue', 'icon' => 'user-md', 'color' => 'primary', 'quote' => 'Le diagnostic de la maladie cœliaque se fait par dosage sérologique des anticorps suivi d\'une biopsie si nécessaire.', 'recs' => ['Bilan de santé annuel', 'Vérifier la densité osseuse']],
                    ['name' => 'Mme. Laila Mansouri', 'role' => 'Nutritionniste-Diététicienne', 'icon' => 'stethoscope', 'color' => 'success', 'quote' => 'Éviter le gluten ne signifie pas manger gras ou sucré. Les produits transformés sont souvent riches en additifs.', 'recs' => ['Privilégiez les aliments bruts', 'Attention aux carences en fibres']],
                    ['name' => 'Dr. Amina Tazi', 'role' => 'Pédiatre Spécialiste', 'icon' => 'baby', 'color' => 'warning', 'quote' => 'Chez l\'enfant, les signes peuvent être atypiques : irritabilité ou simple fatigue. Une vigilance parentale est la clé.', 'recs' => ['Surveiller les courbes de croissance', 'Éduquer sans créer de peur']],
                    ['name' => 'M. Youssef Alami', 'role' => 'Psychologue Clinicien', 'icon' => 'brain', 'color' => 'danger', 'quote' => 'Accepter un régime restrictif est un processus émotionnel. Le stress social ne doit pas isoler le patient.', 'recs' => ['Rejoindre des groupes de parole', 'Communiquer sereinement']],
                ];
            @endphp

            @foreach($experts as $idx => $expert)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $idx * 100 }}">
                <div class="card expert-card h-100 border-0 shadow-sm glass p-4 rounded-5 text-center">
                    <div class="icon-circle bg-{{ $expert['color'] }} text-white mx-auto mb-4 p-4 shadow-lg scale-hover" style="width: 80px; height: 80px;">
                        <i class="fas fa-{{ $expert['icon'] }} fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-1 brand-font">{{ __($expert['name']) }}</h5>
                    <small class="badge bg-soft text-main border border-color mb-3 rounded-pill">{{ __($expert['role']) }}</small>
                    <div class="mb-4">
                        <i class="fas fa-quote-left text-main opacity-25 d-block mb-2"></i>
                        <p class="small opacity-75 italic mb-0 px-2 line-clamp-3">"{{ __($expert['quote']) }}"</p>
                    </div>
                    <div class="mt-auto pt-3 border-top border-color">
                        <button class="btn btn-sm btn-outline-main rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#expertModal{{ $idx }}">
                            {{ __('Détails') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Expert Modal -->
            <div class="modal fade" id="expertModal{{ $idx }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content card-custom border-0 shadow-lg rounded-5 overflow-hidden">
                        <div class="modal-header border-0 bg-soft p-4">
                            <h5 class="modal-title fw-bold brand-font text-main"><i class="fas fa-info-circle me-2"></i>{{ __('Recommandations de l\'expert') }}</h5>
                            <button type="button" class="btn-close shadow-sm rounded-circle bg-white p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="text-center mb-4">
                                <h4 class="fw-bold text-main mb-1">{{ __($expert['name']) }}</h4>
                                <span class="badge bg-main-soft text-main px-3 py-1 rounded-pill">{{ __($expert['role']) }}</span>
                            </div>
                            <div class="p-4 bg-soft rounded-4 border border-color mb-4 shadow-inner">
                                <h6 class="fw-bold text-main border-bottom pb-2 mb-3"><i class="fas fa-lightbulb me-2 text-warning"></i>{{ __('Points Clés') }}</h6>
                                <ul class="list-unstyled mb-0">
                                    @foreach($expert['recs'] as $rec)
                                        <li class="d-flex align-items-start gap-3 mb-3">
                                            <i class="fas fa-check-circle text-success mt-1"></i>
                                            <span class="small opacity-75">{{ __($rec) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <p class="small italic text-center opacity-50 px-3">"{{ __($expert['quote']) }}"</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="card card-custom p-5 mt-5 border-0 shadow-2xl text-center glass rounded-5" data-aos="zoom-in">
            <div class="mx-auto bg-warning-soft text-warning icon-circle mb-4 p-4 shadow-sm" style="width: 80px; height: 80px;">
                <i class="fas fa-exclamation-triangle fs-2"></i>
            </div>
            <h4 class="fw-bold brand-font text-main mb-3">{{ __('Avertissement Médical') }}</h4>
            <p class="mb-0 opacity-75 fs-5 mx-auto" style="max-width: 700px;">
                {{ __('Les informations présentées sur cette page sont données à titre indicatif et ne remplacent en aucun cas un avis médical personnalisé. En cas de doute, consultez toujours votre médecin traitant.') }}
            </p>
        </div>
    </div>
</section>

<style>
    .text-gradient { background: linear-gradient(90deg, var(--btn-bg), #4a6318); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .shadow-2xl { box-shadow: 0 40px 80px -20px rgba(0,0,0,0.1); }
    .custom-modern-accordion .accordion-item { border: none !important; margin-bottom: 10px; border-radius: 15px !important; }
    .custom-modern-accordion .accordion-button { transition: 0.3s; background: transparent; border-radius: 15px !important; border: 1px solid rgba(0,0,0,0.03); }
    .custom-modern-accordion .accordion-button:not(.collapsed) { background: rgba(107, 142, 35, 0.05); color: var(--btn-bg); border-color: var(--btn-bg); }
    .custom-modern-accordion .accordion-button:hover { background: rgba(0,0,0,0.02); }
    .icon-circle { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
    .icon-circle-sm { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-main-soft { background-color: rgba(107, 142, 35, 0.1); }
    .text-purple { color: #6f42c1; }
    .animate-bounce-slow { animation: bounce 3s infinite; }
    @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    .expert-card { transition: 0.4s; border: 1px solid rgba(0,0,0,0.03) !important; }
    .expert-card:hover { transform: translateY(-15px); box-shadow: 0 30px 60px rgba(0,0,0,0.1) !important; border-color: var(--btn-bg) !important; }
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05); }
    .scale-hover:hover { transform: scale(1.1); }
</style>
@endsection