@extends('main')

@section('title', __('Profil Utilisateur - Guide Gluten-Free'))

@section('content')
<section class="section py-4" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container-fluid px-lg-5">
        
        <!-- Breadcrumbs -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none" style="color: var(--btn-bg);">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none" style="color: var(--btn-bg);">{{ __('Utilisateurs') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: var(--text-main);">{{ $user->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4 d-flex align-items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4 d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="row g-4">
            <!-- User Profile Sidebar -->
            <div class="col-xl-4">
                <div class="card card-custom border-0 shadow-sm text-center p-4">
                    <div class="rounded-circle d-flex justify-content-center align-items-center fw-bold shadow-sm mx-auto mb-3" style="width: 100px; height: 100px; background-color: var(--bg-soft);">
                        <img src="{{ $user->profile_photo_url }}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $user->name }}">
                    </div>
                    <h3 class="fw-bold mb-1" style="color: var(--text-main);">{{ $user->name }}</h3>
                    <p class="opacity-75 mb-3">{{ $user->email }}</p>

                    <div class="d-flex justify-content-center gap-2 mb-4">
                        @if($user->isAdmin())
                            <span class="badge bg-primary px-3 py-2 rounded-pill"><i class="fas fa-shield-alt me-1"></i> Admin</span>
                        @endif
                        @if($user->is_blocked)
                            <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="fas fa-lock me-1"></i> {{ __('Bloqué') }}</span>
                        @else
                            <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fas fa-check-circle me-1"></i> {{ __('Actif') }}</span>
                        @endif
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fas fa-star me-1"></i> {{ $user->points }} Pts</span>
                    </div>

                    <ul class="list-group list-group-flush text-start mb-4">
                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 border-color">
                            <span class="opacity-75"><i class="fas fa-calendar-alt me-2"></i> {{ __('Inscrit le') }}</span>
                            <span class="fw-bold">{{ $user->created_at->format('d/m/Y') }}</span>
                        </li>
                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 border-color">
                            <span class="opacity-75"><i class="fas fa-utensils me-2"></i> {{ __('Recettes') }}</span>
                            <span class="fw-bold">{{ $user->recipes_count }}</span>
                        </li>
                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 border-color">
                            <span class="opacity-75"><i class="fas fa-map-marker-alt me-2"></i> {{ __('Lieux') }}</span>
                            <span class="fw-bold">{{ $user->locations_count }}</span>
                        </li>
                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 border-color">
                            <span class="opacity-75"><i class="fas fa-comment me-2"></i> {{ __('Commentaires') }}</span>
                            <span class="fw-bold">{{ $user->comments_count }}</span>
                        </li>
                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 border-color">
                            <span class="opacity-75"><i class="fas fa-heart me-2"></i> {{ __('Favoris') }}</span>
                            <span class="fw-bold">{{ $user->favorites_count }}</span>
                        </li>
                    </ul>

                    @if(auth()->id() !== $user->id)
                        <form action="{{ route('admin.users.toggle-block', $user->id) }}" method="POST" onsubmit="return confirm('{{ $user->is_blocked ? __('Voulez-vous débloquer cet utilisateur ?') : __('Voulez-vous bloquer cet utilisateur ?') }}');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn w-100 rounded-pill fw-bold py-2 {{ $user->is_blocked ? 'btn-success' : 'btn-danger' }}">
                                <i class="fas {{ $user->is_blocked ? 'fa-unlock' : 'fa-lock' }} me-2"></i>
                                {{ $user->is_blocked ? __('Débloquer l\'utilisateur') : __('Bloquer l\'utilisateur') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- User Activity -->
            <div class="col-xl-8">
                <div class="card card-custom border-0 shadow-sm p-4 h-100">
                    <h4 class="fw-bold mb-4" style="color: var(--text-main);"><i class="fas fa-history me-2" style="color: var(--btn-bg);"></i>{{ __('Dernières recettes proposées') }}</h4>
                    
                    @if($user->recipes->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($user->recipes as $recipe)
                                <div class="list-group-item bg-transparent px-0 py-3 border-color d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3" style="width: 60px; height: 60px; background: url('{{ asset($recipe->image_url ?? 'images/default-recipe.jpg') }}') center/cover;"></div>
                                        <div>
                                            <h6 class="mb-1 fw-bold" style="color: var(--text-main);">{{ $recipe->name }}</h6>
                                            <div class="small opacity-75">
                                                <span class="me-3"><i class="far fa-clock me-1"></i> {{ $recipe->created_at->diffForHumans() }}</span>
                                                @if($recipe->status === 'approved')
                                                    <span class="text-success"><i class="fas fa-check-circle me-1"></i> Approuvée</span>
                                                @elseif($recipe->status === 'pending')
                                                    <span class="text-warning"><i class="fas fa-hourglass-half me-1"></i> En attente</span>
                                                @else
                                                    <span class="text-danger"><i class="fas fa-times-circle me-1"></i> Refusée</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill" target="_blank">
                                        {{ __('Voir') }} <i class="fas fa-external-link-alt ms-1 small"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 opacity-50">
                            <i class="fas fa-utensils fs-1 mb-3"></i>
                            <p class="mb-0">{{ __('Cet utilisateur n\'a pas encore proposé de recette.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .border-color {
        border-color: var(--border-color) !important;
    }
</style>
@endsection
