@extends('main')

@section('title', __('Gestion des Utilisateurs - Guide Gluten-Free'))

@section('content')
<section class="section py-4" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container-fluid px-lg-5">
        
        <!-- Breadcrumbs & Header -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none" style="color: var(--btn-bg);">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: var(--text-main);">{{ __('Utilisateurs') }}</li>
                    </ol>
                </nav>
                <h2 class="brand-font fw-bold mb-0" style="color: var(--text-main);"><i class="fas fa-users me-2" style="color: var(--btn-bg);"></i>{{ __('Gestion des Utilisateurs') }}</h2>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex justify-content-md-end">
                    <div class="input-group" style="max-width: 350px;">
                        <input type="text" name="search" class="form-control border-0 shadow-sm" placeholder="{{ __('Rechercher par nom ou email...') }}" value="{{ request('search') }}" style="background-color: var(--card-bg); color: var(--text-main); border-radius: 20px 0 0 20px;">
                        <button type="submit" class="btn btn-main" style="border-radius: 0 20px 20px 0;"><i class="fas fa-search"></i></button>
                    </div>
                </form>
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

        <div class="card card-custom border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="color: var(--text-main);">
                    <thead style="background-color: var(--bg-soft);">
                        <tr>
                            <th class="border-0 py-3 ps-4" style="color: var(--text-main);">{{ __('Utilisateur') }}</th>
                            <th class="border-0 py-3" style="color: var(--text-main);">{{ __('Email') }}</th>
                            <th class="border-0 py-3 text-center" style="color: var(--text-main);">{{ __('Points') }}</th>
                            <th class="border-0 py-3" style="color: var(--text-main);">{{ __('Statut') }}</th>
                            <th class="border-0 py-3 text-end pe-4" style="color: var(--text-main);">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="border-bottom" style="border-color: var(--border-color) !important;">
                                <td class="py-3 ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex justify-content-center align-items-center fw-bold text-white shadow-sm" style="width: 40px; height: 40px; background-color: var(--btn-bg);">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                                            @if($user->isAdmin())
                                                <span class="badge bg-primary rounded-pill" style="font-size: 0.7rem;">Administrateur</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">{{ $user->email }}</td>
                                <td class="py-3 text-center">
                                    <span class="badge rounded-pill bg-warning text-dark"><i class="fas fa-star me-1"></i> {{ $user->points }}</span>
                                </td>
                                <td class="py-3">
                                    @if($user->is_blocked)
                                        <span class="badge bg-danger rounded-pill"><i class="fas fa-lock me-1"></i> {{ __('Bloqué') }}</span>
                                    @else
                                        <span class="badge bg-success rounded-pill"><i class="fas fa-check-circle me-1"></i> {{ __('Actif') }}</span>
                                    @endif
                                </td>
                                <td class="py-3 text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-info rounded-pill" title="{{ __('Voir les détails') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.toggle-block', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $user->is_blocked ? __('Voulez-vous débloquer cet utilisateur ?') : __('Voulez-vous bloquer cet utilisateur ?') }}');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $user->is_blocked ? 'btn-success' : 'btn-outline-danger' }} rounded-pill" title="{{ $user->is_blocked ? __('Débloquer') : __('Bloquer') }}">
                                                    <i class="fas {{ $user->is_blocked ? 'fa-unlock' : 'fa-lock' }}"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 opacity-50">
                                    <i class="fas fa-users fs-1 mb-3"></i>
                                    <p class="mb-0">{{ __('Aucun utilisateur trouvé.') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="card-footer bg-transparent border-top p-4 d-flex justify-content-center" style="border-color: var(--border-color) !important;">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
