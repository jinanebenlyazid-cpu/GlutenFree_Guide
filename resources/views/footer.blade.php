<footer class="bg-soft py-5 mt-5 border-top border-color">
    <div class="container">
        <div class="row g-4 mb-5">
            <!-- Branding -->
            <div class="col-lg-4">
                <h4 class="brand-font fw-bold mb-3">🌿 {{ __('Guide Gluten-Free') }}</h4>
                <p class="opacity-75 mb-4" style="max-width: 300px;">
                    {{ __('Votre référence pour une vie sans gluten au Maroc. Trouvez, partagez et savourez en toute sécurité.') }}
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-6 col-lg-2 offset-lg-1">
                <h6 class="fw-bold mb-3 text-uppercase small" style="letter-spacing: 1px;">{{ __('Découvrir') }}</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('products.index') }}" class="text-decoration-none text-main opacity-75 hover-opacity-100">{{ __('Tous les produits') }}</a></li>
                    <li class="mb-2"><a href="{{ route('locations.index') }}" class="text-decoration-none text-main opacity-75 hover-opacity-100">{{ __('Carte interactive') }}</a></li>
                    <li class="mb-2"><a href="{{ route('recipes.index') }}" class="text-decoration-none text-main opacity-75 hover-opacity-100">{{ __('Recettes partagées') }}</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="col-6 col-lg-2">
                <h6 class="fw-bold mb-3 text-uppercase small" style="letter-spacing: 1px;">{{ __('Communauté') }}</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('register') }}" class="text-decoration-none text-main opacity-75 hover-opacity-100">{{ __('Nous rejoindre') }}</a></li>
                    <li class="mb-2"><a href="{{ route('pages.about') }}" class="text-decoration-none text-main opacity-75 hover-opacity-100">{{ __('À propos') }}</a></li>
                    <li class="mb-2"><a href="{{ route('pages.contact') }}" class="text-decoration-none text-main opacity-75 hover-opacity-100">{{ __('Contact') }}</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3">
                <h6 class="fw-bold mb-3 text-uppercase small" style="letter-spacing: 1px;">{{ __('Newsletter') }}</h6>
                <p class="small opacity-75 mb-3">{{ __('Recevez nos meilleures recettes et adresses.') }}</p>
                <div class="input-group mb-3 glass rounded-pill p-1">
                    <input type="email" class="form-control border-0 bg-transparent ps-3" placeholder="{{ __('Email...') }}">
                    <button class="btn btn-main px-3" type="button"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>

        <hr class="border-color opacity-50 mb-4">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="small opacity-50 mb-0">© 2026 {{ __('Guide Gluten-Free Morocco') }}. {{ __('Tous droits réservés.') }}</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <div class="d-flex gap-4 justify-content-center justify-content-md-end">
                    <a href="#" class="text-decoration-none small opacity-50 text-main">{{ __('Mentions légales') }}</a>
                    <a href="#" class="text-decoration-none small opacity-50 text-main">{{ __('Confidentialité') }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .hover-opacity-100:hover { opacity: 1 !important; color: var(--btn-bg) !important; }
    footer .input-group input:focus { box-shadow: none; }
</style>