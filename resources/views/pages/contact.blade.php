@extends('main')

@section('title', __('Contactez-Nous - Guide Gluten-Free'))

@section('content')
<section class="section pt-5 mt-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <span class="badge bg-soft text-main px-3 py-2 rounded-pill mb-3 border border-color">✨ {{ __('On vous répond') }}</span>
                <h1 class="display-4 fw-bold mb-4 brand-font lh-1">{{ __('Une question, un avis ou un partenariat ?') }}</h1>
                <p class="lead opacity-75 mb-5 pe-lg-5">
                    {{ __('Nous sommes là pour vous écouter. Que vous soyez un particulier, un professionnel de santé ou un restaurateur, votre message nous intéresse.') }}
                </p>

                <div class="d-flex flex-column gap-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-sm bg-soft text-main rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: var(--bg-soft); color: var(--btn-bg);">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ __('Email') }}</h6>
                            <p class="mb-0 opacity-75 small">guide-gluten-free@gmail.com</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-sm bg-soft text-main rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: var(--bg-soft); color: var(--btn-bg);">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ __('Téléphone') }}</h6>
                            <p class="mb-0 opacity-75 small">+212 5 22 00 00 00</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-sm bg-soft text-main rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: var(--bg-soft); color: var(--btn-bg);">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ __('Adresse') }}</h6>
                            <p class="mb-0 opacity-75 small">{{ __('Tanger, Maroc') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 d-flex gap-3">
                    <a href="#" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 shadow-sm p-4 mb-4 animate__animated animate__fadeInDown" style="background: rgba(25, 135, 84, 0.1); color: #198754;">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-check-circle fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-0">{{ session('success') }}</h6>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card card-custom p-4 p-md-5 border-0 shadow-2xl glass">
                    <h3 class="brand-font fw-bold mb-4">{{ __('Envoyez un message') }}</h3>
                    <form action="{{ route('pages.contact.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold opacity-75">{{ __('Nom complet') }}</label>
                                <input type="text" name="name" class="form-control rounded-pill px-3 py-2 border-color focus-ring" placeholder="{{ __('Votre nom') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold opacity-75">{{ __('Email') }}</label>
                                <input type="email" name="email" class="form-control rounded-pill px-3 py-2 border-color focus-ring" placeholder="email@exemple.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold opacity-75">{{ __('Sujet') }}</label>
                                <select name="subject" class="form-select rounded-pill px-3 py-2 border-color focus-ring cursor-pointer">
                                    <option value="general">{{ __('Question générale') }}</option>
                                    <option value="technical">{{ __('Problème technique') }}</option>
                                    <option value="suggestion">{{ __('Suggestion de restaurant') }}</option>
                                    <option value="partnership">{{ __('Partenariat') }}</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold opacity-75">{{ __('Message') }}</label>
                                <textarea name="message" class="form-control rounded-4 px-3 py-3 border-color focus-ring" rows="4" placeholder="{{ __('Comment pouvons-nous vous aider ?') }}" required></textarea>
                            </div>
                            <div class="col-12 mt-4 text-center text-md-start">
                                <button type="submit" class="btn btn-main px-5 py-3 shadow-md">{{ __('Envoyer mon message') }} <i class="fas fa-paper-plane ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    .focus-ring:focus { outline: none; border-color: var(--btn-bg); box-shadow: 0 0 0 4px rgba(45, 90, 39, 0.1); }
</style>
@endsection
