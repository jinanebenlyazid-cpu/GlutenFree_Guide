@extends('main')

@section('title', __('Partager une recette - Guide Gluten-Free'))

@section('content')
<section class="section py-5" style="background: linear-gradient(135deg, var(--bg-soft) 0%, #fff 100%); min-height: calc(100vh - 100px); position: relative;">
    
    <!-- Decorative -->
    <div class="position-absolute top-0 end-0 opacity-10" style="transform: translate(20%, -20%);">
        <i class="fas fa-utensils text-success" style="font-size: 20rem;"></i>
    </div>

    <div class="container" style="position: relative; z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="card border-0 shadow-lg glass rounded-5 p-2 p-md-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-5">
                            <div class="bg-soft d-inline-flex align-items-center justify-content-center rounded-circle mb-3 shadow-inner" style="width: 80px; height: 80px;">
                                <i class="fas fa-mortar-pestle text-success fs-2"></i>
                            </div>
                            <h2 class="brand-font fw-bold text-main mb-2 fs-1">{{ __('Partager une recette') }} 🌿</h2>
                            <p class="opacity-75 text-main fs-5 mb-4">{{ __('Inspirez la communauté avec vos créations culinaires sans gluten.') }}</p>
                            
                            <div class="alert border-0 rounded-4 d-inline-flex align-items-center gap-2 px-4 py-3 shadow-sm bg-white" style="font-size: 0.9rem;">
                                <i class="fas fa-shield-alt text-success fs-5"></i>
                                <span class="text-main fw-bold">{{ __('Modération :') }}</span>
                                <span class="text-main opacity-75">{{ __('Votre recette sera validée par notre équipe avant sa publication.') }}</span>
                            </div>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger border-0 rounded-4 mb-4 shadow-sm p-4">
                                <h6 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i>{{ __('Oups ! Quelques erreurs à corriger :') }}</h6>
                                <ul class="mb-0 small ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('recipes.store') }}" class="needs-validation">
                            @csrf

                            <!-- Section: Infos de base -->
                            <div class="row g-4 mb-5">
                                <div class="col-md-12">
                                    <label for="name" class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Nom de la recette') }} *</label>
                                    <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                        <span class="input-group-text bg-transparent border-0 ps-3"><i class="fas fa-quote-left opacity-30 text-main"></i></span>
                                        <input type="text" id="name" name="name" class="form-control border-0 bg-transparent shadow-none py-2 px-3 text-main" value="{{ old('name') }}" placeholder="{{ __('Ex: Crêpes fondantes au sarrasin') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label for="image_url" class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('URL de l\'image') }}</label>
                                    <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                        <span class="input-group-text bg-transparent border-0 ps-3"><i class="fas fa-camera-retro opacity-30 text-main"></i></span>
                                        <input type="text" id="image_url" name="image_url" class="form-control border-0 bg-transparent shadow-none py-2 px-3 text-main" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="prep_time" class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Préparation (min)') }} *</label>
                                    <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                        <span class="input-group-text bg-transparent border-0 ps-3"><i class="fas fa-clock opacity-30 text-main"></i></span>
                                        <input type="number" id="prep_time" name="prep_time" class="form-control border-0 bg-transparent shadow-none py-2 px-3 text-main" value="{{ old('prep_time') }}" min="1" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="difficulty" class="form-label small fw-bold text-main opacity-75 ms-2">{{ __('Difficulté') }} *</label>
                                    <div class="input-group glass-input rounded-pill border border-color overflow-hidden p-1 shadow-xs transition-all">
                                        <span class="input-group-text bg-transparent border-0 ps-3"><i class="fas fa-layer-group opacity-30 text-main"></i></span>
                                        <select id="difficulty" name="difficulty" class="form-select border-0 bg-transparent shadow-none py-2 px-3 text-main" required>
                                            <option value="facile" {{ old('difficulty') == 'facile' ? 'selected' : '' }}>{{ __('Facile') }}</option>
                                            <option value="moyen" {{ old('difficulty') == 'moyen' ? 'selected' : '' }}>{{ __('Moyen') }}</option>
                                            <option value="difficile" {{ old('difficulty') == 'difficile' ? 'selected' : '' }}>{{ __('Difficile') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Ingrédients -->
                            <div class="mb-5 bg-white p-4 rounded-5 border border-color shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold brand-font text-main mb-0"><i class="fas fa-shopping-basket me-2 text-success"></i>{{ __('Ingrédients') }}</h5>
                                    <button type="button" class="btn btn-soft-primary rounded-pill btn-sm px-3 fw-bold" id="add-ingredient">
                                        <i class="fas fa-plus me-1"></i> {{ __('Ajouter') }}
                                    </button>
                                </div>
                                <div id="ingredients-container">
                                    <div class="input-group mb-3 ingredient-row shadow-xs rounded-pill overflow-hidden border border-color p-1">
                                        <span class="input-group-text bg-transparent border-0 ps-3"><i class="fas fa-check-circle text-success opacity-25"></i></span>
                                        <input type="text" class="form-control border-0 bg-transparent shadow-none" name="ingredients[]" placeholder="{{ __('Ex: 250g de farine sans gluten') }}" required>
                                        <button type="button" class="btn btn-link text-danger remove-row" style="display: none;"><i class="fas fa-times-circle"></i></button>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Étapes -->
                            <div class="mb-5 bg-white p-4 rounded-5 border border-color shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold brand-font text-main mb-0"><i class="fas fa-list-ol me-2 text-success"></i>{{ __('Étapes de préparation') }}</h5>
                                    <button type="button" class="btn btn-soft-primary rounded-pill btn-sm px-3 fw-bold" id="add-step">
                                        <i class="fas fa-plus me-1"></i> {{ __('Ajouter') }}
                                    </button>
                                </div>
                                <div id="steps-container">
                                    <div class="input-group mb-3 step-row shadow-xs rounded-4 overflow-hidden border border-color p-2">
                                        <span class="input-group-text bg-soft text-main fw-bold rounded-circle ms-2 mt-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border: none;">1</span>
                                        <textarea class="form-control border-0 bg-transparent shadow-none px-3" name="steps[]" rows="2" placeholder="{{ __('Décrivez cette étape avec précision...') }}" required style="resize: none;"></textarea>
                                        <button type="button" class="btn btn-link text-danger remove-row align-self-start mt-1" style="display: none;"><i class="fas fa-times-circle"></i></button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-main w-100 rounded-pill py-3 fw-bold shadow-md transform-hover mb-4 fs-5">
                                <i class="fas fa-paper-plane me-2"></i>{{ __('Soumettre ma recette') }}
                            </button>
                            
                            <div class="text-center">
                                <a href="{{ route('recipes.index') }}" class="text-decoration-none text-main opacity-50 hover-opacity-100 transition-all small fw-bold">
                                    <i class="fas fa-arrow-left me-1"></i> {{ __('Retour aux recettes') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .glass-input:focus-within { border-color: var(--btn-bg) !important; box-shadow: 0 0 15px rgba(107, 142, 35, 0.1) !important; background: rgba(255,255,255,0.9); }
    .btn-soft-primary { background: var(--bg-soft); color: var(--btn-bg); border: none; }
    .btn-soft-primary:hover { background: var(--btn-bg); color: #fff; }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .shadow-inner { box-shadow: inset 0 2px 4px rgba(0,0,0,0.05); }
    .transform-hover:hover { transform: translateY(-3px); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addIngBtn = document.getElementById('add-ingredient');
    const addStepBtn = document.getElementById('add-step');
    const ingContainer = document.getElementById('ingredients-container');
    const stepContainer = document.getElementById('steps-container');

    const updateBtns = () => {
        const rowsIng = ingContainer.querySelectorAll('.ingredient-row');
        rowsIng.forEach(r => r.querySelector('.remove-row').style.display = rowsIng.length > 1 ? '' : 'none');
        const rowsStep = stepContainer.querySelectorAll('.step-row');
        rowsStep.forEach((r, i) => {
            r.querySelector('.remove-row').style.display = rowsStep.length > 1 ? '' : 'none';
            r.querySelector('.input-group-text').textContent = i + 1;
        });
    };

    addIngBtn.addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = 'input-group mb-3 ingredient-row shadow-xs rounded-pill overflow-hidden border border-color p-1 animate__animated animate__fadeInUp';
        div.innerHTML = `<span class="input-group-text bg-transparent border-0 ps-3"><i class="fas fa-check-circle text-success opacity-25"></i></span>
                         <input type="text" class="form-control border-0 bg-transparent shadow-none" name="ingredients[]" placeholder="{{ __('Nouvel ingrédient...') }}" required>
                         <button type="button" class="btn btn-link text-danger remove-row"><i class="fas fa-times-circle"></i></button>`;
        ingContainer.appendChild(div);
        updateBtns();
    });

    addStepBtn.addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = 'input-group mb-3 step-row shadow-xs rounded-4 overflow-hidden border border-color p-2 animate__animated animate__fadeInUp';
        div.innerHTML = `<span class="input-group-text bg-soft text-main fw-bold rounded-circle ms-2 mt-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border: none;">?</span>
                         <textarea class="form-control border-0 bg-transparent shadow-none px-3" name="steps[]" rows="2" placeholder="{{ __('Décrivez l\'étape...') }}" required style="resize: none;"></textarea>
                         <button type="button" class="btn btn-link text-danger remove-row align-self-start mt-1"><i class="fas fa-times-circle"></i></button>`;
        stepContainer.appendChild(div);
        updateBtns();
    });

    document.addEventListener('click', e => {
        if(e.target.closest('.remove-row')) {
            e.target.closest('.input-group').classList.add('animate__animated', 'animate__fadeOut');
            setTimeout(() => { e.target.closest('.input-group').remove(); updateBtns(); }, 300);
        }
    });

    updateBtns();
});
</script>
@endsection
