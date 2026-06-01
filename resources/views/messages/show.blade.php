@extends('main')

@section('title', __('Votre message - Guide Gluten-Free'))

@section('content')
<section class="section py-5" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container">
        <div class="mx-auto" style="max-width: 820px;">
            <h1 class="brand-font fw-bold mb-4">{{ __('Votre message') }}</h1>

            <div class="card card-custom border-0 shadow-sm p-4 mb-4">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                    <div>
                        <div class="small fw-bold opacity-75 mb-1">{{ __('Sujet') }}</div>
                        <span class="badge bg-soft text-main border border-color px-3 py-2">{{ __($contactMessage->subject) }}</span>
                    </div>
                    <span class="badge rounded-pill px-3 py-2 {{ $contactMessage->status === 'replied' ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ $contactMessage->status === 'replied' ? __('Répondu') : __('En attente') }}
                    </span>
                </div>

                <div class="small fw-bold opacity-75 mb-2">{{ __('Votre message') }}</div>
                <p class="mb-0 text-main" style="white-space: pre-wrap;">{{ $contactMessage->message }}</p>
                <div class="small opacity-50 mt-3">{{ $contactMessage->created_at->diffForHumans() }}</div>
            </div>

            <div class="card card-custom border-0 shadow-sm p-4">
                <h4 class="brand-font fw-bold mb-3"><i class="fas fa-reply me-2 text-success"></i>{{ __('Réponse') }}</h4>
                @if($contactMessage->reply)
                    <p class="mb-0 text-main" style="white-space: pre-wrap;">{{ $contactMessage->reply }}</p>
                    <div class="small opacity-50 mt-3">{{ __('Répondu') }} {{ optional($contactMessage->replied_at)->diffForHumans() }}</div>
                @else
                    <p class="mb-0 opacity-75">{{ __('Nous n’avons pas encore répondu à ce message.') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
