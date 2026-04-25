@extends('main')

@section('title', __('Gestion des Produits - Admin'))

@section('content')
<section class="section py-4" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container-fluid px-lg-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none" style="color: var(--btn-bg);">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Produits') }}</li>
                    </ol>
                </nav>
                <h1 class="brand-font fw-bold mb-0">{{ __('Gestion des Produits') }} 🛒</h1>
            </div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-main rounded-pill px-4 shadow-sm fw-bold">
                <i class="fas fa-plus me-2"></i> {{ __('Ajouter un produit') }}
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card card-custom border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: var(--bg-soft);">
                        <tr>
                            <th class="ps-4 py-3 border-0">{{ __('Produit') }}</th>
                            <th class="py-3 border-0">{{ __('Catégorie') }}</th>
                            <th class="py-3 border-0">{{ __('Prix') }}</th>
                            <!-- <th class="py-3 border-0">{{ __('Ville') }}</th> -->
                            <th class="py-3 border-0">{{ __('Certifié') }}</th>
                            <th class="pe-4 py-3 border-0 text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset($product->image_url ?? 'images/default-product.jpg') }}" alt="" class="rounded-3" style="width: 48px; height: 48px; object-fit: cover;">
                                        <div>
                                            <div class="fw-bold" style="color: var(--text-main);">{{ __($product->name) }}</div>
                                            <div class="small opacity-50">{{ __(\Illuminate\Support\Str::limit($product->description, 40)) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-soft text-main border border-color">{{ __($product->category) }}</span></td>
                                <td class="fw-bold" style="color: var(--btn-bg);">{{ number_format($product->price, 2) }} {{ __('DH') }}</td>
                                <!-- <td><i class="fas fa-map-marker-alt me-1 opacity-50"></i> {{ __($product->city) }}</td> -->
                                <td>
                                    @if($product->is_certified)
                                        <span class="badge rounded-pill bg-success px-2 py-1"><i class="fas fa-certificate me-1"></i> {{ __('Oui') }}</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary px-2 py-1 opacity-50">{{ __('Non') }}</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="{{ __('Modifier') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce produit ?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="{{ __('Supprimer') }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 opacity-50">
                                    <i class="fas fa-box-open fs-1 mb-3 d-block"></i>
                                    {{ __('Aucun produit trouvé.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($products->hasPages())
                <div class="px-4 py-3 border-top border-color">
                    {{ $products->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
