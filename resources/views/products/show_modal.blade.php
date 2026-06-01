<div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content card-custom border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h4 class="fw-bold brand-font mb-0 text-main">{{ __($product->name) }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-6 text-center">
                        <div class="bg-white-adaptive rounded-4 p-3 border border-color d-flex align-items-center justify-content-center h-100 shadow-inner"
                            style="min-height: 300px;">
                            <img src="{{ asset($product->image_url) }}" class="img-fluid"
                                style="max-height: 300px; object-fit: contain;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span
                            class="badge bg-soft text-main px-3 py-2 rounded-pill mb-3 border border-color">{{ __($product->category) }}</span>
                        <h3 class="fw-bold text-success mb-3">{{ number_format($product->price, 2) }} {{ __('DH') }}
                        </h3>
                        <p class="opacity-75 mb-4 text-main fs-6 l-h-base">{{ __($product->description) }}</p>
                        @if($product->ingredients)
                            <div class="p-4 rounded-4 border border-color bg-soft text-start shadow-sm">
                                <strong class="brand-font d-block mb-2 text-main"><i
                                        class="fas fa-layer-group me-2 text-success"></i>{{ __('Ingrédients / Composition') }}</strong>
                                <p class="small text-main mb-0 lh-base opacity-75">{{ __($product->ingredients) }}</p>
                            </div>
                        @endif
                        <div class="mt-4 d-flex gap-2">
                            @auth
                                <form action="{{ route('favorites.toggle') }}" method="POST"
                                    class="favorite-toggle-form flex-grow-1">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input type="hidden" name="type" value="product">
                                    <button type="submit" class="btn btn-outline-danger w-100 rounded-pill fw-bold">
                                        <i
                                            class="fas fa-heart me-2"></i>{{ $product->favorites()->where('user_id', auth()->id())->exists() ? __('Retirer des favoris') : __('Ajouter aux favoris') }}
                                    </button>
                                </form>
                            @endauth
                            <button class="btn btn-soft-secondary rounded-pill px-4"
                                data-bs-dismiss="modal">{{ __('Fermer') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>