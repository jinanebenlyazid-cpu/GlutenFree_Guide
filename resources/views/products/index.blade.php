@extends('main')

@section('title', __('Catalogue de Produits Sans Gluten'))

@section('content')
<style>
/* ── Custom Select Dropdown ────────────────────────────── */
.custom-select-container {
    position: relative;
    border-radius: 50px;
    overflow: visible;
}
.custom-select-trigger {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 16px;
    cursor: pointer;
    user-select: none;
    border-radius: 50px;
    transition: background 0.18s;
}
.custom-select-trigger:hover { background: var(--bg-soft); }
.dropdown-arrow {
    font-size: .7rem;
    opacity: .45;
    margin-left: auto;
    transition: transform .25s cubic-bezier(.34,1.56,.64,1);
}
.custom-select-container.open .dropdown-arrow { transform: rotate(180deg); }

.custom-select-menu {
    position: absolute;
    top: calc(100% + 10px);
    left: 0; right: 0;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 18px;
    box-shadow: 0 16px 48px rgba(0,0,0,.14), 0 4px 16px rgba(0,0,0,.08);
    list-style: none;
    margin: 0; padding: 6px;
    z-index: 9999;
    opacity: 0;
    transform: translateY(-10px) scale(.97);
    pointer-events: none;
    transition: opacity .2s ease, transform .2s cubic-bezier(.34,1.56,.64,1);
    max-height: 280px;
    overflow-y: auto;
}
.custom-select-container.open .custom-select-menu {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: all;
}
.custom-select-item {
    padding: 10px 14px;
    border-radius: 11px;
    cursor: pointer;
    font-size: .86rem;
    color: var(--text-main);
    transition: background .13s;
    margin-bottom: 2px;
}
.custom-select-item:hover { background: var(--bg-soft); }
.custom-select-item.active {
    background: var(--btn-bg);
    color: #fff;
    font-weight: 600;
}
</style>

<section class="section py-5" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container-fluid px-lg-5">
        <div class="row mb-5 align-items-center" data-aos="fade-up">
            <div class="col-md-12 text-center text-md-start">
                <h1 class="brand-font fw-bold mb-2 display-5 text-main">{{ __('Produits Certifiés Sans Gluten') }} <i class="fas fa-seedling ms-2 text-success"></i></h1>
                <p class="opacity-75 mb-0 fs-5 text-main">{{ __('Explorez notre large sélection de produits garantis sans gluten au Maroc.') }}</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Sidebar list -->
            <div class="col-lg-3" data-aos="fade-right" data-aos-delay="100">
                <div class="card card-custom border-0 shadow-sm p-4 sticky-top glass" style="top: 100px; border-radius: 24px; overflow: visible;">
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

                        <!-- Categories Section – Custom Dropdown -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Catégories') }}</label>

                            {{-- Hidden input sent with the form --}}
                            <input type="hidden" name="category" id="categoryHidden" value="{{ request('category') }}">

                            <div class="custom-select-container glass-input border border-color shadow-xs" id="customCategorySelect">
                                <div class="custom-select-trigger" onclick="toggleCategoryDropdown(event)">
                                    <i class="fas fa-tag opacity-30 text-main" style="width:14px;flex-shrink:0"></i>
                                    <span class="text-main small" id="selectedCategoryText" style="min-width:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">
                                        @php $selCat = request('category'); @endphp
                                        {{ $selCat ? __($selCat) : __('Toutes les catégories') }}
                                    </span>
                                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                                </div>

                                <ul class="custom-select-menu" id="categoryMenu">
                                    <li class="custom-select-item {{ !$selCat ? 'active' : '' }}"
                                        data-value=""
                                        onclick="selectCategoryOption(event,'','{{ __('Toutes les catégories') }}')">
                                        <i class="fas fa-th-large me-2 opacity-40" style="width:14px"></i>{{ __('Toutes les catégories') }}
                                    </li>
                                    @foreach($categories as $cat)
                                        @if($cat)
                                        <li class="custom-select-item {{ $selCat == $cat ? 'active' : '' }}"
                                            data-value="{{ $cat }}"
                                            onclick="selectCategoryOption(event,'{{ $cat }}','{{ __($cat) }}')">
                                            {{ __($cat) }}
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
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
        @include('products.show_modal', ['product' => $product])
    @endforeach
@endif

@if(isset($selectedProduct) && !$products->contains($selectedProduct))
    @include('products.show_modal', ['product' => $selectedProduct])
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

<script>
/* ── Custom Category Dropdown ─────────────────────────── */
(function () {
    const container = document.getElementById('customCategorySelect');
    if (!container) return;

    // Close when clicking outside
    document.addEventListener('click', function (e) {
        if (!container.contains(e.target)) container.classList.remove('open');
    });

    window.toggleCategoryDropdown = function (e) {
        e.stopPropagation();
        container.classList.toggle('open');
    };

    window.selectCategoryOption = function (e, value, label) {
        e.stopPropagation();
        document.getElementById('categoryHidden').value = value;
        document.getElementById('selectedCategoryText').textContent = label;

        document.querySelectorAll('#categoryMenu .custom-select-item').forEach(function (item) {
            item.classList.toggle('active', item.dataset.value === value);
        });

        container.classList.remove('open');
        document.getElementById('filterForm').submit();
    };
})();
</script>
@endsection
