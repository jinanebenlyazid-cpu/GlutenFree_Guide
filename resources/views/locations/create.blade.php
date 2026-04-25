@extends('main')

@section('title', __('Ajouter un lieu - Guide Gluten-Free'))

@section('content')
<section class="section py-5" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-custom border-0 shadow-lg p-5">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 shadow-sm" style="width: 60px; height: 60px; background-color: var(--btn-bg); color: white; font-size: 1.5rem;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h2 class="brand-font fw-bold mb-1">{{ __('Ajouter un lieu') }} 📍</h2>
                        <p class="opacity-75">{{ __('Partagez une adresse sans gluten avec la communauté !') }}</p>
                        <div class="alert border-0 rounded-3 d-inline-flex align-items-center gap-2 px-4 py-2" style="background-color: var(--bg-soft); color: var(--text-main); font-size: 0.85rem;">
                            <i class="fas fa-info-circle" style="color: var(--btn-bg);"></i>
                            {{ __('Le lieu sera examiné par un administrateur avant d\'apparaître sur la carte.') }}
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 mb-3" style="font-size: 0.9rem;">
                            @foreach($errors->all() as $error)
                                <div><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('locations.store') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">{{ __('Nom du lieu') }} *</label>
                            <input type="text" class="form-control border-color bg-transparent" style="color: var(--text-main);" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('Ex: Boulangerie Bio Sans Gluten') }}" required>
                        </div>

                        <!-- Type -->
                        <div class="mb-4">
                            <label for="type" class="form-label fw-bold">{{ __('Type d\'établissement') }} *</label>
                            <select class="form-select border-color bg-transparent" style="color: var(--text-main);" id="type" name="type" required>
                                <option value="">{{ __('Choisir un type...') }}</option>
                                <option value="Restaurant">{{ __('Restaurant') }}</option>
                                <option value="Boulangerie">{{ __('Boulangerie') }}</option>
                                <option value="Magasin">{{ __('Magasin Spécialisé') }}</option>
                                <option value="Supermarché">{{ __('Supermarché') }}</option>
                                <option value="Autre">{{ __('Autre') }}</option>
                            </select>
                        </div>

                        <!-- City & Address -->
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="city" class="form-label fw-bold">{{ __('Ville') }} *</label>
                                <input type="text" class="form-control border-color bg-transparent" style="color: var(--text-main);" id="city" name="city" value="{{ old('city') }}" placeholder="{{ __('Ex: Casablanca') }}" required>
                            </div>
                            <div class="col-md-8 mb-4">
                                <label for="address" class="form-label fw-bold">{{ __('Adresse complète') }} *</label>
                                <input type="text" class="form-control border-color bg-transparent" style="color: var(--text-main);" id="address" name="address" value="{{ old('address') }}" placeholder="{{ __('Ex: 12 Rue des Oliviers...') }}" required>
                            </div>
                        </div>

                        <!-- Latitude & Longitude (Optional) -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="latitude" class="form-label fw-bold">{{ __('Latitude') }} <span class="fw-normal opacity-50">({{ __('Optionnel') }})</span></label>
                                <input type="number" step="any" class="form-control border-color bg-transparent" style="color: var(--text-main);" id="latitude" name="latitude" value="{{ old('latitude') }}" placeholder="33.5731">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="longitude" class="form-label fw-bold">{{ __('Longitude') }} <span class="fw-normal opacity-50">({{ __('Optionnel') }})</span></label>
                                <input type="number" step="any" class="form-control border-color bg-transparent" style="color: var(--text-main);" id="longitude" name="longitude" value="{{ old('longitude') }}" placeholder="-7.5898">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">{{ __('Description') }}</label>
                            <textarea class="form-control border-color bg-transparent" style="color: var(--text-main);" id="description" name="description" rows="3" placeholder="{{ __('Détails sur l\'offre sans gluten...') }}">{{ old('description') }}</textarea>
                        </div>

                        <div class="d-flex gap-3">
                            <a href="{{ route('locations.index') }}" class="btn btn-soft-secondary py-3 rounded-pill fw-bold shadow-sm flex-grow-1 text-decoration-none text-center" style="background-color: var(--bg-soft); color: var(--text-main);">
                                <i class="fas fa-arrow-left me-2"></i> {{ __('Retour') }}
                            </a>
                            <button type="submit" class="btn btn-main py-3 rounded-pill fw-bold shadow-sm flex-grow-1">
                                <i class="fas fa-paper-plane me-2"></i> {{ __('Soumettre le lieu') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .form-control:focus, .form-select:focus {
        background-color: transparent;
        color: var(--text-main);
        box-shadow: 0 0 0 0.25rem rgba(107, 142, 35, 0.25);
        border-color: var(--btn-bg);
    }
</style>
@endsection
