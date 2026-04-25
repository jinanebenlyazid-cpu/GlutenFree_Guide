@extends('main')

@section('title', __('Connexion - Guide Gluten-Free'))

@section('content')
<section class="section d-flex align-items-center justify-content-center py-5" 
         style="background: linear-gradient(135deg, var(--bg-soft) 0%, #e8f5e9 100%); min-height: calc(100vh - 100px); position: relative; overflow: hidden;">
    
    <!-- Decorative elements -->
    <div class="position-absolute top-0 start-0 opacity-25" style="transform: translate(-30%, -30%); z-index: 0;">
        <i class="fas fa-leaf text-success" style="font-size: 30rem;"></i>
    </div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-md-5" data-aos="zoom-in" data-aos-duration="1000">
                <div class="card border-0 shadow-lg glass rounded-5 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <div class="bg-soft d-inline-flex align-items-center justify-content-center rounded-circle mb-3 shadow-inner" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-lock text-success fs-2"></i>
                            </div>
                            <h2 class="brand-font fw-bold text-main mb-2">{{ __('Bon retour !') }}</h2>
                            <p class="opacity-75 text-main">{{ __('Connectez-vous pour gérer vos favoris et partager des recettes.') }}</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Adresse Email') }}</label>
                                <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                    <span class="input-group-text bg-transparent border-0 ps-3"><i class="fas fa-envelope opacity-50 text-main"></i></span>
                                    <input type="email" id="email" name="email" class="form-control border-0 bg-transparent shadow-none py-2 px-3 text-main @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="{{ __('votre@email.com') }}">
                                </div>
                                @error('email')
                                    <span class="text-danger small ms-3 mt-1 d-block fw-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Mot de passe') }}</label>
                                <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                    <span class="input-group-text bg-transparent border-0 ps-3"><i class="fas fa-key opacity-50 text-main"></i></span>
                                    <input type="password" id="password" name="password" class="form-control border-0 bg-transparent shadow-none py-2 px-3 text-main @error('password') is-invalid @enderror" required placeholder="••••••••">
                                </div>
                                @error('password')
                                    <span class="text-danger small ms-3 mt-1 d-block fw-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-5 px-2">
                                <div class="form-check">
                                    <input class="form-check-input border-color" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small text-main opacity-75" for="remember">
                                        {{ __('Se souvenir de moi') }}
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="small text-decoration-none text-success fw-bold" href="{{ route('password.request') }}">
                                        {{ __('Oublié ?') }}
                                    </a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-main w-100 rounded-pill py-3 fw-bold shadow-md transform-hover mb-4">
                                <i class="fas fa-sign-in-alt me-2"></i>{{ __('Se connecter') }}
                            </button>

                            <div class="text-center">
                                <p class="small text-main opacity-75 mb-0">
                                    {{ __('Pas encore de compte ?') }} 
                                    <a href="{{ route('register') }}" class="text-success fw-bold text-decoration-none">{{ __('Créer un compte') }}</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .glass-input:focus-within {
        border-color: var(--btn-bg) !important;
        box-shadow: 0 0 15px rgba(107, 142, 35, 0.15) !important;
        background: rgba(255,255,255,0.8);
    }
    .shadow-xs { box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .shadow-inner { box-shadow: inset 0 2px 4px rgba(0,0,0,0.05); }
    .transform-hover:hover { transform: translateY(-3px); }
</style>
@endsection
