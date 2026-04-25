<header class="fixed-top transition-all">
    <nav class="navbar navbar-expand-lg navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand fw-bold mb-0 h1 d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo-rounded.png') }}" alt="GFG Logo" class="logo-img logo-rounded">
                <span class="brand-font d-none d-sm-inline p-2" style="letter-spacing: -0.5px;">{{ __('Guide Gluten-Free') }}</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
                <i class="fas fa-bars fs-4 text-main"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-4">
                    <li class="nav-item">
                        <a href="{{ route('products.index') }}" class="nav-link fw-bold px-0">{{ __('Produits') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('locations.index') }}" class="nav-link fw-bold px-0">{{ __('Carte') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('recipes.index') }}" class="nav-link fw-bold px-0">{{ __('Recettes') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pages.about') }}" class="nav-link fw-bold px-0">{{ __('À propos') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pages.contact') }}" class="nav-link fw-bold px-0">{{ __('Contact') }}</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <!-- Language Switcher -->
                    <div class="dropdown">
                        <button
                            class="btn btn-sm btn-link text-decoration-none dropdown-toggle border-0 rounded-pill fw-bold d-flex align-items-center gap-1"
                            type="button" data-bs-toggle="dropdown" style="color: var(--text-main);">
                            <i class="fas fa-globe-africa fs-5 opacity-75"></i>
                            {{ strtoupper(app()->getLocale() ?? 'fr') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 glass mt-2"
                            style="border-radius: 12px;">
                            <li><a class="dropdown-item py-2" style="color: var(--text-main);"
                                    href="{{ route('lang.switch', 'fr') }}">🇫🇷 Français</a></li>
                            <li><a class="dropdown-item py-2" style="color: var(--text-main);"
                                    href="{{ route('lang.switch', 'ar') }}">🇲🇦 العربية</a></li>
                            <li><a class="dropdown-item py-2" style="color: var(--text-main);"
                                    href="{{ route('lang.switch', 'en') }}">🇬🇧 English</a></li>
                            <li><a class="dropdown-item py-2" style="color: var(--text-main);"
                                    href="{{ route('lang.switch', 'es') }}">🇪🇸 Español</a></li>
                        </ul>
                    </div>

                    <button id="theme-toggle"
                        class="btn btn-sm btn-link text-decoration-none p-2 rounded-circle hover-bg"
                        aria-label="Toggle dark mode" style="color: var(--text-main);">
                        <i class="fas fa-moon fs-5"></i>
                    </button>

                    <div class="vr mx-1 opacity-25 d-none d-lg-block"></div>

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-main d-flex align-items-center gap-2" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle fs-5"></i>
                                <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down small opacity-50"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 glass mt-3 animate-fade-in"
                                style="border-radius: 16px; min-width: 240px; padding: 12px;">
                                <li class="px-3 py-3 mb-2 bg-soft rounded-4">
                                    <div class="small opacity-50 fw-bold text-uppercase">{{ __('Connecté en tant que') }}
                                    </div>
                                    <div class="fw-bold truncate" style="color: var(--text-main);">{{ Auth::user()->email }}
                                    </div>
                                </li>

                                @if(Auth::user()->isAdmin())
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 fw-bold text-success"
                                            href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-shield-alt me-2"></i> {{ __('Panel Admin') }}
                                        </a>
                                    </li>
                                @endif

                                <li>
                                    <a class="dropdown-item rounded-3 py-2" href="{{ route('favorites.index') }}">
                                        <i class="fas fa-heart me-2 opacity-50 text-danger"></i> {{ __('Mes Favoris') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-3 py-2" href="{{ route('recipes.my') }}">
                                        <i class="fas fa-utensils me-2 opacity-50"></i> {{ __('Mes Recettes') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-3 py-2" href="{{ route('recipes.create') }}">
                                        <i class="fas fa-plus-circle me-2 opacity-50"></i> {{ __('Partager une recette') }}
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider opacity-10">
                                </li>

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item rounded-3 py-2 text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> {{ __('Déconnexion') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="d-flex gap-2">
                            <a href="{{ route('login') }}"
                                class="nav-link fw-bold align-self-center px-3">{{ __('Connexion') }}</a>
                            <a href="{{ route('register') }}"
                                class="btn btn-main d-none d-md-block">{{ __("S'inscrire") }}</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
    header {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .logo-img {
        height: 60px;
        width: 60px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--border-color);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .logo-img:hover {
        transform: scale(1.05);
    }

    .navbar-custom {
        border-bottom: 1px solid transparent;
        background-color: transparent;
    }

    .glass {
        background: var(--glass-bg) !important;
        border-bottom: 1px solid var(--border-color) !important;
    }

    .hover-bg:hover {
        background: var(--bg-soft);
    }

    .nav-item .nav-link {
        color: var(--text-main) !important;
    }

    /* Ensure content doesn't get hidden under fixed header */
    body {
        padding-top: var(--header-height);
    }

    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: var(--card-bg);
            margin-top: 1rem;
            padding: 1.5rem;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
        }
    }
</style>