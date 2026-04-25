@extends('main')

@section('title', __('Ajouter un Produit - Admin'))

@section('content')
<section class="section py-5" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-custom border-0 shadow-lg p-5">
                    <div class="mb-4">
                        <a href="{{ route('admin.products.index') }}" class="text-decoration-none small" style="color: var(--btn-bg);">
                            <i class="fas fa-arrow-left me-1"></i> {{ __('Retour à la liste') }}
                        </a>
                        <h2 class="brand-font fw-bold mt-2 mb-1">{{ __('Ajouter un Produit') }} 🛒</h2>
                        <p class="opacity-75">{{ __('Créez un nouveau produit pour le catalogue.') }}</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 mb-4">
                            <ul class="mb-0 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.products.store') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label fw-bold">{{ __('Nom du produit') }} *</label>
                                <input type="text" class="form-control border-color bg-transparent" id="name" name="name" value="{{ old('name') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label fw-bold">{{ __('Catégorie') }} *</label>
                                <select class="form-select border-color bg-transparent" id="category" name="category" required>
                                    <option value="">{{ __('Choisir...') }}</option>
                                    <option value="Farine & Mix">{{ __('Farines / Mix') }}</option>
                                    <option value="Biscuits & Pâtisserie">{{ __('Biscuits / Pâtisserie') }}</option>
                                    <option value="Pâtes & Riz">{{ __('Pâtes / Riz') }}</option>
                                    <option value="Pain & Boulangerie">{{ __('Pains / Boulangerie') }}</option>
                                    <option value="Boissons">{{ __('Boissons') }}</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold">{{ __('Prix (DH)') }} *</label>
                                <input type="number" step="0.01" class="form-control border-color bg-transparent" id="price" name="price" value="{{ old('price') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label fw-bold">{{ __('Ville / Disponibilité') }} *</label>
                                <input type="text" class="form-control border-color bg-transparent" id="city" name="city" value="{{ old('city') }}" placeholder="{{ __('Ex: Casablanca, National...') }}" required>
                            </div>

                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check form-switch p-3 bg-light rounded-3 w-100 border border-color">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" id="is_certified" name="is_certified" value="1" {{ old('is_certified') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="is_certified">{{ __('Certifié Sans Gluten') }}</label>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="image_url" class="form-label fw-bold">{{ __('URL de l\'image') }}</label>
                                <input type="text" class="form-control border-color bg-transparent" id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="https://...">
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="description" class="form-label fw-bold">{{ __('Description') }}</label>
                                <textarea class="form-control border-color bg-transparent" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-main w-100 py-3 rounded-pill fw-bold shadow-sm">
                                    <i class="fas fa-save me-2"></i> {{ __('Enregistrer le produit') }}
                                </button>
                            </div>
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
