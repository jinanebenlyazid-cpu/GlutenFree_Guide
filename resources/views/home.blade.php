@extends('main')

@section('title', __('Accueil - Guide Gluten-Free'))

@section('content')
<!-- HERO SECTION -->
<section class="hero position-relative overflow-hidden pt-5 pb-5 pt-lg-7 pb-lg-9">
    <div class="container mt-4 pt-5">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start" data-aos="fade-right">
                <span class="badge bg-soft text-main px-3 py-2 rounded-pill mb-4 border border-color shadow-sm animate-fade-in">
                    <i class="fas fa-leaf me-1" style="color: var(--btn-bg);"></i> 
                    {{ __('La première plateforme 100% Sans Gluten au Maroc') }}
                </span>
                <h1 class="display-3 fw-bold mb-4 brand-font lh-1">
                    {{ __('Trouvez du') }} <span style="color: var(--btn-bg);">sans gluten</span><br>
                    {{ __('près de chez vous') }} 🌿
                </h1>
                <p class="lead mb-4 opacity-75 pe-lg-5">
                    {{ __('Une communauté dédiée pour découvrir des produits sains, trouver des restaurants adaptés et partager de délicieuses recettes marocaines.') }}
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-main px-4 py-3 shadow-md">
                        <i class="fas fa-search me-2"></i>{{ __('Explorer les produits') }}
                    </a>
                    <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary px-4 py-3 rounded-pill  border-color fw-bold">
                        <i class="fas fa-map-marker-alt me-2" style="color: var(--btn-bg);"></i>{{ __('Voir la carte') }}
                    </a>
                </div>
                
                <!-- Mini Stats -->
                <div class="mt-5 d-flex gap-4 justify-content-center justify-content-lg-start glass p-3 rounded-4 d-inline-flex border border-color shadow-sm" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center px-3 border-end border-color">
                        <h3 class="mb-0 fw-bold brand-font" style="color: var(--btn-bg);">240+</h3>
                        <small class="opacity-75 font-weight-bold">{{ __('Produits') }}</small>
                    </div>
                    <div class="text-center px-3 border-end border-color">
                        <h3 class="mb-0 fw-bold brand-font" style="color: var(--btn-bg);">18</h3>
                        <small class="opacity-75 font-weight-bold">{{ __('Villes') }}</small>
                    </div>
                    <div class="text-center px-3">
                        <h3 class="mb-0 fw-bold brand-font" style="color: var(--btn-bg);">1.2k</h3>
                        <small class="opacity-75 font-weight-bold">{{ __('Membres') }}</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 position-relative ps-lg-5" data-aos="fade-left" data-aos-delay="100">
                <div class="position-relative">
                    <!-- Decorative Elements -->
                    <div class="position-absolute rounded-circle bg-success opacity-10 blur-3xl" style="top: -50px; right: -50px; width: 300px; height: 300px; filter: blur(80px);"></div>
                    
                    <!-- Main Image with mask -->
                    <div class="rounded-4 shadow-2xl overflow-hidden" style="transform: skewY(-2deg);">
                        <img src="https://www.greenvillage.ma/vyckungy/2021/09/241643826_4356507334430213_1831067547250777849_n.jpg" 
                             alt="{{ __('Plat sans gluten') }}" 
                             class="img-fluid" 
                             style="object-fit: cover; height: 550px; width: 100%; transform: skewY(2deg) scale(1.1);">
                    </div>
                    
                    <!-- Floating Badge 1 -->
                    <div class="position-absolute bg-white-adaptive p-3 rounded-4 shadow-lg border border-color d-none d-md-block glass" style="bottom: 40px; left: -30px;" data-aos="zoom-in" data-aos-delay="400">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-soft text-main rounded-circle p-2 d-flex align-items-center justify-content-center shadow-inner" style="width: 45px; height: 45px;">
                                <i class="fas fa-check-circle fs-4" style="color: var(--btn-bg);"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold brand-font">{{ __('100% Vérifié') }}</h6>
                                <small class="opacity-75">{{ __('Par la communauté') }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Badge 2 -->
                    <div class="position-absolute bg-white-adaptive p-3 rounded-4 shadow-lg border border-color d-none d-md-block glass" style="top: 40px; right: -20px;" data-aos="zoom-in" data-aos-delay="500">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-star text-warning"></i>
                            <span class="fw-bold">4.9/5</span>
                            <small class="opacity-75">({{ __('Avis') }})</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="section border-top border-bottom border-color" style="background-color: var(--bg-soft);">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="brand-font fw-bold display-5">{{ __('Tout ce dont vous avez besoin') }}</h2>
            <p class="opacity-75 mx-auto fs-5" style="max-width: 600px;">{{ __('Découvrez nos différentes fonctionnalités conçues pour faciliter votre quotidien sans gluten au Maroc.') }}</p>
        </div>
        
        <div class="row g-4">
            @php
                $features = [
                    ['icon' => 'shopping-basket', 'title' => 'Catalogue en Ligne', 'desc' => 'Trouvez des produits certifiés sans gluten disponibles dans les supermarchés.'],
                    ['icon' => 'map-marked-alt', 'title' => 'Carte Interactive', 'desc' => 'Localisez les restaurants, boulangeries et hôtels avec options sans gluten.'],
                    ['icon' => 'utensils', 'title' => 'Recettes 100% Goût', 'desc' => 'Partagez des recettes traditionnelles marocaines revisitées sans gluten.'],
                    ['icon' => 'users', 'title' => 'Espace Communauté', 'desc' => "Rejoignez un espace d'entraide, créez vos listes et sauvegardez vos emplettes."]
                ];
            @endphp

            @foreach($features as $index => $feature)
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="card card-custom h-100 p-4 text-center border-0 shadow-sm hover-lift">
                        <div class="icon-box mx-auto mb-4 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: var(--bg-soft); color: var(--btn-bg);">
                            <i class="fas fa-{{ $feature['icon'] }} fs-1"></i>
                        </div>
                        <h4 class="fw-bold brand-font mb-3">{{ __($feature['title']) }}</h4>
                        <p class="opacity-75 mb-0">{{ __($feature['desc']) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- HOW IT WORKS SECTION -->
<section class="section my-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0 pe-lg-5" data-aos="fade-right">
                <span class="badge bg-soft text-main px-3 py-2 rounded-pill mb-3 border border-color">{{ __('Mode d\'emploi ✨') }}</span>
                <h2 class="brand-font fw-bold mb-4 display-5">{{ __('Naviguez & Participez') }}</h2>
                <p class="opacity-75 mb-5 fs-5">{{ __('Le Guide Gluten-Free est collaboratif. Chacun peut aider des milliers de cœliaques à mieux manger au quotidien.') }}</p>
                
                @php
                    $steps = [
                        ['icon' => 'user-plus', 'title' => '1. Créez un compte', 'desc' => 'L\'inscription est rapide et gratuite.'],
                        ['icon' => 'search-location', 'title' => '2. Recherchez & Découvrez', 'desc' => 'Tapez un produit ou ouvrez la carte.'],
                        ['icon' => 'share-alt', 'title' => '3. Partagez vos pépites', 'desc' => 'Ajoutez vos restaurants et recettes favorites.']
                    ];
                @endphp

                @foreach($steps as $step)
                <div class="d-flex align-items-start mb-4">
                    <div class="btn-main text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px; flex-shrink: 0;"><i class="fas fa-{{ $step['icon'] }}"></i></div>
                    <div>
                        <h5 class="fw-bold brand-font mb-1">{{ __($step['title']) }}</h5>
                        <p class="opacity-75 small mb-0">{{ __($step['desc']) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                         class="img-fluid rounded-4 shadow-2xl w-100" 
                         alt="Cuisine sans gluten" 
                         style="height: 550px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-4">
                        <div class="glass p-3 rounded-4 shadow-sm border border-color">
                            <i class="fas fa-play-circle fs-1 text-white opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CALL TO ACTION -->
<section class="section py-5 my-5">
    <div class="container">
        <div class="rounded-5 p-5 text-center position-relative overflow-hidden shadow-2xl" 
             style="background: linear-gradient(135deg, var(--btn-bg), var(--btn-hover)); color: #fff;"
             data-aos="zoom-in">
            <div class="position-relative" style="z-index: 2;">
                <h2 class="brand-font fw-bold mb-4 display-4">{{ __('Démarrez votre aventure sereinement 🌿') }}</h2>
                <p class="lead mb-5 mx-auto" style="max-width: 700px; opacity: 0.9;">
                    {{ __('Inscrivez-vous dès maintenant pour participer aux échanges de la première communauté cœliaque et sans gluten de tout le royaume.') }}
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('register') }}" class="btn btn-light px-5 py-3 shadow-lg rounded-pill fw-bold fs-5" style="color: var(--btn-bg);">
                        {{ __('Je crée mon compte') }}
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-light px-5 py-3 rounded-pill fw-bold fs-5">
                        {{ __('Découvrir les produits') }}
                    </a>
                </div>
            </div>
            
            <!-- Abstract background shapes -->
            <div class="position-absolute rounded-circle" style="top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(255,255,255,0.05);"></div>
            <div class="position-absolute rounded-circle" style="bottom: -150px; left: -100px; width: 500px; height: 500px; background: rgba(255,255,255,0.05);"></div>
            <i class="fas fa-leaf position-absolute" style="top: 20px; left: 20px; font-size: 5rem; opacity: 0.05; transform: rotate(-20deg);"></i>
        </div>
    </div>
</section>

<style>
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    .hover-lift:hover { transform: translateY(-10px); }
    .hero { background: radial-gradient(circle at 10% 20%, rgba(45, 90, 39, 0.03) 0%, transparent 40%); }
</style>
@endsection