@extends('main')

@section('title', __('Gestion des Recettes - Admin'))

@section('content')
<section class="section py-4" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container-fluid px-lg-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none" style="color: var(--btn-bg);">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Recettes') }}</li>
                    </ol>
                </nav>
                <h1 class="brand-font fw-bold mb-0">{{ __('Gestion des Recettes') }} 👩‍🍳</h1>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Status Tabs -->
        <ul class="nav nav-pills mb-4 gap-2" id="statusTabs">
            <li class="nav-item">
                <a class="nav-link {{ $status == 'all' ? 'active' : '' }} rounded-pill px-4 glass border border-color fw-bold text-main" href="{{ route('admin.recipes.index') }}">
                    {{ __('Tous') }} <span class="badge bg-soft text-main ms-1">{{ $counts['total'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status == 'pending' ? 'active' : '' }} rounded-pill px-4 glass border border-color fw-bold text-main" href="{{ route('admin.recipes.index', ['status' => 'pending']) }}">
                    {{ __('En attente') }} <span class="badge bg-warning text-dark ms-1">{{ $counts['pending'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status == 'approved' ? 'active' : '' }} rounded-pill px-4 glass border border-color fw-bold text-main" href="{{ route('admin.recipes.index', ['status' => 'approved']) }}">
                    {{ __('Approuvées') }} <span class="badge bg-success text-white ms-1">{{ $counts['approved'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status == 'refused' ? 'active' : '' }} rounded-pill px-4 glass border border-color fw-bold text-main" href="{{ route('admin.recipes.index', ['status' => 'refused']) }}">
                    {{ __('Refusées') }} <span class="badge bg-danger text-white ms-1">{{ $counts['refused'] }}</span>
                </a>
            </li>
        </ul>

        <div class="card card-custom border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: var(--bg-soft);">
                        <tr>
                            <th class="ps-4 py-3 border-0">{{ __('Recette') }}</th>
                            <th class="py-3 border-0">{{ __('Auteur') }}</th>
                            <th class="py-3 border-0">{{ __('Temps') }}</th>
                            <th class="py-3 border-0">{{ __('Difficulté') }}</th>
                            <th class="py-3 border-0">{{ __('Status') }}</th>
                            <th class="py-3 border-0">{{ __('Date') }}</th>
                            <th class="pe-4 py-3 border-0 text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recipes as $recipe)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset($recipe->image_url ?? 'images/default-recipe.jpg') }}" alt="" class="rounded-3" style="width: 48px; height: 48px; object-fit: cover;">
                                        <div class="fw-bold" style="color: var(--text-main);">{{ __($recipe->name) }}</div>
                                    </div>
                                </td>
                                <td>{{ $recipe->user->name ?? __('Utilisateur anonyme') }}</td>
                                <td><i class="fas fa-clock me-1 opacity-50"></i> {{ $recipe->prep_time }} {{ __('min') }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $recipe->difficulty == 'difficile' ? 'bg-soft-danger text-danger' : ($recipe->difficulty == 'moyen' ? 'bg-soft-warning text-warning' : 'bg-soft-success text-success') }} px-2 py-1 border">
                                        {{ __(ucfirst($recipe->difficulty)) }}
                                    </span>
                                </td>
                                <td>
                                    @if($recipe->isApproved())
                                        <span class="badge rounded-pill bg-success px-2 py-1">{{ __('Approuvée') }}</span>
                                    @elseif($recipe->isPending())
                                        <span class="badge rounded-pill bg-warning text-dark px-2 py-1">{{ __('En attente') }}</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger px-2 py-1">{{ __('Refusée') }}</span>
                                    @endif
                                </td>
                                <td class="small opacity-75">{{ $recipe->created_at->format('d/m/Y') }}</td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        @if($recipe->isApproved())
                                            <form action="{{ route('admin.recipes.refuse', $recipe->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-warning rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="{{ __('Refuser') }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if($recipe->isRefused() || $recipe->isPending())
                                            <form action="{{ route('admin.recipes.approve', $recipe->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="{{ __('Approuver') }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.recipes.edit', $recipe->id) }}" class="btn btn-sm btn-outline-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="{{ __('Modifier') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('{{ __('Supprimer définitivement cette recette ?') }}')">
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
                                <td colspan="7" class="text-center py-5 opacity-50">
                                    <i class="fas fa-utensils fs-1 mb-3 d-block"></i>
                                    {{ __('Aucune recette trouvée.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($recipes->hasPages())
                <div class="px-4 py-3 border-top border-color">
                    {{ $recipes->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .nav-pills .nav-link { 
        background: transparent; 
        transition: 0.3s;
        opacity: 0.8;
    }
    .nav-pills .nav-link:hover {
        background: var(--bg-soft);
        opacity: 1;
    }
    .nav-pills .nav-link.active { 
        background-color: var(--btn-bg) !important; 
        color: white !important; 
        border-color: var(--btn-bg) !important;
        opacity: 1;
        box-shadow: 0 4px 12px rgba(107, 142, 35, 0.2);
    }
    .nav-pills .nav-link.active .badge {
        background-color: rgba(255,255,255,0.2) !important;
        color: white !important;
    }
    .bg-soft-success { background-color: rgba(40, 167, 69, 0.1); }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
</style>
@endsection
