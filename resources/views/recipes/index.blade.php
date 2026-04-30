@extends('main')

@section('title', __('Communauté & Recettes Sans Gluten'))

@section('content')
<section class="section py-5" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container-fluid px-lg-5">
        <!-- Hero Header -->
        <div class="row mb-5 align-items-center" data-aos="fade-up">
            <div class="col-md-7 text-center text-md-start">
                <span class="badge bg-soft text-main px-3 py-2 rounded-pill mb-3 border border-color shadow-sm">
                    <i class="fas fa-utensils me-2 text-success"></i>{{ __('Communauté Gourmande') }}
                </span>
                <h1 class="brand-font fw-bold mb-2 display-5 text-main">{{ __('Recettes & Partages') }} 👩‍🍳</h1>
                <p class="opacity-75 mb-0 fs-5 text-main">{{ __('Découvrez et partagez des pépites culinaires 100% sans gluten.') }}</p>
            </div>
            <div class="col-md-5 text-md-end mt-4 mt-md-0">
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-md-end align-items-center">
                    <form action="{{ route('recipes.index') }}" method="GET" class="flex-grow-1 w-100">
                        <div class="input-group shadow-sm rounded-pill overflow-hidden border border-color glass p-1 search-group">
                            <span class="input-group-text bg-transparent border-0 d-none d-sm-flex"><i class="fas fa-search opacity-50 text-main"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 bg-transparent shadow-none text-main ps-3 ps-sm-0" placeholder="{{ __('Chercher...') }}">
                            <button type="submit" class="btn btn-main rounded-pill px-3 px-sm-4 fw-bold small">{{ __('Chercher') }}</button>
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

        <!-- Filters Bar -->
        <div class="row mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="col-12">
                <div class="card card-custom border-0 shadow-sm p-3 glass filter-card">
                    <form action="{{ route('recipes.index') }}" method="GET" class="row g-3 align-items-center px-md-4">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <label class="small fw-bold text-main opacity-75 mb-0 text-nowrap"><i class="fas fa-layer-group me-2 text-success"></i>{{ __('Difficulté') }}</label>
                                <select name="difficulty" class="form-select form-select-sm border-0 bg-soft rounded-pill text-main shadow-none" onchange="this.form.submit()">
                                    <option value="">{{ __('Toutes') }}</option>
                                    <option value="facile" {{ request('difficulty') == 'facile' ? 'selected' : '' }}>{{ __('Facile') }}</option>
                                    <option value="moyen" {{ request('difficulty') == 'moyen' ? 'selected' : '' }}>{{ __('Moyen') }}</option>
                                    <option value="difficile" {{ request('difficulty') == 'difficile' ? 'selected' : '' }}>{{ __('Difficile') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <label class="small fw-bold text-main opacity-75 mb-0 text-nowrap"><i class="fas fa-clock me-2 text-success"></i>{{ __('Temps Max') }}</label>
                                <div class="input-group input-group-sm bg-soft rounded-pill p-1">
                                    <input type="number" name="max_time" value="{{ request('max_time') }}" class="form-control border-0 bg-transparent shadow-none text-main" placeholder="{{ __('Min') }}">
                                    <span class="input-group-text bg-transparent border-0 opacity-50 small">{{ __('min') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <button type="submit" class="btn btn-soft-primary btn-sm rounded-pill px-4 fw-bold me-2"><i class="fas fa-filter me-2"></i>{{ __('Filtrer') }}</button>
                            @if(request()->anyFilled(['search', 'difficulty', 'max_time']))
                                <a href="{{ route('recipes.index') }}" class="btn btn-link text-main opacity-50 small fw-bold text-decoration-none">{{ __('Réinitialiser') }}</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if($recipes->count() > 0)
            <div class="row g-4" data-aos="fade-up" data-aos-delay="200">
                @foreach($recipes as $recipe)
                    <div class="col-md-6 col-lg-4 col-xl-3 d-flex align-items-stretch">
                        <div class="card card-custom border-0 shadow-sm w-100 overflow-hidden recipe-card" style="border-radius: 20px;">
                            <div class="position-relative" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#recipeModal{{ $recipe->id }}">
                                <img src="{{ asset($recipe->image_url ?? 'images/default-recipe.jpg') }}" class="card-img-top" alt="{{ __($recipe->name) }}" style="height: 240px; object-fit: cover; transition: 0.5s;">
                                <div class="position-absolute top-0 end-0 p-3 z-1">
                                    @auth
                                        <form action="{{ route('favorites.toggle') }}" method="POST" class="d-inline favorite-toggle-form" onclick="event.stopPropagation();">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $recipe->id }}">
                                            <input type="hidden" name="type" value="recipe">
                                            <button type="submit" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; color: #ff4757;">
                                                <i class="{{ $recipe->favorites()->where('user_id', auth()->id())->exists() ? 'fas' : 'far' }} fa-heart"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" onclick="event.stopPropagation();">
                                            <i class="far fa-heart"></i>
                                        </a>
                                    @endauth
                                </div>
                                <div class="position-absolute bottom-0 start-0 w-100 p-4 z-1 text-white" style="background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);">
                                    <h5 class="fw-bold brand-font mb-1 fs-4">{{ __($recipe->name) }}</h5>
                                    <div class="d-flex align-items-center small gap-4 opacity-90">
                                        <span><i class="fas fa-clock text-warning me-1"></i> {{ $recipe->prep_time }} {{ __('min') }}</span>
                                        <span>
                                            <i class="fas fa-fire-alt me-1 {{ $recipe->difficulty == 'difficile' ? 'text-danger' : ($recipe->difficulty == 'moyen' ? 'text-warning' : 'text-success') }}"></i> 
                                            {{ __(ucfirst($recipe->difficulty)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($recipe->user->name ?? 'User') }}&background=6b8e23&color=fff" class="rounded-circle shadow-sm" width="32" height="32">
                                    <div>
                                        <small class="d-block opacity-50">{{ __('Par') }}</small>
                                        <span class="small fw-bold text-main">{{ $recipe->user->name ?? __('Communauté') }}</span>
                                    </div>
                                </div>
                                
                                <div class="row g-2 mt-auto">
                                    <div class="col-6">
                                        <button class="btn btn-main w-100 rounded-pill btn-sm fw-bold py-2" data-bs-toggle="modal" data-bs-target="#recipeModal{{ $recipe->id }}">
                                            {{ __('Voir Recette') }}
                                        </button>
                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-soft-secondary w-100 rounded-pill btn-sm py-2 comment-toggle-btn" 
                                                type="button" data-bs-toggle="collapse" data-bs-target="#cardComments{{ $recipe->id }}">
                                            <i class="fas fa-comments fs-6"></i>
                                            <span class="comment-count-badge-{{ $recipe->id }} small fw-bold">{{ $recipe->comments->count() }}</span>
                                        </button>
                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-soft-secondary w-100 rounded-pill btn-sm py-2 share-btn" 
                                                data-url="{{ route('recipes.show', $recipe->id) }}" 
                                                data-title="{{ __($recipe->name) }}"
                                                title="{{ __('Partager') }}">
                                            <i class="fas fa-share-alt fs-6"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Comments Drawer on Card -->
                            <div class="collapse" id="cardComments{{ $recipe->id }}">
                                <div class="border-top border-color bg-soft">
                                    <div class="comments-list custom-scrollbar px-3 pt-3" id="commentsList{{ $recipe->id }}" style="max-height: 200px; overflow-y: auto;">
                                        @forelse($recipe->comments->sortByDesc('created_at') as $comment)
                                            <div class="mb-3 p-2 rounded-3 bg-body-tertiary shadow-xs" style="font-size: 0.8rem;" id="comment-{{ $comment->id }}">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="fw-bold text-main">{{ $comment->user->name ?? '?' }}</span>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="opacity-50" style="font-size: 0.7rem;">{{ $comment->created_at->diffForHumans() }}</span>
                                                        @if(Auth::check() && Auth::id() === $comment->user_id)
                                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce commentaire ?') }}');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-link text-danger p-0 border-0" style="font-size: 0.7rem;" title="{{ __('Supprimer') }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="mb-0 opacity-75">{{ __($comment->body) }}</p>
                                            </div>
                                        @empty
                                            <p class="text-center small opacity-50 py-3 mb-0 no-comments-msg">{{ __('Aucun commentaire') }}</p>
                                        @endforelse
                                    </div>
                                    <!-- Comment Input in Card -->
                                    <div class="p-3 border-top border-color">
                                        @auth
                                            <form class="comment-form d-flex gap-2 align-items-center" data-recipe-id="{{ $recipe->id }}" data-url="{{ route('comments.store', $recipe->id) }}">
                                                <input type="text" name="body" class="form-control form-control-sm border-color bg-body shadow-none rounded-pill px-3" style="font-size: 0.8rem;" placeholder="{{ __('Commenter...') }}" required autocomplete="off">
                                                <button type="submit" class="btn btn-main btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fas fa-paper-plane" style="font-size: 0.7rem;"></i></button>
                                            </form>
                                        @else
                                            <p class="small text-center mb-0 opacity-50"><i class="fas fa-lock me-1"></i> {{ __('Connectez-vous pour commenter') }}</p>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-5 d-flex justify-content-center" data-aos="fade-up">
                {{ $recipes->links('vendor.pagination.custom') }}
            </div>
        @else
            <div class="card card-custom border-0 shadow-sm p-5 text-center d-flex flex-column align-items-center glass rounded-5" data-aos="zoom-in">
                <i class="fas fa-utensils fs-1 text-muted mb-4 opacity-25" style="font-size: 5rem !important;"></i>
                <h4 class="fw-bold brand-font text-main mb-3">{{ __('Aucune recette pour le moment') }}</h4>
                <p class="opacity-75 mb-4 fs-5 text-main">{{ __('Soyez le premier à partager une création avec la communauté !') }}</p>
                <a href="{{ route('recipes.create') }}" class="btn btn-main rounded-pill px-5 py-3 fw-bold">{{ __('Partager une recette') }}</a>
            </div>
        @endif
    </div>
</section>

<!-- MODALS OUTSIDE -->
@if($recipes->count() > 0)
    @foreach($recipes as $recipe)
        <div class="modal fade" id="recipeModal{{ $recipe->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content card-custom border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
                    <div class="modal-header border-0 pb-0 pt-4 px-4 position-absolute top-0 end-0 z-3">
                        <button type="button" class="btn-close shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; border-radius: 50%; padding: 0.8rem;"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <!-- Image Column -->
                            <div class="col-md-5 d-none d-md-block" style="background: url('{{ asset($recipe->image_url ?? 'images/default-recipe.jpg') }}') center/cover; min-height: 100%;"></div>
                            <div class="col-md-5 d-md-none">
                                <img src="{{ asset($recipe->image_url ?? 'images/default-recipe.jpg') }}" class="img-fluid w-100">
                            </div>
                            
                            <!-- Content Column -->
                            <div class="col-md-7 p-4">
                                <h3 class="fw-bold brand-font text-main mb-3 mt-md-0 mt-2">{{ __($recipe->name) }}</h3>
                                
                                <div class="d-flex gap-4 mb-4 pb-3 border-bottom border-color text-main bg-soft rounded-4 p-3 justify-content-center">
                                    <div class="text-center px-3 border-end border-color">
                                        <i class="fas fa-clock fs-4 mb-1 text-success opacity-75"></i>
                                        <div class="small fw-bold">{{ $recipe->prep_time }} {{ __('min') }}</div>
                                    </div>
                                    <div class="text-center px-3">
                                        <i class="fas fa-fire-alt fs-4 mb-1 {{ $recipe->difficulty == 'difficile' ? 'text-danger' : ($recipe->difficulty == 'moyen' ? 'text-warning' : 'text-success') }} opacity-75"></i>
                                        <div class="small fw-bold">{{ __(ucfirst($recipe->difficulty)) }}</div>
                                    </div>
                                </div>

                                <h6 class="fw-bold mb-3 text-main"><i class="fas fa-layer-group me-2 text-success"></i>{{ __('Ingrédients') }}</h6>
                                <ul class="list-unstyled mb-4 small text-main l-h-base">
                                    @if(is_array($recipe->ingredients))
                                        @foreach($recipe->ingredients as $ingredient)
                                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2 opacity-50"></i>{{ __($ingredient) }}</li>
                                        @endforeach
                                    @else
                                        <li>{{ __($recipe->ingredients) }}</li>
                                    @endif
                                </ul>

                                <h6 class="fw-bold mb-3 text-main"><i class="fas fa-list-ol me-2 text-success"></i>{{ __('Préparation') }}</h6>
                                <ol class="ps-3 mb-4 small text-main l-h-base">
                                    @if(is_array($recipe->steps))
                                        @foreach($recipe->steps as $step)
                                            <li class="mb-3">{{ __($step) }}</li>
                                        @endforeach
                                    @else
                                        <li>{{ is_array($recipe->steps) ? implode(' ', array_map('__', (array)$recipe->steps)) : __($recipe->steps) }}</li>
                                    @endif
                                </ol>

                                <!-- Comments Section in Modal -->
                                <div class="border-top border-color pt-4">
                                    <h6 class="fw-bold mb-3 text-main"><i class="fas fa-comments me-2 text-success"></i>{{ __('Discussions') }}</h6>
                                    @auth
                                        <form class="comment-form mb-4 d-flex gap-2" data-recipe-id="{{ $recipe->id }}" data-url="{{ route('comments.store', $recipe->id) }}">
                                            <input type="text" name="body" class="form-control form-control-sm border-color bg-soft rounded-pill px-3" placeholder="{{ __('Dire un mot...') }}" required autocomplete="off">
                                            <button type="submit" class="btn btn-main btn-sm rounded-circle" style="width:36px;height:36px;"><i class="fas fa-paper-plane"></i></button>
                                        </form>
                                    @endauth
                                    <div class="modal-comments-list custom-scrollbar" id="modalCommentsList{{ $recipe->id }}" style="max-height: 250px;">
                                        @foreach($recipe->comments->sortByDesc('created_at') as $comment)
                                            <div class="mb-3 p-3 rounded-4 bg-soft" style="font-size: 0.85rem;" id="modal-comment-{{ $comment->id }}">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="fw-bold text-main">{{ $comment->user->name }}</span>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="small opacity-50">{{ $comment->created_at->diffForHumans() }}</span>
                                                        @if(Auth::check() && Auth::id() === $comment->user_id)
                                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce commentaire ?') }}');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-link text-danger p-0 border-0" style="font-size: 0.85rem;" title="{{ __('Supprimer') }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-main opacity-75">{{ __($comment->body) }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

<style>
    .recipe-card:hover { transform: translateY(-10px); }
    .recipe-card:hover img { transform: scale(1.05); }
    .btn-soft-secondary { background: var(--bg-soft); color: var(--text-main); border: none; }
    .btn-soft-secondary:hover { background: var(--border-color); }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .l-h-base { line-height: 1.6; }
    html[data-bs-theme="dark"] .card-body { background-color: var(--card-bg) !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: var(--btn-bg); border-radius: 10px; }
    .btn-soft-primary { background-color: rgba(107, 142, 35, 0.1); color: var(--btn-bg); border: none; transition: 0.3s; }
    .btn-soft-primary:hover { background-color: var(--btn-bg); color: #fff; }
    
    /* Strong scroll enforcement for modal body */
    .modal-dialog-scrollable .modal-body {
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Ensure the row doesn't break the container */
    .modal-content { max-height: 95vh; }

    /* Mobile Responsive Adjustments */
    .filter-card { border-radius: 50px; }
    @media (max-width: 768px) {
        .filter-card { border-radius: 24px; padding: 1.5rem !important; }
        .search-group { border-radius: 20px !important; }
        .search-group input { font-size: 0.9rem; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-open modal if ID is in URL
    const urlParams = new URLSearchParams(window.location.search);
    const recipeId = urlParams.get('recipe');
    if (recipeId) {
        const modalEl = document.getElementById('recipeModal' + recipeId);
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Handle AJAX comment submission
    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const recipeId = this.dataset.recipeId;
            const url = this.dataset.url;
            const input = this.querySelector('input[name="body"]');
            const body = input.value.trim();
            const btn = this.querySelector('button[type="submit"]');
            
            if (!body) return;

            btn.disabled = true;
            const originalIcon = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ body: body }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const c = data.comment;

                    // Comment HTML for card list
                    const cardCommentHtml = `
                        <div class="mb-3 p-2 rounded-3 bg-body-tertiary shadow-xs" style="font-size: 0.8rem;" id="comment-${c.id}">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold text-main">${c.user_name}</span>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="opacity-50" style="font-size: 0.7rem;">${c.time}</span>
                                    ${c.can_delete ? `
                                    <form action="${c.delete_url}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
                                        <input type="hidden" name="_token" value="${csrfToken}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-link text-danger p-0 border-0" style="font-size: 0.7rem;" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    ` : ''}
                                </div>
                            </div>
                            <p class="mb-0 opacity-75">${c.body}</p>
                        </div>`;

                    // Comment HTML for modal list
                    const modalCommentHtml = `
                        <div class="mb-3 p-3 rounded-4 bg-soft" style="font-size: 0.85rem;" id="modal-comment-${c.id}">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold text-main">${c.user_name}</span>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="small opacity-50">${c.time}</span>
                                    ${c.can_delete ? `
                                    <form action="${c.delete_url}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
                                        <input type="hidden" name="_token" value="${csrfToken}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-link text-danger p-0 border-0" style="font-size: 0.85rem;" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    ` : ''}
                                </div>
                            </div>
                            <p class="mb-0 text-main opacity-75">${c.body}</p>
                        </div>`;

                    // Update UI
                    const cardList = document.getElementById('commentsList' + recipeId);
                    if (cardList) {
                        const noMsg = cardList.querySelector('.no-comments-msg');
                        if (noMsg) noMsg.remove();
                        cardList.insertAdjacentHTML('afterbegin', cardCommentHtml);
                    }

                    const modalList = document.getElementById('modalCommentsList' + recipeId);
                    if (modalList) {
                        const noMsg = modalList.querySelector('.no-comments-msg');
                        if (noMsg) noMsg.remove();
                        modalList.insertAdjacentHTML('afterbegin', modalCommentHtml);
                    }

                    // Update badges
                    document.querySelectorAll('.comment-count-badge-' + recipeId).forEach(badge => {
                        badge.textContent = parseInt(badge.textContent) + 1;
                    });

                    input.value = '';
                }
            })
            .catch(err => console.error('Comment Error:', err))
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalIcon;
            });
        });
    });

    // Sharing logic
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const url = this.dataset.url;
            const title = this.dataset.title;

            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                }).catch(console.error);
            } else {
                // Fallback: Copy to clipboard
                const dummy = document.createElement('input');
                document.body.appendChild(dummy);
                dummy.value = window.location.origin + url;
                dummy.select();
                document.execCommand('copy');
                document.body.removeChild(dummy);
                
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check text-success"></i>';
                setTimeout(() => {
                    this.innerHTML = originalHtml;
                }, 2000);
            }
        });
    });
});
</script>
@endsection
