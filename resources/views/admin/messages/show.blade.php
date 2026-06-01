@extends('main')

@section('title', __('Détail du message - Admin'))

@section('content')
<section class="section py-4" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mb-3">
                <i class="fas fa-arrow-left me-1"></i> {{ __('Messages') }}
            </a>
            <h1 class="brand-font fw-bold mb-0">{{ __('Détail du message') }}</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4">
                <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first() }}
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card card-custom border-0 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <h4 class="fw-bold mb-1 text-main">{{ $contactMessage->name }}</h4>
                            <div class="small opacity-75">{{ $contactMessage->email }}</div>
                        </div>
                        <span class="badge rounded-pill px-3 py-2 {{ $contactMessage->status === 'replied' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $contactMessage->status === 'replied' ? __('Répondu') : __('Ouvert') }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <div class="small fw-bold opacity-75 mb-1">{{ __('Sujet') }}</div>
                        <span class="badge bg-soft text-main border border-color px-3 py-2">{{ __($contactMessage->subject) }}</span>
                    </div>

                    <div>
                        <div class="small fw-bold opacity-75 mb-2">{{ __('Message') }}</div>
                        <p class="mb-0 text-main" style="white-space: pre-wrap;">{{ $contactMessage->message }}</p>
                        <div class="small opacity-50 mt-3">{{ __('Envoyé') }} {{ $contactMessage->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card card-custom border-0 shadow-sm p-4">
                    @if($contactMessage->reply)
                        <div class="p-3 rounded-4 mb-4" style="background-color: var(--bg-soft);">
                            <div class="small fw-bold mb-2" style="color: var(--btn-bg);">
                                <i class="fas fa-reply me-1"></i> {{ __('Réponse actuelle') }}
                            </div>
                            <p class="mb-2 small text-main" style="white-space: pre-wrap;">{{ $contactMessage->reply }}</p>
                            <div class="small opacity-50">{{ __('Par') }} {{ $contactMessage->admin->name ?? __('Admin') }} • {{ optional($contactMessage->replied_at)->diffForHumans() }}</div>
                        </div>
                    @endif

                    <form action="{{ route('admin.messages.reply', $contactMessage) }}" method="POST">
                        @csrf
                        <label class="form-label small fw-bold opacity-75">{{ __('Répondre dans le compte utilisateur') }}</label>
                        <textarea name="reply" class="form-control rounded-4 px-3 py-3 border-color focus-ring mb-3" rows="6" placeholder="{{ __('Cette réponse apparaîtra dans ses notifications') }}" required></textarea>
                        <button type="submit" class="btn btn-main rounded-pill px-4 shadow-sm fw-bold w-100">
                            <i class="fas fa-paper-plane me-2"></i> {{ __('Envoyer') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
