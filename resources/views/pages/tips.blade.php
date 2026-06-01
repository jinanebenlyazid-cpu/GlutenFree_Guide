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

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card tip-card border-0 shadow-sm glass rounded-5 h-100 overflow-hidden group">
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             class="img-fluid w-100 h-100 object-cover transition-all group-hover:scale-110" alt="{{ __('Voyager sereinement') }}">
                        <div class="position-absolute top-0 end-0 p-3">
                            <span class="badge bg-white-adaptive text-main shadow-sm rounded-pill fw-bold">{{ __('04') }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="fw-bold mb-3 brand-font"><i class="fas fa-suitcase-rolling me-2 text-main"></i>{{ __('Voyages & Déplacements') }}</h4>
                        <ul class="list-unstyled d-flex flex-column gap-3 small opacity-80">
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Préparez une petite trousse avec snacks certifiés, carte d’allergène et adresses fiables.') }}</li>
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Appelez l’hôtel ou le restaurant avant de partir pour confirmer les options.') }}</li>
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Gardez une photo des étiquettes de vos produits habituels pour comparer rapidement.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card tip-card border-0 shadow-sm glass rounded-5 h-100 overflow-hidden group">
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        <img src="https://images.unsplash.com/photo-1505751172876-fa1923c5c528?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             class="img-fluid w-100 h-100 object-cover transition-all group-hover:scale-110" alt="{{ __('Suivi médical') }}">
                        <div class="position-absolute top-0 end-0 p-3">
                            <span class="badge bg-white-adaptive text-main shadow-sm rounded-pill fw-bold">{{ __('05') }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="fw-bold mb-3 brand-font"><i class="fas fa-heart-pulse me-2 text-main"></i>{{ __('Santé & Suivi') }}</h4>
                        <ul class="list-unstyled d-flex flex-column gap-3 small opacity-80">
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Planifiez un bilan avec votre gastro-entérologue ou nutritionniste au moins une fois par an.') }}</li>
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Surveillez fer, vitamine D, calcium et B12 si fatigue ou symptômes persistants.') }}</li>
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Ne réintroduisez jamais le gluten sans avis médical.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card tip-card border-0 shadow-sm glass rounded-5 h-100 overflow-hidden group">
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             class="img-fluid w-100 h-100 object-cover transition-all group-hover:scale-110" alt="{{ __('Planifier son budget') }}">
                        <div class="position-absolute top-0 end-0 p-3">
                            <span class="badge bg-white-adaptive text-main shadow-sm rounded-pill fw-bold">{{ __('06') }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="fw-bold mb-3 brand-font"><i class="fas fa-clipboard-list me-2 text-main"></i>{{ __('Budget & Planification') }}</h4>
                        <ul class="list-unstyled d-flex flex-column gap-3 small opacity-80">
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Préparez une liste de courses hebdomadaire pour limiter les achats impulsifs.') }}</li>
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Comparez les produits naturellement sans gluten avec les produits spécialisés.') }}</li>
                            <li class="d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('Cuisinez en quantité et congelez des portions sûres pour les jours chargés.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="cta-card community-cta p-5 rounded-5 shadow-lg position-relative overflow-hidden text-white">
                    <div class="floating-icons">
                        <i class="fas fa-wheat-alt position-absolute"></i>
                        <i class="fas fa-bread-slice position-absolute"></i>
                    </div>
                    <h2 class="community-cta-title brand-font fw-bold mb-4 display-5">
                        <span class="community-cta-icon"><i class="fas fa-users"></i></span>
                        <span>{{ __('Envie de plus de conseils ?') }}</span>
                    </h2>
                    <p class="lead mb-5 opacity-90">{{ __('Notre communauté partage quotidiennement des astuces sur notre groupe d\'entraide.') }}</p>
                    <a href="{{ route('register') }}" class="btn community-cta-btn btn-lg rounded-pill px-5 fw-bold shadow-lg hover-up">
                        <i class="fas fa-arrow-right-to-bracket me-2"></i>{{ __('Rejoindre la Communauté') }}
                    </a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 ps-lg-5" data-aos="fade-left">
                <h2 class="brand-font fw-bold display-5 mb-4">{{ __('Guides essentiels') }}</h2>
                <div class="community-guide-grid">
                    <div class="community-guide-card bg-white-adaptive border border-color rounded-4 shadow-sm hover-up">
                        <div class="community-guide-icon text-success"><i class="fas fa-certificate"></i></div>
                        <h6 class="fw-bold mb-2">{{ __('Produits certifiés') }}</h6>
                        <p class="small opacity-75 mb-0">{{ __('Repérez les logos fiables et les mentions sans gluten avant d’acheter.') }}</p>
                    </div>
                    <div class="community-guide-card bg-white-adaptive border border-color rounded-4 shadow-sm hover-up">
                        <div class="community-guide-icon text-success"><i class="fas fa-map-location-dot"></i></div>
                        <h6 class="fw-bold mb-2">{{ __('Adresses sûres') }}</h6>
                        <p class="small opacity-75 mb-0">{{ __('Trouvez des restaurants et magasins vérifiés par la communauté.') }}</p>
                    </div>
                    <div class="community-guide-card bg-white-adaptive border border-color rounded-4 shadow-sm hover-up">
                        <div class="community-guide-icon text-success"><i class="fas fa-shield-halved"></i></div>
                        <h6 class="fw-bold mb-2">{{ __('Anti-contamination') }}</h6>
                        <p class="small opacity-75 mb-0">{{ __('Apprenez les gestes simples pour éviter les traces de gluten à la maison.') }}</p>
                    </div>
                    <div class="community-guide-card bg-white-adaptive border border-color rounded-4 shadow-sm hover-up">
                        <div class="community-guide-icon text-success"><i class="fas fa-bowl-food"></i></div>
                        <h6 class="fw-bold mb-2">{{ __('Repas équilibrés') }}</h6>
                        <p class="small opacity-75 mb-0">{{ __('Composez des menus nourrissants avec fibres, protéines et bons féculents.') }}</p>
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
    .community-cta { background: linear-gradient(135deg, #245a2a 0%, #4b7d2a 100%); }
    .community-cta-title { display: flex; align-items: center; gap: 1rem; line-height: 1.05; }
    .community-cta-icon { width: 58px; height: 58px; border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; flex: 0 0 auto; background: rgba(255,255,255,0.16); border: 1px solid rgba(255,255,255,0.24); font-size: 1.7rem; }
    .community-cta-btn { background: #fff; color: #245a2a; border: 0; min-width: 260px; }
    .community-cta-btn:hover { background: #f4f8f0; color: #163b19; }
    .floating-icons i:first-child { top: 28px; right: 34px; font-size: 4.2rem; opacity: 0.08; transform: rotate(18deg); }
    .floating-icons i:last-child { bottom: 34px; right: 54px; font-size: 3.3rem; opacity: 0.12; }
    .community-guide-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; }
    .community-guide-card { padding: 1.35rem; min-height: 178px; transition: 0.3s; }
    .community-guide-icon { width: 46px; height: 46px; border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; background: var(--bg-soft); font-size: 1.25rem; margin-bottom: 1rem; }
    @media (max-width: 575.98px) {
        .community-cta { padding: 2rem !important; }
        .community-cta-title { align-items: flex-start; font-size: 2.35rem; }
        .community-cta-btn { width: 100%; min-width: 0; }
        .community-guide-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection
