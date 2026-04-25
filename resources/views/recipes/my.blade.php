@extends('main')

@section('title', __('Mes Recettes'))

@section('content')
<section class="section py-5" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container-fluid px-lg-5">
        <!-- Hero Header -->
        <div class="row mb-5 align-items-center" data-aos="fade-up">
            <div class="col-md-7 text-center text-md-start">
                <span class="badge bg-soft text-main px-3 py-2 rounded-pill mb-3 border border-color shadow-sm">
                    <i class="fas fa-user-circle me-2 text-success"></i>{{ __('Mon Espace') }}
                </span>
                <h1 class="brand-font fw-bold mb-2 display-5 text-main">{{ __('Mes Recettes Partagées') }} 🥘</h1>
                <p class="opacity-75 mb-0 fs-5 text-main">{{ __('Retrouvez ici toutes les recettes que vous avez proposées à la communauté.') }}</p>
            </div>
            <div class="col-md-5 text-md-end mt-4 mt-md-0">
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-md-end align-items-center">
                    <form action="{{ route('recipes.my') }}" method="GET" class="flex-grow-1 w-100">
                        <div class="input-group shadow-sm rounded-pill overflow-hidden border border-color glass p-1">
                            <span class="input-group-text bg-transparent border-0"><i class="fas fa-search opacity-50 text-main"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 bg-transparent shadow-none text-main" placeholder="{{ __('Chercher dans mes recettes...') }}">
                            <button type="submit" class="btn btn-main rounded-pill px-4 fw-bold small">{{ __('Chercher') }}</button>
                        </div>
                    </form>
                    <a href="{{ route('recipes.create') }}" class="btn btn-main rounded-pill px-4 py-2 shadow-md fw-bold animate-pulse text-nowrap">
                        <i class="fas fa-plus me-2"></i> {{ __('Partager') }}
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="row mb-5" data-aos="fade-up">
                <div class="col-12">
                    <div class="alert alert-success border-0 rounded-4 shadow-sm p-4 animate__animated animate__fadeInDown" style="background: rgba(25, 135, 84, 0.1); color: #198754;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ __('Succès !') }}</h6>
                                <p class="mb-0 small opacity-75">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($recipes->count() > 0)
            <div class="row g-4" data-aos="fade-up" data-aos-delay="200">
                @foreach($recipes as $recipe)
                    <div class="col-md-6 col-lg-4 col-xl-3 d-flex align-items-stretch">
                        <div class="card card-custom border-0 shadow-sm w-100 overflow-hidden recipe-card" style="border-radius: 20px;">
                            <div class="position-relative">
                                <img src="{{ asset($recipe->image_url ?? 'images/default-recipe.jpg') }}" class="card-img-top" alt="{{ $recipe->name }}" style="height: 240px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 p-3">
                                    @if($recipe->isApproved())
                                        <span class="badge bg-success rounded-pill shadow-sm"><i class="fas fa-check-circle me-1"></i>{{ __('Approuvée') }}</span>
                                    @elseif($recipe->isPending())
                                        <span class="badge bg-warning text-dark rounded-pill shadow-sm"><i class="fas fa-clock me-1"></i>{{ __('En attente') }}</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill shadow-sm"><i class="fas fa-times-circle me-1"></i>{{ __('Refusée') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold mb-0 text-main" style="font-family: 'Playfair Display', serif;">{{ $recipe->name }}</h5>
                                </div>
                                <p class="card-text text-main opacity-75 small mb-4 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($recipe->description), 80) }}</p>
                                
                                <div class="mt-auto">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <button class="btn btn-main w-100 rounded-pill btn-sm fw-bold py-2" data-bs-toggle="modal" data-bs-target="#recipeModal{{ $recipe->id }}">
                                                {{ __('Gérer') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-5 d-flex justify-content-center">
                {{ $recipes->links() }}
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <div class="bg-card-bg d-inline-block p-5 rounded-circle shadow-sm mb-4">
                    <i class="fas fa-book-open fa-4x text-main opacity-25"></i>
                </div>
                <h3 class="fw-bold">{{ __('Vous n\'avez pas encore partagé de recette.') }}</h3>
                <p class="text-main opacity-75 mb-4">{{ __('Commencez à partager votre savoir-faire culinaire avec la communauté !') }}</p>
                <a href="{{ route('recipes.create') }}" class="btn btn-main rounded-pill px-5 py-3 shadow-md fw-bold">
                    <i class="fas fa-plus me-2"></i> {{ __('Partager ma première recette') }}
                </a>
            </div>
        @endif
    </div>

@if($recipes->count() > 0)
    @foreach($recipes as $recipe)
        <div class="modal fade" id="recipeModal{{ $recipe->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden card-custom">
                    <div class="modal-header border-0 pb-0 pt-4 px-4 position-absolute top-0 end-0 z-3">
                        <button type="button" class="btn-close shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; border-radius: 50%; padding: 0.8rem;"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <div class="col-lg-5 d-none d-lg-block" style="background: url('{{ asset($recipe->image_url ?? 'images/default-recipe.jpg') }}') center/cover; min-height: 450px;"></div>
                            <div class="col-lg-7 p-4 pt-5">
                                <h3 class="brand-font fw-bold text-main mb-3">{{ $recipe->name }}</h3>
                                <div class="d-flex gap-3 mb-4">
                                    <span class="badge bg-soft text-main px-3 py-2 rounded-pill border border-color small">
                                        <i class="fas fa-clock me-2 text-success"></i>{{ $recipe->prep_time }} {{ __('min') }}
                                    </span>
                                    <span class="badge bg-soft text-main px-3 py-2 rounded-pill border border-color small">
                                        <i class="fas fa-signal me-2 text-success"></i>{{ __(ucfirst($recipe->difficulty)) }}
                                    </span>
                                </div>
                                
                                <h6 class="fw-bold text-main mb-2"><i class="fas fa-list-ul me-2 text-success"></i>{{ __('Ingrédients') }}</h6>
                                <div class="text-main opacity-75 small mb-4">
                                    @if(is_array($recipe->ingredients))
                                        <ul class="list-unstyled mb-0">
                                            @foreach($recipe->ingredients as $ing)
                                                <li><i class="fas fa-check me-2 text-success small"></i>{{ $ing }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ $recipe->ingredients }}
                                    @endif
                                </div>

                                <h6 class="fw-bold text-main mb-2"><i class="fas fa-utensils me-2 text-success"></i>{{ __('Préparation') }}</h6>
                                <div class="text-main opacity-75 small mb-0">
                                    @if(is_array($recipe->steps))
                                        <ol class="ps-3 mb-0">
                                            @foreach($recipe->steps as $step)
                                                <li class="mb-2">{{ $step }}</li>
                                            @endforeach
                                        </ol>
                                    @else
                                        {{ $recipe->steps }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

</section>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .recipe-card:hover img {
        transform: scale(1.1);
    }
</style>
@endsection
