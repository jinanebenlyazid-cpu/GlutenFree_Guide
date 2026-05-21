@extends('main')

@section('title', __('Modifier la Recette - Admin'))

@section('content')
<section class="section py-5" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card card-custom border-0 shadow-lg p-5">
                    <div class="mb-4">
                        <a href="{{ route('admin.recipes.index') }}" class="text-decoration-none small" style="color: var(--btn-bg);">
                            <i class="fas fa-arrow-left me-1"></i> {{ __('Retour à la liste') }}
                        </a>
                        <h2 class="brand-font fw-bold mt-2 mb-1">{{ __('Modifier la Recette') }} 👩‍🍳</h2>
                        <p class="opacity-75">{{ __('Mise à jour d\'une recette soumise par la communauté.') }}</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 mb-4 small">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.recipes.update', $recipe->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="row g-4">
                            <!-- Basic Info -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">{{ __('Nom de la recette') }} *</label>
                                <input type="text" class="form-control border-color bg-transparent" id="name" name="name" value="{{ old('name', $recipe->name) }}" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="prep_time" class="form-label fw-bold">{{ __('Temps (min)') }} *</label>
                                <input type="number" class="form-control border-color bg-transparent" id="prep_time" name="prep_time" value="{{ old('prep_time', $recipe->prep_time) }}" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="status" class="form-label fw-bold">{{ __('Statut') }} *</label>
                                <select class="form-select border-color bg-transparent" id="status" name="status" required>
                                    <option value="pending" {{ $recipe->status == 'pending' ? 'selected' : '' }}>{{ __('En attente') }}</option>
                                    <option value="approved" {{ $recipe->status == 'approved' ? 'selected' : '' }}>{{ __('Approuvée') }}</option>
                                    <option value="refused" {{ $recipe->status == 'refused' ? 'selected' : '' }}>{{ __('Refusée') }}</option>
                                </select>
                            </div>

                            <!-- Ingredients -->
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">{{ __('Ingrédients') }} *</label>
                                <div id="ingredients-container">
                                    @php $ings = old('ingredients', is_array($recipe->ingredients) ? $recipe->ingredients : [$recipe->ingredients]); @endphp
                                    @foreach($ings as $index => $ing)
                                        <div class="input-group mb-2 ingredient-row">
                                            <input type="text" class="form-control border-color bg-transparent" name="ingredients[]" value="{{ $ing }}" required>
                                            <button type="button" class="btn btn-outline-danger btn-sm border-color remove-row"><i class="fas fa-times"></i></button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm rounded-pill px-3 mt-1" style="background-color: var(--bg-soft); color: var(--btn-bg); border: 1px dashed var(--btn-bg);" id="add-ingredient">
                                    <i class="fas fa-plus me-1"></i> {{ __('Ajouter un ingrédient') }}
                                </button>
                            </div>

                            <!-- Steps -->
                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold">{{ __('Étapes') }} *</label>
                                <div id="steps-container">
                                    @php $steps = old('steps', is_array($recipe->steps) ? $recipe->steps : [$recipe->steps]); @endphp
                                    @foreach($steps as $index => $step)
                                        <div class="input-group mb-2 step-row">
                                            <span class="input-group-text bg-transparent border-color fw-bold" style="color: var(--btn-bg); min-width: 40px; justify-content: center;">{{ $index + 1 }}</span>
                                            <textarea class="form-control border-color bg-transparent" name="steps[]" rows="2" required>{{ $step }}</textarea>
                                            <button type="button" class="btn btn-outline-danger btn-sm border-color remove-row"><i class="fas fa-times"></i></button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm rounded-pill px-3 mt-1" style="background-color: var(--bg-soft); color: var(--btn-bg); border: 1px dashed var(--btn-bg);" id="add-step">
                                    <i class="fas fa-plus me-1"></i> {{ __('Ajouter une étape') }}
                                </button>
                            </div>

                            <div class="col-12">
                                <hr class="border-color">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-main flex-grow-1 py-3 rounded-pill fw-bold shadow-sm">
                                        <i class="fas fa-save me-2"></i> {{ __('Enregistrer les modifications') }}
                                    </button>
                                    <a href="{{ route('admin.recipes.index') }}" class="btn btn-outline-secondary py-3 px-4 rounded-pill fw-bold shadow-sm border-color">
                                        {{ __('Annuler') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Shared row removal
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            const container = e.target.closest('#ingredients-container, #steps-container');
            if (container.children.length > 1) {
                e.target.closest('.input-group').remove();
                if (container.id === 'steps-container') renumberSteps();
            }
        }
    });

    // Ingredients
    document.getElementById('add-ingredient').addEventListener('click', function() {
        const container = document.getElementById('ingredients-container');
        const row = document.createElement('div');
        row.className = 'input-group mb-2 ingredient-row';
        row.innerHTML = `
            <input type="text" class="form-control border-color bg-transparent" name="ingredients[]" required>
            <button type="button" class="btn btn-outline-danger btn-sm border-color remove-row"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(row);
    });

    // Steps
    document.getElementById('add-step').addEventListener('click', function() {
        const container = document.getElementById('steps-container');
        const stepNum = container.children.length + 1;
        const row = document.createElement('div');
        row.className = 'input-group mb-2 step-row';
        row.innerHTML = `
            <span class="input-group-text bg-transparent border-color fw-bold" style="color: var(--btn-bg); min-width: 40px; justify-content: center;">${stepNum}</span>
            <textarea class="form-control border-color bg-transparent" name="steps[]" rows="2" required></textarea>
            <button type="button" class="btn btn-outline-danger btn-sm border-color remove-row"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(row);
    });

    function renumberSteps() {
        document.querySelectorAll('#steps-container .step-row').forEach((row, i) => {
            row.querySelector('.input-group-text').textContent = i + 1;
        });
    }
});
</script>
@endsection
