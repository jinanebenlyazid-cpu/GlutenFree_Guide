@extends('main')

@section('title', __('Mes Favoris - Guide Gluten-Free'))

@section('content')
<section class="section py-5" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container mt-4">
        <div class="row mb-5 align-items-center" data-aos="fade-up">
            <div class="col-md-6">
                <h1 class="brand-font fw-bold mb-2 display-5 text-main">{{ __('Mes Favoris') }} ❤️</h1>
                <p class="opacity-75 mb-0 fs-5 text-main">{{ __('Retrouvez ici tout ce que vous avez aimé sur la plateforme.') }}</p>
            </div>
        </div>

        <!-- Tabs Nav -->
        <ul class="nav nav-pills mb-5 gap-3" id="favoriteTabs" role="tablist" data-aos="fade-up" data-aos-delay="100">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4 py-2 fw-bold shadow-sm glass border-color" id="products-tab" data-bs-toggle="pill" data-bs-target="#products" type="button" role="tab">{{ __('Produits') }} ({{ $favoriteProducts->count() }}) </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 fw-bold shadow-sm glass border-color" id="recipes-tab" data-bs-toggle="pill" data-bs-target="#recipes" type="button" role="tab">{{ __('Recettes') }} ({{ $favoriteRecipes->count() }})</button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="favoriteTabsContent" data-aos="fade-up" data-aos-delay="200">
            
            <!-- Products Tab -->
            <div class="tab-pane fade show active" id="products" role="tabpanel">
                @if($favoriteProducts->count() > 0)
                    <div class="row g-4">
                        @foreach($favoriteProducts as $product)
                            <div class="col-md-6 col-lg-4 col-xl-3 d-flex align-items-stretch">
                                <div class="card card-custom border-0 shadow-sm w-100 overflow-hidden" style="border-radius: 20px;">
                                    <div class="position-absolute top-0 end-0 p-2 z-1">
                                        <span class="badge {{ $product->is_certified ? 'bg-success' : 'bg-warning text-dark' }} shadow-sm">
                                            <i class="fas fa-{{ $product->is_certified ? 'check-circle' : 'exclamation-circle' }} me-1"></i> 
                                            {{ $product->is_certified ? __('Certifié') : __('À vérifier') }}
                                        </span>
                                    </div>
                                    <div class="bg-white-adaptive" style="height: 220px; display:flex; align-items:center; justify-content:center; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                                        <img src="{{ asset($product->image_url) }}" class="img-fluid" alt="{{ $product->name }}" style="max-height: 100%; object-fit: contain;">
                                    </div>
                                    <div class="card-body d-flex flex-column border-top border-color">
                                        <div class="mb-2">
                                            <span class="badge bg-soft text-main border border-color px-2 py-1">{{ __($product->category) }}</span>
                                        </div>
                                        <h5 class="fw-bold brand-font mb-2 text-main">{{ __($product->name) }}</h5>
                                        <p class="small opacity-75 mb-3 flex-grow-1 text-main">{{ __(Str::limit($product->description, 60)) }}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
                                            <span class="fw-bold fs-5 text-success">{{ number_format($product->price, 2) }} {{ __('DH') }}</span>
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('favorites.toggle') }}" method="POST" class="favorite-toggle-form">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                                    <input type="hidden" name="type" value="product">
                                                    <button type="submit" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; color: #ff4757;">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 glass rounded-5 border border-color">
                        <i class="far fa-heart fs-1 mb-3 opacity-25"></i>
                        <h4 class="brand-font fw-bold opacity-50">{{ __('Aucun produit en favori') }}</h4>
                        <a href="{{ route('products.index') }}" class="btn btn-main mt-3">{{ __('Explorer le catalogue') }}</a>
                    </div>
                @endif
            </div>

            <!-- Recipes Tab -->
            <div class="tab-pane fade" id="recipes" role="tabpanel">
                @if($favoriteRecipes->count() > 0)
                    <div class="row g-4">
                        @foreach($favoriteRecipes as $recipe)
                            <div class="col-md-6 col-lg-4 col-xl-3 d-flex align-items-stretch">
                                <div class="card card-custom border-0 shadow-sm w-100 overflow-hidden recipe-card" style="border-radius: 20px;">
                                    <div class="position-relative" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#recipeModal{{ $recipe->id }}">
                                        <img src="{{ asset($recipe->image_url ?? 'images/default-recipe.jpg') }}" class="card-img-top" alt="{{ $recipe->name }}" style="height: 220px; object-fit: cover;">
                                        <div class="position-absolute top-0 end-0 p-3 z-1">
                                            <form action="{{ route('favorites.toggle') }}" method="POST" class="favorite-toggle-form" onclick="event.stopPropagation();">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $recipe->id }}">
                                                <input type="hidden" name="type" value="recipe">
                                                <button type="submit" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; color: #ff4757;">
                                                    <i class="fas fa-heart"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="position-absolute bottom-0 start-0 w-100 p-3 z-1 text-white" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                            <h5 class="fw-bold brand-font mb-1">{{ __($recipe->name) }}</h5>
                                            <div class="d-flex align-items-center small gap-3">
                                                <span><i class="fas fa-clock text-warning me-1"></i> {{ $recipe->prep_time }} {{ __('min') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-4 d-flex flex-column bg-white-adaptive">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($recipe->user->name ?? 'User') }}&background=6b8e23&color=fff" class="rounded-circle" width="24" height="24">
                                            <span class="small opacity-75 fw-bold text-main">{{ $recipe->user->name ?? __('Communauté') }}</span>
                                        </div>
                                        <button class="btn btn-main w-100 rounded-pill btn-sm mt-auto" data-bs-toggle="modal" data-bs-target="#recipeModal{{ $recipe->id }}">
                                            {{ __('Voir la recette') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 glass rounded-5 border border-color">
                        <i class="far fa-heart fs-1 mb-3 opacity-25"></i>
                        <h4 class="brand-font fw-bold opacity-50">{{ __('Aucune recette en favori') }}</h4>
                        <a href="{{ route('recipes.index') }}" class="btn btn-main mt-3">{{ __('Découvrir des recettes') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- MODALS CONTAINER (Placed outside main section to avoid z-index/transform issues) -->
<div id="favorites-modals">
    <!-- Product Modals -->
    @foreach($favoriteProducts as $product)
        <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productTitle{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content card-custom border-0 shadow-lg" style="border-radius: 24px;">
                    <div class="modal-header border-0 pb-0 px-4 pt-4">
                        <h4 class="fw-bold brand-font mb-0 text-main" id="productTitle{{ $product->id }}">{{ __($product->name) }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-4 mb-3">
                            <div class="col-md-5 text-center">
                                <div class="bg-white-adaptive rounded-4 p-3 border border-color d-flex align-items-center justify-content-center" style="height: 300px;">
                                    <img src="{{ asset($product->image_url) }}" class="img-fluid" style="max-height: 280px; object-fit: contain;">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h3 class="fw-bold text-success mb-3">{{ number_format($product->price, 2) }} {{ __('DH') }}</h3>
                                <p class="opacity-75 mb-4 text-main fs-6">{{ __($product->description) }}</p>
                                @if($product->ingredients)
                                    <div class="p-4 rounded-4 border border-color bg-soft text-start shadow-sm">
                                        <strong class="brand-font d-block mb-2 text-main"><i class="fas fa-layer-group me-2 text-success"></i>{{ __('Ingrédients') }}</strong>
                                        <p class="small text-main mb-0 lh-base">{{ __($product->ingredients) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Recipe Modals -->
    @foreach($favoriteRecipes as $recipe)
        <div class="modal fade" id="recipeModal{{ $recipe->id }}" tabindex="-1" aria-labelledby="recipeTitle{{ $recipe->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content card-custom border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
                    <div class="row g-0 h-100">
                        <div class="col-md-5 d-none d-md-block" style="background: url('{{ asset($recipe->image_url ?? 'images/default-recipe.jpg') }}') center/cover;"></div>
                        <div class="col-md-7">
                            <div class="modal-header border-0 pb-0 pt-4 px-4">
                                <h3 class="modal-title fw-bold brand-font text-main" id="recipeTitle{{ $recipe->id }}" style="color: var(--btn-bg) !important;">{{ __($recipe->name) }}</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="d-flex gap-4 mb-4 pb-3 border-bottom border-color text-main">
                                    <div class="text-center">
                                        <i class="fas fa-clock fs-4 mb-1 opacity-50"></i>
                                        <div class="small fw-bold">{{ $recipe->prep_time }} {{ __('min') }}</div>
                                    </div>
                                    <div class="text-center">
                                        <i class="fas fa-utensils fs-4 mb-1 opacity-50"></i>
                                        <div class="small fw-bold">{{ __(ucfirst($recipe->difficulty)) }}</div>
                                    </div>
                                </div>
                                <h6 class="fw-bold mb-3 text-main"><i class="fas fa-clipboard-list me-2 text-success"></i>{{ __('Ingrédients') }}</h6>
                                <ul class="list-unstyled mb-4 small text-main">
                                    @if(is_array($recipe->ingredients))
                                        @foreach($recipe->ingredients as $ingredient)
                                            <li class="mb-2"><i class="fas fa-check text-success me-2 small"></i>{{ $ingredient }}</li>
                                        @endforeach
                                    @else
                                        <li>{{ $recipe->ingredients }}</li>
                                    @endif
                                </ul>
                                <h6 class="fw-bold mb-3 text-main"><i class="fas fa-list-ol me-2 text-success"></i>{{ __('Préparation') }}</h6>
                                <ol class="ps-3 mb-0 small text-main l-h-base">
                                    @if(is_array($recipe->steps))
                                        @foreach($recipe->steps as $step)
                                            <li class="mb-3">{{ $step }}</li>
                                        @endforeach
                                    @else
                                        <li>{{ $recipe->steps }}</li>
                                    @endif
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
    .nav-pills .nav-link { color: var(--text-main); background: transparent; transition: 0.3s; }
    .nav-pills .nav-link.active { background-color: var(--btn-bg) !important; color: white !important; box-shadow: 0 10px 20px rgba(45, 90, 39, 0.2) !important; }
    .product-card:hover, .recipe-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    html[data-bs-theme="dark"] .card-body, html[data-bs-theme="dark"] .modal-content { background-color: var(--card-bg) !important; }
    .l-h-base { line-height: 1.6; }
    
    /* Ensure modal body is scrollable if content overflows */
    .modal-dialog-scrollable .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
    
    /* Prevent double scrollbar if possible, while keeping modal functional */
    body.modal-open {
        overflow: hidden !important;
        padding-right: 0 !important;
    }
</style>
@endsection
