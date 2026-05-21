@extends('main')

@section('title', __('Inscription - Guide Gluten-Free'))

@section('content')
<section class="section d-flex align-items-center justify-content-center py-5" 
         style="background: linear-gradient(135deg, #e8f5e9 0%, var(--bg-soft) 100%); min-height: calc(100vh - 100px); position: relative; overflow: hidden;">
    
    <!-- Decorative elements -->
    <div class="position-absolute bottom-0 end-0 opacity-25" style="transform: translate(30%, 30%); z-index: 0;">
        <i class="fas fa-seedling text-success" style="font-size: 25rem;"></i>
    </div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6" data-aos="fade-up" data-aos-duration="1000">
                <div class="card border-0 shadow-lg glass rounded-5 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <div class="bg-soft d-inline-flex align-items-center justify-content-center rounded-circle mb-3 shadow-inner" style="width: 70px; height: 70px;">
                                <i class="fas fa-user-plus text-success fs-3"></i>
                            </div>
                            <h2 class="brand-font fw-bold text-main mb-2">{{ __('Rejoignez-nous') }} 🌿</h2>
                            <p class="opacity-75 text-main">{{ __('Créez votre compte pour sauvegarder vos lieux et recettes favoris.') }}</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <div class="row g-3 mb-4">
                                <!-- First Name -->
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Prénom') }}</label>
                                    <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                        <input type="text" id="first_name" name="first_name" class="form-control border-0 bg-transparent shadow-none py-2 px-3 text-main @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required placeholder="{{ __('Prénom') }}">
                                    </div>
                                    @error('first_name')
                                        <span class="text-danger small ms-3 mt-1 d-block fw-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Last Name -->
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Nom') }}</label>
                                    <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                        <input type="text" id="last_name" name="last_name" class="form-control border-0 bg-transparent shadow-none py-2 px-3 text-main @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required placeholder="{{ __('Nom') }}">
                                    </div>
                                    @error('last_name')
                                        <span class="text-danger small ms-3 mt-1 d-block fw-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Adresse Email') }}</label>
                                <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                    <span class="input-group-text bg-transparent border-0 ps-3"><i class="fas fa-envelope opacity-50 text-main"></i></span>
                                    <input type="email" id="email" name="email" class="form-control border-0 bg-transparent shadow-none py-2 px-3 text-main @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="{{ __('votre@email.com') }}">
                                </div>
                                @error('email')
                                    <span class="text-danger small ms-3 mt-1 d-block fw-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="mb-4">
                                <label for="city" class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Ville') }}</label>
                                <div class="glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                    <select id="city" name="city" class="form-select border-0 bg-transparent shadow-none py-2 px-3 text-main @error('city') is-invalid @enderror">
                                        <option value="" selected disabled>{{ __('Sélectionnez votre ville') }}</option>
                                        <option value="Casablanca">{{ __('Casablanca') }}</option>
                                        <option value="Rabat">{{ __('Rabat') }}</option>
                                        <option value="Marrakech">{{ __('Marrakech') }}</option>
                                        <option value="Tanger">{{ __('Tanger') }}</option>
                                        <option value="Agadir">{{ __('Agadir') }}</option>
                                        <option value="Fès">{{ __('Fès') }}</option>
                                        <option value="Autre">{{ __('Autre') }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="row g-3 mb-5">
                                <div class="col-md-6 text-main">
                                    <label for="password" class="form-label small fw-bold opacity-75 ms-2">{{ __('Mot de passe') }}</label>
                                    <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                        <input type="password" id="password" name="password" class="form-control border-0 bg-transparent shadow-none py-2 px-3 text-main @error('password') is-invalid @enderror" required placeholder="••••••••">
                                    </div>
                                    @error('password')
                                        <span class="text-danger small ms-3 mt-1 d-block fw-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 text-main">
                                    <label for="password_confirmation" class="form-label small fw-bold opacity-75 ms-2">{{ __('Confirmation') }}</label>
                                    <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control border-0 bg-transparent shadow-none py-2 px-3" required placeholder="••••••••">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-main w-100 rounded-pill py-3 fw-bold shadow-md transform-hover mb-4">
                                <i class="fas fa-user-plus me-2"></i>{{ __('Créer mon compte') }}
                            </button>

                            <div class="text-center">
                                <p class="small text-main opacity-75 mb-0">
                                    {{ __('Déjà inscrit ?') }} 
                                    <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">{{ __('Se connecter') }}</a>
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
    html[data-bs-theme="dark"] .form-select option { background-color: var(--card-bg); color: #fff; }
</style>
@endsection
