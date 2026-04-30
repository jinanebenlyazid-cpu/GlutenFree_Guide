@extends('main')

@section('title', __('Mon Profil - Guide Gluten-Free'))

@section('content')
<section class="section py-5" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container">
        <!-- Hero Header -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-12 text-center">
                <span class="badge bg-soft text-main px-3 py-2 rounded-pill mb-3 border border-color shadow-sm">
                    <i class="fas fa-user text-success me-2"></i>{{ __('Mon Espace') }}
                </span>
                <h1 class="brand-font fw-bold mb-2 display-5 text-main">{{ __('Mon Profil') }}</h1>
                <p class="opacity-75 mb-0 fs-5 text-main">{{ __('Gérez vos informations personnelles et votre avatar.') }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="row mb-4" data-aos="fade-up">
                <div class="col-md-8 mx-auto">
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

        @if ($errors->any())
            <div class="row mb-4" data-aos="fade-up">
                <div class="col-md-8 mx-auto">
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm p-4" style="background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4 justify-content-center">
            <!-- Profile Card -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card card-custom border-0 shadow-sm text-center p-4 h-100">
                    <div class="position-relative d-inline-block mx-auto mb-3">
                        <img src="{{ $user->profile_photo_url }}" class="rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid var(--btn-bg);" alt="{{ $user->name }}">
                    </div>
                    <h3 class="fw-bold mb-1 brand-font" style="color: var(--text-main);">{{ $user->name }}</h3>
                    <p class="opacity-75 mb-4">{{ $user->email }}</p>

                    <div class="d-flex justify-content-center gap-2 mb-4">
                        @if($user->isAdmin())
                            <span class="badge bg-primary px-3 py-2 rounded-pill"><i class="fas fa-shield-alt me-1"></i> Admin</span>
                        @endif
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fas fa-star me-1"></i> {{ $user->points ?? 0 }} Pts</span>
                    </div>

                    <ul class="list-group list-group-flush text-start">
                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 border-color">
                            <span class="opacity-75"><i class="fas fa-calendar-alt me-2 text-success"></i> {{ __('Inscrit le') }}</span>
                            <span class="fw-bold text-main">{{ $user->created_at->format('d/m/Y') }}</span>
                        </li>
                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 border-color">
                            <span class="opacity-75"><i class="fas fa-utensils me-2 text-success"></i> {{ __('Recettes') }}</span>
                            <span class="fw-bold text-main">{{ $user->recipes()->count() }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Edit Profile Form -->
            <div class="col-md-8" data-aos="fade-up" data-aos-delay="200">
                <div class="card card-custom border-0 shadow-sm p-4 h-100">
                    <h4 class="fw-bold mb-4 brand-font text-main"><i class="fas fa-edit me-2" style="color: var(--btn-bg);"></i>{{ __('Modifier mes informations') }}</h4>
                    
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-main">{{ __('Photo de profil / Bitmoji') }}</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="file-upload-wrapper w-100">
                                    <input type="file" name="profile_photo" id="profile_photo" class="form-control rounded-pill bg-soft border-0" accept="image/*">
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">{{ __('Formats acceptés : JPG, PNG, GIF. Taille max : 2Mo.') }}</small>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold small text-main">{{ __('Nom') }}</label>
                            <input type="text" class="form-control form-control-lg rounded-pill bg-soft border-0" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-5">
                            <label for="email" class="form-label fw-bold small text-main">{{ __('Adresse Email') }}</label>
                            <input type="email" class="form-control form-control-lg rounded-pill bg-soft border-0" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('home') }}" class="btn btn-light rounded-pill px-4 fw-bold">{{ __('Annuler') }}</a>
                            <button type="submit" class="btn btn-main rounded-pill px-5 fw-bold"><i class="fas fa-save me-2"></i>{{ __('Enregistrer') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .border-color {
        border-color: var(--border-color) !important;
    }
    input[type="file"]::file-selector-button {
        background-color: var(--btn-bg);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 50px;
        margin-right: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    input[type="file"]::file-selector-button:hover {
        background-color: var(--btn-hover);
    }
</style>
@endsection
