@extends('main')

@section('title', __('Conseils Pratiques - Guide Gluten-Free'))

@section('content')
<section class="section pt-5 mt-5">
    <div class="container py-5 mt-4">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <span class="badge bg-soft text-main px-4 py-2 rounded-pill mb-4 border border-color shadow-sm">
                    <i class="fas fa-lightbulb me-2 text-warning"></i>{{ __('Astuces Quotidiennes') }}
                </span>
                <h1 class="display-3 fw-bold mb-4 brand-font text-gradient">{{ __('Vivre sans Gluten au Maroc') }}</h1>
                <p class="lead opacity-75 fs-4 mb-4">
                    {{ __('Des conseils concrets pour simplifier vos courses, vos repas et vos sorties.') }}
                </p>
                <div class="bg-soft p-4 rounded-4 border border-color glass shadow-inner d-inline-block">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fas fa-info-circle text-main fs-4"></i>
                        <p class="mb-0 fw-bold small text-main">{{ __('Saviez-vous que de nombreux produits marocains traditionnels sont naturellement sans gluten ?') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card tip-card border-0 shadow-sm glass rounded-5 h-100 overflow-hidden group">
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             class="img-fluid w-100 h-100 object-cover transition-all group-hover:scale-110" alt="{{ __('Faire ses courses') }}">
                        <div class="position-absolute top-0 end-0 p-3">
                            <span class="badge bg-white-adaptive text-main shadow-sm rounded-pill fw-bold">{{ __('01') }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="fw-bold mb-3 brand-font"><i class="fas fa-shopping-cart me-2 text-main"></i>{{ __('Course & Étiquetage') }}</h4>
                        <ul class="list-unstyled d-flex flex-column gap-3 small opacity-80">
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Lisez toujours la liste complète des ingrédients, même si le logo "Épi Barré" est présent.') }}</li>
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Méfiez-vous des termes vagues comme "Amidon modifié" ou "Épaississants".') }}</li>
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Le gluten peut se cacher dans la levure chimique, les sauces soja et certains yaourts.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card tip-card border-0 shadow-sm glass rounded-5 h-100 overflow-hidden group">
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             class="img-fluid w-100 h-100 object-cover transition-all group-hover:scale-110" alt="{{ __('En cuisine') }}">
                        <div class="position-absolute top-0 end-0 p-3">
                            <span class="badge bg-white-adaptive text-main shadow-sm rounded-pill fw-bold">{{ __('02') }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="fw-bold mb-3 brand-font"><i class="fas fa-utensils me-2 text-main"></i>{{ __('Cuisine & Organisation') }}</h4>
                        <ul class="list-unstyled d-flex flex-column gap-3 small opacity-80">
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Ayez des ustensiles en bois ou plastique dédiés pour éviter les résidus de farine.') }}</li>
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Privilégiez les farines locales comme le riz, le maïs ou le sarrasin.') }}</li>
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Étiquetez clairement vos bocaux pour ne pas les confondre.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card tip-card border-0 shadow-sm glass rounded-5 h-100 overflow-hidden group">
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             class="img-fluid w-100 h-100 object-cover transition-all group-hover:scale-110" alt="{{ __('Sortir au restaurant') }}">
                        <div class="position-absolute top-0 end-0 p-3">
                            <span class="badge bg-white-adaptive text-main shadow-sm rounded-pill fw-bold">{{ __('03') }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="fw-bold mb-3 brand-font"><i class="fas fa-external-link-alt me-2 text-main"></i>{{ __('Sorties & Restaurants') }}</h4>
                        <ul class="list-unstyled d-flex flex-column gap-3 small opacity-80">
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Informez le chef dès votre arrivée sur la sévérité de votre intolérance.') }}</li>
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Faites attention aux fritures (huile partagée avec des frites panées).') }}</li>
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Utilisez notre guide pour trouver des établissements certifiés par la communauté.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="cta-card p-5 rounded-5 shadow-lg position-relative overflow-hidden text-white" style="background: linear-gradient(135deg, var(--btn-bg) 0%, #4a6318 100%);">
                    <div class="floating-icons opacity-10">
                        <i class="fas fa-wheat-alt fs-1 position-absolute top-0 start-0 m-5"></i>
                        <i class="fas fa-bread-slice fs-1 position-absolute bottom-0 end-0 m-5"></i>
                    </div>
                    <h2 class="brand-font fw-bold mb-4 display-5">{{ __('Envie de plus de conseils ?') }}</h2>
                    <p class="lead mb-5 opacity-90">{{ __('Notre communauté partage quotidiennement des astuces sur notre groupe d\'entraide.') }}</p>
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-main shadow-lg hover-up">{{ __('Rejoindre la Communauté') }}</a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 ps-lg-5" data-aos="fade-left">
                <h2 class="brand-font fw-bold display-5 mb-4">{{ __('Les Best-Sellers Naturels') }}</h2>
                <div class="d-flex flex-wrap gap-4">
                    <div class="p-4 bg-white-adaptive border border-color rounded-4 shadow-sm flex-grow-1 text-center hover-up">
                        <div class="fs-1 mb-2">🍚</div>
                        <h6 class="fw-bold mb-0">{{ __('Riz Complet') }}</h6>
                    </div>
                    <div class="p-4 bg-white-adaptive border border-color rounded-4 shadow-sm flex-grow-1 text-center hover-up">
                        <div class="fs-1 mb-2">🌽</div>
                        <h6 class="fw-bold mb-0">{{ __('Maïs') }}</h6>
                    </div>
                    <div class="p-4 bg-white-adaptive border border-color rounded-4 shadow-sm flex-grow-1 text-center hover-up">
                        <div class="fs-1 mb-2">🍠</div>
                        <h6 class="fw-bold mb-0">{{ __('Pommes de terre') }}</h6>
                    </div>
                    <div class="p-4 bg-white-adaptive border border-color rounded-4 shadow-sm flex-grow-1 text-center hover-up">
                        <div class="fs-1 mb-2">🥜</div>
                        <h6 class="fw-bold mb-0">{{ __('Légumineuses') }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .text-gradient { background: linear-gradient(90deg, var(--btn-bg), #6b8e23); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05); }
    .object-cover { object-fit: cover; }
    .tip-card { transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .tip-card:hover { transform: translateY(-15px); box-shadow: 0 40px 80px rgba(0,0,0,0.1) !important; border-color: var(--btn-bg) !important; }
    .hover-up:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .transition-all { transition: 0.3s; }
</style>
@endsection
