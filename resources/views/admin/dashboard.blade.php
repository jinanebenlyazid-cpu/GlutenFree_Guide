@extends('main')

@section('title', __('Administration - Guide Gluten-Free'))

@section('content')
<section class="section py-4" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container-fluid px-lg-5">
        
        <!-- Header -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h1 class="brand-font fw-bold mb-2"><i class="fas fa-shield-alt me-2" style="color: var(--btn-bg);"></i>{{ __('Panel Administrateur') }}</h1>
                <p class="opacity-75 mb-0" style="color: var(--text-main);">{{ __('Gérez les recettes, produits et lieux du site.') }}</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-flex gap-2 justify-content-md-end">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary rounded-pill px-4 btn-sm fw-bold">
                        <i class="fas fa-tasks me-2"></i> {{ __('Gérer les Produits') }}
                    </a>
                    <a href="{{ route('admin.recipes.index') }}" class="btn btn-outline-primary rounded-pill px-4 btn-sm fw-bold">
                        <i class="fas fa-tasks me-2"></i> {{ __('Gérer les Recettes') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-5">
            <div class="col-md-3">
                <a href="{{ route('admin.recipes.index', ['status' => 'pending']) }}" class="text-decoration-none">
                    <div class="card card-custom border-0 shadow-sm p-4 hover-lift">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background-color: rgba(255, 193, 7, 0.15); color: #ffc107;">
                                <i class="fas fa-utensils fs-5"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold" style="color: var(--text-main);">{{ $pendingRecipes->count() }}</div>
                                <div class="small opacity-75 text-main">{{ __('Recettes en attente') }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <div class="card card-custom border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background-color: rgba(63, 81, 181, 0.15); color: #3f51b5;">
                            <i class="fas fa-map-marker-alt fs-5"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold" style="color: var(--text-main);">{{ $pendingLocations->count() }}</div>
                            <div class="small opacity-75">{{ __('Lieux en attente') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background-color: rgba(40, 167, 69, 0.15); color: #28a745;">
                            <i class="fas fa-box fs-5"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold" style="color: var(--text-main);">{{ $productsCount }}</div>
                            <div class="small opacity-75">{{ __('Total Produits') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.recipes.index', ['status' => 'refused']) }}" class="text-decoration-none">
                    <div class="card card-custom border-0 shadow-sm p-4 hover-lift">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background-color: rgba(220, 53, 69, 0.15); color: #dc3545;">
                                <i class="fas fa-times-circle fs-5"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold" style="color: var(--text-main);">{{ $refusedRecipesCount }}</div>
                                <div class="small opacity-75 text-main">{{ __('Recettes Refusées') }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4 d-flex align-items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="row g-5">
            <!-- Pending Recipes Section -->
            <div class="col-xl-6">
                <h4 class="fw-bold mb-4" style="color: var(--text-main);"><i class="fas fa-utensils me-2 text-warning"></i>{{ __('Recettes en attente') }}</h4>
                
                @if($pendingRecipes->count() > 0)
                    <div class="row g-3">
                        @foreach($pendingRecipes as $recipe)
                            <div class="col-12">
                                <div class="card card-custom border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
                                    <div class="row g-0">
                                        <div class="col-4" style="background: url('{{ asset($recipe->image_url ?? 'images/default-recipe.jpg') }}') center/cover;"></div>
                                        <div class="col-8">
                                            <div class="card-body p-3">
                                                <h6 class="fw-bold mb-1" style="color: var(--text-main);">{{ __($recipe->name) }}</h6>
                                                <p class="small opacity-75 mb-2">{{ __('Par') }} <strong>{{ $recipe->user->name ?? 'User' }}</strong> • {{ $recipe->created_at->diffForHumans() }}</p>
                                                
                                                <div class="d-flex gap-2">
                                                    <form method="POST" action="{{ route('admin.recipes.approve', $recipe->id) }}" class="flex-grow-1">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success w-100 rounded-pill">
                                                            {{ __('Approuver') }}
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('admin.recipes.refuse', $recipe->id) }}" class="flex-grow-1">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-danger w-100 rounded-pill">
                                                            {{ __('Refuser') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card border-0 shadow-sm p-4 text-center opacity-75" style="background-color: transparent; border: 2px dashed var(--border-color) !important;">
                        {{ __('Aucune recette en attente') }}
                    </div>
                @endif
            </div>

            <!-- Pending Locations Section -->
            <div class="col-xl-6">
                <h4 class="fw-bold mb-4" style="color: var(--text-main);"><i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ __('Lieux en attente') }}</h4>
                
                @if($pendingLocations->count() > 0)
                    <div class="row g-3">
                        @foreach($pendingLocations as $location)
                            <div class="col-12">
                                <div class="card card-custom border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="fw-bold mb-0" style="color: var(--text-main);">{{ __($location->name) }}</h6>
                                            <span class="badge bg-soft text-main px-2 py-1 border border-color small">{{ __($location->type) }}</span>
                                        </div>
                                        <p class="small opacity-75 mb-1"><i class="fas fa-map-marker-alt me-1"></i> {{ $location->address }}, {{ $location->city }}</p>
                                        <p class="small opacity-75 mb-3">{{ __('Par') }} <strong>{{ $location->user->name ?? 'User' }}</strong> • {{ $location->created_at->diffForHumans() }}</p>
                                        
                                        <div class="d-flex gap-2">
                                            <form method="POST" action="{{ route('admin.locations.approve', $location->id) }}" class="flex-grow-1">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success w-100 rounded-pill">
                                                    {{ __('Approuver') }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.locations.refuse', $location->id) }}" class="flex-grow-1">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-danger w-100 rounded-pill">
                                                    {{ __('Refuser') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card border-0 shadow-sm p-4 text-center opacity-75" style="background-color: transparent; border: 2px dashed var(--border-color) !important;">
                        {{ __('Aucun lieu en attente') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
