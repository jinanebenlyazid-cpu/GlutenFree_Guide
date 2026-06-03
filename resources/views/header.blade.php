<header class="fixed-top transition-all">
    <nav class="navbar navbar-expand-lg navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand fw-bold mb-0 h1 d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo-rounded.png') }}" alt="{{ __('Logo GFG') }}"
                    class="logo-img logo-rounded">
                <span class="brand-font d-none d-sm-inline p-2"
                    style="letter-spacing: -0.5px;">{{ __('Guide Gluten-Free') }}</span>
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
                                    href="{{ route('lang.switch', 'fr') }}">{{ __('🇫🇷 Français') }}</a></li>
                            <li><a class="dropdown-item py-2" style="color: var(--text-main);"
                                    href="{{ route('lang.switch', 'ar') }}">{{ __('🇲🇦 العربية') }}</a></li>
                            <li><a class="dropdown-item py-2" style="color: var(--text-main);"
                                    href="{{ route('lang.switch', 'en') }}">{{ __('🇬🇧 English') }}</a></li>
                            <li><a class="dropdown-item py-2" style="color: var(--text-main);"
                                    href="{{ route('lang.switch', 'es') }}">{{ __('🇪🇸 Español') }}</a></li>
                        </ul>
                    </div>

                    <button id="theme-toggle"
                        class="btn btn-sm btn-link text-decoration-none p-2 rounded-circle hover-bg"
                        aria-label="Toggle dark mode" style="color: var(--text-main);">
                        <i class="fas fa-moon fs-5"></i>
                    </button>

                    <div class="vr mx-1 opacity-25 d-none d-lg-block"></div>

                    @auth
                        {{-- ── Notification Bell ── --}}
                        <div class="dropdown" id="notif-dropdown-wrapper">
                            <button class="btn btn-sm btn-link text-decoration-none p-2 rounded-circle hover-bg position-relative"
                                    id="notif-bell-btn"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside"
                                    aria-expanded="false"
                                    style="color: var(--text-main);"
                                    onclick="loadNotifications()">
                                <i class="fas fa-bell fs-5"></i>
                                <span id="notif-badge"
                                      class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none"
                                      style="font-size: 0.65rem; min-width: 18px;">0</span>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0 mt-2"
                                 id="notif-panel"
                                 style="border-radius: 16px; width: 360px; max-width: 95vw; background: var(--card-bg); border: 1px solid var(--border-color);">

                                {{-- Header --}}
                                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom border-color">
                                    <h6 class="mb-0 fw-bold brand-font" style="color: var(--text-main);">
                                        <i class="fas fa-bell me-2" style="color: var(--btn-bg);"></i>
                                        {{ __('Notifications') }}
                                    </h6>
                                    <button class="btn btn-sm btn-link text-decoration-none fw-bold p-0"
                                            onclick="markAllRead()"
                                            style="color: var(--btn-bg); font-size: 0.8rem;">
                                        {{ __('Tout marquer lu') }}
                                    </button>
                                </div>

                                {{-- Notification List --}}
                                <div id="notif-list" style="max-height: 360px; overflow-y: auto;"></div>

                                {{-- Empty state (hidden by default) --}}
                                <div id="notif-empty" class="text-center py-5 px-3 d-none">
                                    <i class="fas fa-bell-slash fa-2x mb-3 opacity-25" style="color: var(--text-main);"></i>
                                    <p class="mb-0 opacity-50 small fw-bold">{{ __('Aucune notification pour le moment') }}</p>
                                </div>

                                {{-- Loading state --}}
                                <div id="notif-loading" class="text-center py-4">
                                    <div class="spinner-border spinner-border-sm" style="color: var(--btn-bg);" role="status"></div>
                                </div>
                            </div>
                        </div>
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

    .navbar-custom > .container {
        max-width: 100%;
        min-width: 0;
    }

    .navbar-brand {
        min-width: 0;
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
        header,
        .navbar-custom {
            max-width: 100vw;
        }

        .navbar-custom {
            padding-left: 0;
            padding-right: 0;
        }

        .navbar-custom > .container {
            position: relative;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .logo-img {
            width: 54px;
            height: 54px;
        }

        .navbar-toggler {
            flex: 0 0 auto;
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: color-mix(in srgb, var(--card-bg) 80%, transparent);
        }

        .navbar-collapse {
            position: fixed;
            top: calc(var(--header-height) + 8px);
            left: 1rem;
            right: 1rem;
            width: auto;
            max-width: calc(100vw - 2rem);
            max-height: calc(100vh - var(--header-height) - 24px);
            overflow-y: auto;
            overflow-x: hidden;
            background: var(--card-bg);
            margin-top: 0;
            padding: 1.25rem;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
        }

        .navbar-collapse .navbar-nav {
            gap: .25rem;
            margin-bottom: 1rem !important;
        }

        .navbar-collapse .nav-link {
            width: 100%;
            padding: .72rem 1rem !important;
            border-radius: 14px;
            background: var(--bg-soft);
        }

        .navbar-collapse > .d-flex {
            width: 100%;
            flex-direction: column;
            align-items: stretch !important;
            gap: .75rem !important;
        }

        .navbar-collapse > .d-flex > .dropdown,
        .navbar-collapse > .d-flex > .d-flex,
        .navbar-collapse .btn-main,
        .navbar-collapse .dropdown > button {
            width: 100%;
        }

        .navbar-collapse > .d-flex > .d-flex {
            flex-direction: column;
        }

        .navbar-collapse .dropdown-menu {
            max-width: 100%;
        }

        #notif-panel {
            width: calc(100vw - 2rem) !important;
            max-width: calc(100vw - 2rem) !important;
        }
    }
</style>
