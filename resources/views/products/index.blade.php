@extends('main')

@section('title', __('Catalogue de Produits Sans Gluten'))

@section('content')
<section class="section py-5" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container-fluid px-lg-5">
        <div class="row mb-5 align-items-center" data-aos="fade-up">
            <div class="col-md-12 text-center text-md-start">
                <h1 class="brand-font fw-bold mb-2 display-5 text-main">{{ __('Produits Certifiés Sans Gluten') }} 🌾</h1>
                <p class="opacity-75 mb-0 fs-5 text-main">{{ __('Explorez notre large sélection de produits garantis sans gluten au Maroc.') }}</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Sidebar list -->
            <div class="col-lg-3" data-aos="fade-right" data-aos-delay="100">
                <div class="card card-custom border-0 shadow-sm p-4 sticky-top glass" style="top: 100px; border-radius: 24px;">
                    <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                        <!-- Search Section -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Recherche') }}</label>
                            <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                <span class="input-group-text bg-transparent border-0 ps-3"><i class="fas fa-search opacity-30 text-main"></i></span>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 bg-transparent shadow-none py-2 px-3 text-main" placeholder="{{ __('Nom du produit...') }}">
                            </div>
                        </div>

                        <!-- Price Filter Section -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Prix (DH)') }}</label>
                            <div class="d-flex gap-2">
                                <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control border-0 bg-transparent shadow-none py-1 px-3 text-main small" placeholder="{{ __('Min') }}">
                                </div>
                                <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control border-0 bg-transparent shadow-none py-1 px-3 text-main small" placeholder="{{ __('Max') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Categories Section -->
                        <div class="mb-4">
                            <label for="category" class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Catégories') }}</label>
                            <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                <span class="input-group-text bg-transparent border-0 ps-3"><i class="fas fa-tag opacity-30 text-main"></i></span>
                                <select name="category" id="category" class="form-select border-0 bg-transparent shadow-none py-2 px-3 text-main small" onchange="this.form.submit()">
                                    <option value="">{{ __('Toutes les catégories') }}</option>
                                    @foreach($categories as $cat)
                                        @if($cat)
                                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ __($cat) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-main rounded-pill fw-bold shadow-sm">
                                <i class="fas fa-filter me-2 fs-6"></i>{{ __('Appliquer') }}
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-soft-secondary rounded-pill fw-bold text-decoration-none text-center fs-7">
                                {{ __('Réinitialiser') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="col-lg-9">
                @if($products->count() > 0)
                    <div class="row g-4" data-aos="fade-up" data-aos-delay="200">
                        @foreach($products as $product)
                            <div class="col-md-6 col-xl-4 d-flex align-items-stretch">
                                <div class="card card-custom border-0 shadow-sm w-100 overflow-hidden product-card" style="border-radius: 20px;">
                                    <div class="position-absolute top-0 end-0 p-2 z-1">
                                        <span class="badge {{ $product->is_certified ? 'bg-success' : 'bg-warning text-dark' }} shadow-sm">
                                            <i class="fas fa-{{ $product->is_certified ? 'check-circle' : 'exclamation-circle' }} me-1"></i> 
                                            {{ $product->is_certified ? __('Certifié') : __('À vérifier') }}
                                        </span>
                                    </div>
                                    <div class="bg-white-adaptive" style="height: 220px; display:flex; align-items:center; justify-content:center; cursor:pointer;"
                                         data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                                        <img src="{{ asset($product->image_url) }}" class="img-fluid" alt="{{ $product->name }}" style="max-height: 100%; object-fit: contain; padding: 15px;">
                                    </div>
                                    <div class="card-body d-flex flex-column border-top border-color">
                                        <div class="mb-2">
                                            <span class="badge bg-soft text-main border border-color px-2 py-1">{{ __($product->category) }}</span>
                                        </div>
                                        <h5 class="fw-bold brand-font mb-2 text-main">{{ __($product->name) }}</h5>
                                        <p class="small opacity-75 mb-3 flex-grow-1 text-main">{{ __(\Illuminate\Support\Str::limit($product->description, 70)) }}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
                                            <span class="fw-bold fs-5 text-success">{{ number_format($product->price, 2) }} {{ __('DH') }}</span>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-soft-primary rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                                                    <i class="fas fa-eye me-1"></i>{{ __('Détails') }}
                                                </button>
                                                <button class="btn btn-sm btn-light border-color rounded-circle d-flex align-items-center justify-content-center shadow-sm share-btn" 
                                                        data-url="{{ route('products.show', $product->id) }}" 
                                                        data-title="{{ __($product->name) }}"
                                                        style="width:38px;height:38px;" title="{{ __('Partager') }}">
                                                    <i class="fas fa-share-alt text-primary"></i>
                                                </button>
                                                @auth
                                                    <form action="{{ route('favorites.toggle') }}" method="POST" class="favorite-toggle-form">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                                        <input type="hidden" name="type" value="product">
                                                        <button type="submit" class="btn btn-sm btn-light border-color rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:38px;height:38px;">
                                                            <i class="{{ $product->favorites()->where('user_id', auth()->id())->exists() ? 'fas' : 'far' }} fa-heart text-danger"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('login') }}" class="btn btn-sm btn-light border-color rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:38px;height:38px;">
                                                        <i class="far fa-heart"></i>
                                                    </a>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-5 d-flex justify-content-center" data-aos="fade-up">
                        {{ $products->links('vendor.pagination.custom') }}
                    </div>
                @else
                    <div class="card card-custom border-0 shadow-sm p-5 text-center d-flex flex-column align-items-center justify-content-center glass rounded-5" data-aos="zoom-in">
                        <i class="fas fa-box-open fs-1 text-muted mb-4 opacity-25" style="font-size: 5rem !important;"></i>
                        <h4 class="fw-bold brand-font text-main mb-3">{{ __('Aucun produit trouvé') }}</h4>
                        <p class="opacity-75 mb-4 fs-5 text-main">{{ __('Désolé, nous n\'avons trouvé aucun produit correspondant à vos filtres.') }}</p>
                        <a href="{{ route('products.index') }}" class="btn btn-main rounded-pill px-5 py-3 fw-bold shadow-md">{{ __('Afficher tous les produits') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- MODALS OUTSIDE FOR BETTER PERFORMANCE -->
@if($products->count() > 0)
    @foreach($products as $product)
        <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content card-custom border-0 shadow-lg" style="border-radius: 24px;">
                    <div class="modal-header border-0 pb-0 px-4 pt-4">
                        <h4 class="fw-bold brand-font mb-0 text-main">{{ __($product->name) }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6 text-center">
                                <div class="bg-white-adaptive rounded-4 p-3 border border-color d-flex align-items-center justify-content-center h-100 shadow-inner" style="min-height: 300px;">
                                    <img src="{{ asset($product->image_url) }}" class="img-fluid" style="max-height: 300px; object-fit: contain;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="badge bg-soft text-main px-3 py-2 rounded-pill mb-3 border border-color">{{ __($product->category) }}</span>
                                <h3 class="fw-bold text-success mb-3">{{ number_format($product->price, 2) }} {{ __('DH') }}</h3>
                                <p class="opacity-75 mb-4 text-main fs-6 l-h-base">{{ __($product->description) }}</p>
                                @if($product->ingredients)
                                    <div class="p-4 rounded-4 border border-color bg-soft text-start shadow-sm">
                                        <strong class="brand-font d-block mb-2 text-main"><i class="fas fa-layer-group me-2 text-success"></i>{{ __('Ingrédients / Composition') }}</strong>
                                        <p class="small text-main mb-0 lh-base opacity-75">{{ __($product->ingredients) }}</p>
                                    </div>
                                @endif
                                <div class="mt-4 d-flex gap-2">
                                     @auth
                                        <form action="{{ route('favorites.toggle') }}" method="POST" class="favorite-toggle-form flex-grow-1">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <input type="hidden" name="type" value="product">
                                            <button type="submit" class="btn btn-outline-danger w-100 rounded-pill fw-bold">
                                                <i class="fas fa-heart me-2"></i>{{ $product->favorites()->where('user_id', auth()->id())->exists() ? __('Retirer des favoris') : __('Ajouter aux favoris') }}
                                            </button>
                                        </form>
                                    @endauth
                                    <button class="btn btn-soft-secondary rounded-pill px-4" data-bs-dismiss="modal">{{ __('Fermer') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

<style>
    .glass-input:focus-within { border-color: var(--btn-bg) !important; box-shadow: 0 0 15px rgba(107, 142, 35, 0.1) !important; background: var(--bg-soft); }
    .product-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; }
    .hover-bg-soft:hover { background-color: var(--bg-soft); transform: translateX(5px); }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: var(--btn-bg); border-radius: 10px; }
    .btn-soft-primary { background-color: rgba(107, 142, 35, 0.1); color: var(--btn-bg); border: none; transition: 0.3s; }
    .btn-soft-primary:hover { background-color: var(--btn-bg); color: #fff; }
    .btn-soft-secondary { background: var(--bg-soft); color: var(--text-main); border: none; }
    .btn-soft-secondary:hover { background: var(--border-color); }
    html[data-bs-theme="dark"] .card-body { background-color: var(--card-bg) !important; }
    .l-h-base { line-height: 1.6; }
    .fs-7 { font-size: 0.85rem; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-open modal if ID is in URL
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('product');
    if (productId) {
        const modalEl = document.getElementById('productModal' + productId);
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    }

    // Sharing logic
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const url = this.dataset.url;
            const title = this.dataset.title;

            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                }).catch(console.error);
            } else {
                // Fallback: Copy to clipboard
                const dummy = document.createElement('input');
                document.body.appendChild(dummy);
                dummy.value = window.location.origin + url;
                dummy.select();
                document.execCommand('copy');
                document.body.removeChild(dummy);
                
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check text-success"></i>';
                setTimeout(() => {
                    this.innerHTML = originalHtml;
                }, 2000);
            }
        });
    });
});
</script>
@endsection
