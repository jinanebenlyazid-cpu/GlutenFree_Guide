@extends('main')

@section('title', __('Comprendre la Maladie Cœliaque - Guide Gluten-Free'))
@section('content')
    <section class="section pt-5 mt-5 position-relative overflow-hidden">
        <div class="circles-bg"></div>
        <div class="container py-5 mt-4">
            <div class="row align-items-center g-5 mb-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <span class="badge bg-soft text-main px-3 py-2 rounded-pill mb-3 border border-color shadow-sm">
                        <i class="fas fa-microscope me-2"></i>{{ __('Science & Santé') }}
                    </span>
                    <h1 class="display-3 fw-bold mb-4 brand-font text-gradient">
                        {{ __('Tout savoir sur la Maladie Cœliaque') }}
                    </h1>
                    <p class="lead opacity-75 fs-4 mb-4">
                        {{ __('Une pathologie auto-immune complexe souvent mal comprise, mais parfaitement gérable avec les bonnes informations.') }}
                    </p>
                    <div class="p-4 bg-white-adaptive border border-color rounded-5 shadow-2xl glass mb-4">
                        <div class="d-flex gap-4">
                            <div class="icon-circle bg-main  p-3 shadow-lg"><i class="fas fa-question fs-4"></i></div>
                            <div>
                                <h5 class="fw-bold mb-2">{{ __('C\'est quoi exactement ?') }}</h5>
                                <p class="small opacity-75 mb-0">
                                    {{ __('Ce n\'est pas une simple allergie, mais une réaction immunitaire au gluten qui endommage la paroi de l\'intestin grêle, empêchant l\'absorption des nutriments.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="position-relative">
                        <div class="floating-shape"></div>
                        <img src="https://images.unsplash.com/photo-1576086213369-97a306d36557?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                            alt="{{ __('Recherche médicale') }}"
                            class="img-fluid rounded-5 shadow-2xl position-relative z-1 hover-scale-sm">
                        <div
                            class="glass-overlay p-4 rounded-4 shadow-lg position-absolute top-10 start-0 z-2 d-none d-md-block">
                            <h6 class="fw-bold text-main mb-1"><i class="fas fa-dna me-2"></i>{{ __('Génétique') }}</h6>
                            <small class="opacity-75">{{ __('Un terrain héréditaire') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5 mt-5 pt-4">
                <div class="col-12 text-center mb-4" data-aos="fade-up">
                    <span class="badge bg-soft text-main px-3 py-2 rounded-pill mb-3 border border-color shadow-sm">
                        <i class="fas fa-stomach me-2 text-success"></i>{{ __('Comprendre simplement') }}
                    </span>
                    <h2 class="brand-font fw-bold display-4">{{ __('Que se passe-t-il dans le système digestif ?') }}</h2>
                    <p class="opacity-75 fs-5 mx-auto" style="max-width: 760px;">
                        {{ __('Pour une personne cœliaque, le gluten déclenche une réaction immunitaire qui abîme l’intestin grêle, même si la quantité avalée paraît minuscule.') }}
                    </p>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="digest-card h-100 p-4 rounded-5 border border-color bg-white-adaptive shadow-sm">
                        <div class="digest-icon bg-soft text-success mb-4"><i class="fas fa-route"></i></div>
                        <h4 class="brand-font fw-bold mb-3">{{ __('Le rôle normal de la digestion') }}</h4>
                        <p class="small opacity-75 mb-0">
                            {{ __('L’estomac commence à décomposer les aliments. Ensuite, l’intestin grêle absorbe les nutriments essentiels comme le fer, le calcium, les vitamines et l’énergie.') }}
                        </p>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="digest-card h-100 p-4 rounded-5 border border-color bg-white-adaptive shadow-sm">
                        <div class="digest-icon bg-soft text-success mb-4"><i class="fas fa-wave-square"></i></div>
                        <h4 class="brand-font fw-bold mb-3">{{ __('Les villosités : petites racines de l’intestin') }}</h4>
                        <p class="small opacity-75 mb-0">
                            {{ __('La paroi de l’intestin grêle contient de minuscules replis appelés villosités. Elles augmentent la surface d’absorption pour récupérer un maximum de nutriments.') }}
                        </p>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="digest-card h-100 p-4 rounded-5 border border-color bg-white-adaptive shadow-sm">
                        <div class="digest-icon bg-soft text-danger mb-4"><i class="fas fa-shield-virus"></i></div>
                        <h4 class="brand-font fw-bold mb-3">{{ __('Quand le gluten entre') }}</h4>
                        <p class="small opacity-75 mb-0">
                            {{ __('Chez une personne cœliaque, le système immunitaire se trompe : il réagit au gluten et attaque la muqueuse intestinale au lieu de protéger le corps.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5 align-items-stretch">
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="p-4 p-md-5 rounded-5 border border-color bg-soft h-100 position-relative overflow-hidden">
                        <div class="severity-mark"><i class="fas fa-triangle-exclamation"></i></div>
                        <h2 class="brand-font fw-bold mb-4">{{ __('Pourquoi c’est sérieux ?') }}</h2>
                        <div class="d-flex flex-column gap-3">
                            <div class="serious-row">
                                <span class="serious-num">1</span>
                                <p class="mb-0">
                                    {{ __('L’inflammation écrase progressivement les villosités, comme une moquette qui perd ses fibres.') }}
                                </p>
                            </div>
                            <div class="serious-row">
                                <span class="serious-num">2</span>
                                <p class="mb-0">
                                    {{ __('L’intestin absorbe moins bien les nutriments : cela peut provoquer fatigue, anémie, perte de poids, douleurs, diarrhée ou constipation.') }}
                                </p>
                            </div>
                            <div class="serious-row">
                                <span class="serious-num">3</span>
                                <p class="mb-0">
                                    {{ __('Sans régime strict, les carences et l’inflammation peuvent durer longtemps, parfois sans symptômes très visibles.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5" data-aos="fade-left">
                    <div class="p-4 p-md-5 rounded-5 border border-danger border-opacity-25 bg-danger-soft h-100">
                        <h3 class="brand-font fw-bold text-danger mb-4"><i
                                class="fas fa-ban me-2"></i>{{ __('Important à retenir') }}</h3>
                        <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                            <li class="d-flex gap-3"><i
                                    class="fas fa-check text-danger mt-1"></i><span>{{ __('Ce n’est pas une mode alimentaire : c’est une maladie auto-immune permanente.') }}</span>
                            </li>
                            <li class="d-flex gap-3"><i
                                    class="fas fa-check text-danger mt-1"></i><span>{{ __('Une petite quantité de gluten peut suffire à relancer l’inflammation.') }}</span>
                            </li>
                            <li class="d-flex gap-3"><i
                                    class="fas fa-check text-danger mt-1"></i><span>{{ __('Le seul traitement reconnu est une alimentation strictement sans gluten, tous les jours.') }}</span>
                            </li>
                            <li class="d-flex gap-3"><i
                                    class="fas fa-check text-danger mt-1"></i><span>{{ __('Il ne faut pas arrêter le gluten avant les tests médicaux, car cela peut fausser le diagnostic.') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5 pt-5">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="brand-font fw-bold display-4">{{ __('Les Symptômes Courants') }}</h2>
                    <p class="opacity-75 fs-5">{{ __('Ils varient énormément d\'une personne à l\'autre.') }}</p>
                </div>

                @php
                    $symptoms = [
                        ['icon' => 'notes-medical', 'title' => 'Digestifs', 'desc' => 'Ballonnements, douleurs abdominales, diarrhée chronique ou constipation.'],
                        ['icon' => 'battery-quarter', 'title' => 'Généraux', 'desc' => 'Fatigue chronique, anémie, perte de poids inexpliquée.'],
                        ['icon' => 'brain', 'title' => 'Neurologiques', 'desc' => 'Maux de tête, irritabilité, "brouillard mental".'],
                        ['icon' => 'chart-line', 'title' => 'Croissance', 'desc' => 'Chez l\'enfant : retard de croissance, irritabilité, manque d\'appétit.'],
                    ];
                @endphp

                @foreach($symptoms as $idx => $s)
                    <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="{{ $idx * 100 }}">
                        <div class="card card-custom h-100 border-0 shadow-sm glass p-4 rounded-5 text-center hover-up">
                            <div class="display-3 mb-3 text-success"><i class="fas fa-{{ $s['icon'] }}"></i></div>
                            <h5 class="fw-bold mb-3 brand-font">{{ __($s['title']) }}</h5>
                            <p class="small opacity-75 mb-0 px-2">{{ __($s['desc']) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row py-5 align-items-center g-5">
                <div class="col-lg-5 order-lg-2" data-aos="fade-left">
                    <div class="p-5 bg-soft rounded-5 border border-color shadow-inner position-relative">
                        <div class="cta-pulse"></div>
                        <h2 class="brand-font fw-bold mb-4">{{ __('Le Diagnostic') }}</h2>
                        <p class="opacity-75 fs-5 mb-4">{{ __('Le parcours classique en deux étapes cruciales :') }}</p>
                        <div
                            class="step-card d-flex gap-4 p-4 bg-white-adaptive rounded-4 border border-color shadow-sm mb-4">
                            <div class="step-num bg-main text-white"><i class="fas fa-vial"></i></div>

                            <div>
                                <h6 class="fw-bold text-main mb-1">{{ __('Sérologie') }}</h6>
                                <p class="small opacity-75 mb-0">
                                    {{ __('Recherche d\'anticorps anti-transglutaminase par prise de sang.') }}
                                </p>
                            </div>
                        </div>
                        <div class="step-card d-flex gap-4 p-4 bg-white-adaptive rounded-4 border border-color shadow-sm">
                            <div class="step-num bg-main text-white"><i class="fas fa-microscope"></i></div>

                            <div>
                                <h6 class="fw-bold text-main mb-1">{{ __('Biopsie') }}</h6>
                                <p class="small opacity-75 mb-0">
                                    {{ __('Confirmation par prélèvement au niveau de l\'intestin grêle.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 order-lg-1" data-aos="fade-right">
                    <h2 class="brand-font fw-bold display-5 mb-4">{{ __('Le Traitement : La Diète') }}</h2>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-4 bg-danger-soft rounded-4 border border-danger border-opacity-25 highlight-card">
                                <h5 class="fw-bold text-danger mb-3"><i
                                        class="fas fa-times-circle me-2"></i>{{ __('Zéro Gluten') }}</h5>
                                <p class="small mb-0">
                                    {{ __('L\'éviction doit être totale et à vie. Même une miette peut relancer l\'inflammation.') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div
                                class="p-4 bg-success-soft rounded-4 border border-success border-opacity-25 highlight-card">
                                <h5 class="fw-bold text-success mb-3"><i
                                        class="fas fa-check-circle me-2"></i>{{ __('Récupération') }}</h5>
                                <p class="small mb-0">
                                    {{ __('Après l\'arrêt du gluten, l\'intestin se régénère et les symptômes disparaissent progressivement.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <a href="{{ route('pages.tips') }}"
                            class="btn btn-main btn-lg rounded-pill px-5 shadow-lg me-3 transition-grow">{{ __('Voir les astuces') }}</a>
                        <a href="{{ route('recipes.index') }}"
                            class="btn btn-outline-main btn-lg rounded-pill px-5 transition-grow">{{ __('Découvrir des recettes') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .text-gradient {
            background: linear-gradient(90deg, var(--btn-bg), #6b8e23);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .shadow-2xl {
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.15);
        }

        .shadow-inner {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
        }

        .circles-bg {
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: rgba(107, 142, 35, 0.05);
            border-radius: 50%;
            z-index: 0;
            filter: blur(40px);
        }

        .floating-shape {
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 250px;
            height: 250px;
            background: rgba(107, 142, 35, 0.1);
            clip-path: polygon(50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%);
            z-index: 0;
            animation: rotate 15s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .glass-overlay {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
        }

        .hover-up {
            transition: all 0.4s;
        }

        .hover-up:hover {
            transform: translateY(-15px);
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.1) !important;
            border-color: var(--btn-bg) !important;
        }

        .bg-danger-soft {
            background: rgba(220, 53, 69, 0.05);
        }

        .bg-success-soft {
            background: rgba(25, 135, 84, 0.05);
        }

        .digest-card {
            transition: 0.3s;
        }

        .digest-card:hover {
            transform: translateY(-8px);
            border-color: var(--btn-bg) !important;
        }

        .digest-icon {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .severity-mark {
            position: absolute;
            right: 28px;
            top: 24px;
            font-size: 5rem;
            color: var(--btn-bg);
            opacity: 0.07;
        }

        .serious-row {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            padding: 1rem;
            border-radius: 1.25rem;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
        }

        .serious-num {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--btn-bg);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            font-weight: 700;
        }

        .highlight-card {
            transition: 0.3s;
        }

        .highlight-card:hover {
            background: var(--card-bg);
            transform: scale(1.02);
        }

        .cta-pulse {
            position: absolute;
            width: 100px;
            height: 100px;
            background: var(--btn-bg);
            opacity: 0.1;
            border-radius: 50%;
            top: -20px;
            right: -20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(107, 142, 35, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(107, 142, 35, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(107, 142, 35, 0);
            }
        }

        .transition-grow:hover {
            transform: scale(1.05);
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 20px;
        }

        .step-num {
            width: 50px;
            height: 50px;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
    </style>
@endsection