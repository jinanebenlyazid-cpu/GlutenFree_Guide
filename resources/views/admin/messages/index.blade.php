@extends('main')

@section('title', __('Messages - Admin'))

@section('content')
<section class="section py-4" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container-fluid px-lg-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none" style="color: var(--btn-bg);">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Messages') }}</li>
                    </ol>
                </nav>
                <h1 class="brand-font fw-bold mb-0">{{ __('Messages') }} <i class="fas fa-envelope-open-text ms-2 text-success"></i></h1>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.messages.index') }}" class="btn btn-sm rounded-pill px-3 {{ $status === 'all' ? 'btn-main' : 'btn-outline-secondary' }}">{{ __('Tous') }} ({{ $counts['all'] }})</a>
                <a href="{{ route('admin.messages.index', ['status' => 'open']) }}" class="btn btn-sm rounded-pill px-3 {{ $status === 'open' ? 'btn-main' : 'btn-outline-secondary' }}">{{ __('Ouverts') }} ({{ $counts['open'] }})</a>
                <a href="{{ route('admin.messages.index', ['status' => 'replied']) }}" class="btn btn-sm rounded-pill px-3 {{ $status === 'replied' ? 'btn-main' : 'btn-outline-secondary' }}">{{ __('Répondus') }} ({{ $counts['replied'] }})</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card card-custom border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: var(--bg-soft);">
                        <tr>
                            <th class="ps-4 py-3 border-0">{{ __('Utilisateur') }}</th>
                            <th class="py-3 border-0">{{ __('Sujet') }}</th>
                            <th class="py-3 border-0">{{ __('Message') }}</th>
                            <th class="py-3 border-0">{{ __('Statut') }}</th>
                            <th class="pe-4 py-3 border-0 text-end">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $contactMessage)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="fw-bold text-main">{{ $contactMessage->name }}</div>
                                    <div class="small opacity-50">{{ $contactMessage->email }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-soft text-main border border-color">{{ __($contactMessage->subject) }}</span>
                                </td>
                                <td class="small opacity-75" style="max-width: 360px;">
                                    {{ \Illuminate\Support\Str::limit($contactMessage->message, 80) }}
                                    <div class="opacity-50">{{ $contactMessage->created_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 {{ $contactMessage->status === 'replied' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $contactMessage->status === 'replied' ? __('Répondu') : __('Ouvert') }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('admin.messages.show', $contactMessage) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fas fa-eye me-1"></i> {{ __('Voir') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 opacity-50">
                                    <i class="fas fa-inbox fs-1 mb-3 d-block"></i>
                                    {{ __('Aucun message trouvé.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($messages->hasPages())
                <div class="px-4 py-3 border-top border-color">
                    {{ $messages->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
