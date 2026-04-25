@extends('main')

@section('title', __('À Propos - Guide Gluten-Free'))

@section('content')
<div class="about-hero position-relative overflow-hidden py-5 mb-5" style="background: linear-gradient(135deg, var(--bg-soft) 0%, var(--bg-body) 100%);">
    <div class="container py-5 mt-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="badge bg-soft text-main px-3 py-2 rounded-pill mb-3 border border-color shadow-sm">
                    <i class="fas fa-star me-2"></i>{{ __('Notre Vision') }}
                </span>
                <h1 class="display-3 fw-bold mb-4 brand-font text-gradient">{{ __('Pourquoi Guide Gluten-Free ?') }}</h1>
                <p class="lead opacity-75 mb-4 fs-4 text-main">
                    {{ __('Le Guide Gluten-Free est né d\'une volonté simple : faciliter la vie des personnes cœliaques et intolérantes au gluten au Maroc.') }}
                </p>
                <div class="d-flex gap-3">
                    <div class="p-3 bg-white-adaptive rounded-4 shadow-sm border border-color flex-grow-1">
                        <h5 class="fw-bold text-main mb-1"><i class="fas fa-bullseye me-2 text-success"></i>{{ __('Mission') }}</h5>
                        <p class="small mb-0 opacity-75">{{ __('Rendre le sans gluten accessible à tous partout au Maroc.') }}</p>
                    </div>
                    <div class="p-3 bg-white-adaptive rounded-4 shadow-sm border border-color flex-grow-1">
                        <h5 class="fw-bold text-main mb-1"><i class="fas fa-users me-2 text-primary"></i>{{ __('Communauté') }}</h5>
                        <p class="small mb-0 opacity-75">{{ __('Unir les forces pour partager les meilleures adresses.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <div class="blob-bg"></div>
                    <img src="https://images.unsplash.com/photo-1490818387583-1baba5e638af?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                         alt="{{ __('Alimentation saine') }}" 
                         class="img-fluid rounded-5 shadow-2xl position-relative z-1 hover-tilt">
                    <div class="position-absolute glass-float p-4 rounded-4 border border-color shadow-lg d-none d-md-block z-2">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle bg-danger text-white shadow-sm">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div>
                                <span class="fw-bold d-block text-main">{{ __('100% Santé') }}</span>
                                <small class="opacity-50 text-main">{{ __('Engagement total') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="section py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-12 text-center mb-5" data-aos="fade-up">
                <h2 class="brand-font fw-bold mb-3 display-5">{{ __('Comprendre & Vivre sans Gluten') }}</h2>
                <div class="mx-auto bg-main rounded-pill mb-4" style="width: 80px; height: 4px;"></div>
                <p class="opacity-75 mx-auto fs-5" style="max-width: 700px;">{{ __('Découvrez nos guides complets pour mieux appréhender la maladie cœliaque et adopter les bons réflexes au quotidien.') }}</p>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card about-card h-100 p-5 border-0 shadow-sm text-center glass-hover">
                    <div class="icon-wrapper mb-4 mx-auto shadow-md">
                        <i class="fas fa-microscope fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3 brand-font">{{ __('Maladie Cœliaque') }}</h4>
                    <p class="opacity-75 mb-4 small">{{ __('Symptômes, diagnostic et explications scientifiques sur cette pathologie auto-immune.') }}</p>
                    <a href="{{ route('pages.celiac') }}" class="btn btn-soft-secondary rounded-pill mt-auto stretched-link px-4">{{ __('En savoir plus') }}</a>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card about-card h-100 p-5 border-0 shadow-sm text-center glass-hover highlighted">
                    <div class="icon-wrapper mb-4 mx-auto shadow-md bg-main text-white">
                        <i class="fas fa-shopping-basket fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3 brand-font">{{ __('Éviter le Gluten') }}</h4>
                    <p class="opacity-75 mb-4 small">{{ __('Comment lire les étiquettes, éviter les contaminations croisées et faire ses courses sereinement.') }}</p>
                    <a href="{{ route('pages.tips') }}" class="btn btn-main rounded-pill mt-auto stretched-link px-4">{{ __('Voir les conseils') }}</a>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card about-card h-100 p-5 border-0 shadow-sm text-center glass-hover">
                    <div class="icon-wrapper mb-4 mx-auto shadow-md">
                        <i class="fas fa-user-md fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-3 brand-font">{{ __('Avis d\'Experts') }}</h4>
                    <p class="opacity-75 mb-4 small">{{ __('Conseils de gastro-entérologues et nutritionnistes spécialisés dans le régime sans gluten.') }}</p>
                    <a href="{{ route('pages.advice') }}" class="btn btn-soft-secondary rounded-pill mt-auto stretched-link px-4">{{ __('Consulter les avis') }}</a>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-5 align-items-center" data-aos="fade-up">
            <div class="col-lg-5">
                <div class="rounded-5 overflow-hidden shadow-lg position-relative group">
                    <img src="{{ asset('images/team.jpg') }}" 
                         alt="{{ __('Équipe de développement : Jinane & Iman') }}" 
                         class="img-fluid scale-hover transition-all duration-500">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
            </div>
            <div class="col-lg-7 ps-lg-5 mt-4 mt-lg-0">
                <h2 class="brand-font fw-bold mb-4 display-5">{{ __('Qui sommes-nous ?') }}</h2>
                <p class="opacity-75 mb-4 fs-5">
                    {{ __('Ce site est le fruit d\'un travail passionné réalisé par Jinane & Iman dans le cadre de leur projet de fin de formation (PFF).') }}
                </p>
                <div class="p-4 bg-soft rounded-4 border border-color mb-4 glass shadow-inner">
                    <div class="d-flex align-items-start gap-4">
                        <div class="icon-circle bg-white-adaptive text-main shadow-sm fs-4 p-3">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-2 text-main">{{ __('Projet de Fin de Formation') }}</h6>
                            <p class="small opacity-75 mb-0 text-main">
                                {{ __('Notre ambition était de mettre nos compétences techniques au service d\'une cause sociale noble : aider la communauté cœliaque marocaine à trouver des alternatives sûres et savoureuses.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section position-relative py-5">
    <div class="container py-5">
        <div class="cta-banner rounded-5 p-5 shadow-2xl text-center text-white overflow-hidden position-relative">
            <div class="cta-blob"></div>
            <div class="position-relative z-1 py-4">
                <h2 class="brand-font fw-bold mb-4 display-4">{{ __('Rejoignez l\'aventure collaborative !') }}</h2>
                <p class="lead opacity-90 mb-5 mx-auto" style="max-width: 650px;">{{ __('Vous connaissez un restaurant proposant des options sans gluten ? Vous avez une recette fétiche ? Partagez vos connaissances avec la communauté.') }}</p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-main shadow-lg hover-up">{{ __('Devenir Membre') }}</a>
                    <a href="{{ route('pages.contact') }}" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-bold hover-up">{{ __('Nous Contacter') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .text-gradient { background: linear-gradient(90deg, var(--btn-bg), #6b8e23); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
    .glass-hover { background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); border: 1px solid rgba(0,0,0,0.05); }
    .glass-hover:hover { transform: translateY(-15px); background: var(--card-bg); box-shadow: 0 30px 60px rgba(0,0,0,0.1) !important; border-color: var(--border-color); }
    .icon-wrapper { width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; background: var(--bg-soft); color: var(--btn-bg); border-radius: 20px; transition: 0.3s; }
    .glass-hover:hover .icon-wrapper { transform: rotate(10deg); }
    .about-card.highlighted { border: 2px solid var(--btn-bg) !important; }
    .icon-circle { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
    .glass-float { position: absolute; bottom: 30px; left: -20px; background: var(--glass-bg); backdrop-filter: blur(12px); min-width: 200px; animation: float 6s ease-in-out infinite; }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
    .blob-bg { position: absolute; width: 400px; height: 400px; background: rgba(107, 142, 35, 0.1); filter: blur(50px); border-radius: 50%; top: -50px; left: -50px; animation: pulse 8s infinite alternate; }
    @keyframes pulse { 0% { transform: scale(1); } 100% { transform: scale(1.2); } }
    .hover-tilt:hover { transform: perspective(1000px) rotateY(10deg) rotateX(2deg); }
    .cta-banner { background: var(--btn-bg); background: linear-gradient(135deg, var(--btn-bg) 0%, #4a6318 100%); }
    .cta-blob { position: absolute; width: 600px; height: 600px; background: rgba(255,255,255,0.05); border-radius: 50%; top: -300px; right: -300px; }
    .hover-up:hover { transform: translateY(-5px); }
    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05); }
    .scale-hover:hover { transform: scale(1.05); }
</style>
@endsection

