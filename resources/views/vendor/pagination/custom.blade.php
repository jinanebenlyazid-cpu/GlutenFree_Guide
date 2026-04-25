@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center mt-4">
        <ul class="pagination pagination-custom shadow-sm rounded-pill p-1 glass">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link rounded-circle border-0 bg-transparent text-muted"><i class="fas fa-chevron-left"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-circle border-0 bg-transparent text-main" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left"></i></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link border-0 bg-transparent text-muted">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        {{-- We only show 3 links max by using current page and offset --}}
                        @if ($page >= $paginator->currentPage() - 1 && $page <= $paginator->currentPage() + 1)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span class="page-link rounded-circle border-0 shadow-sm fw-bold">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link rounded-circle border-0 bg-transparent text-main" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-circle border-0 bg-transparent text-main" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fas fa-chevron-right"></i></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link rounded-circle border-0 bg-transparent text-muted"><i class="fas fa-chevron-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif

<style>
.pagination-custom {
    background: var(--bg-soft);
    border: 1px solid var(--border-color);
}
.pagination-custom .page-link {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 2px;
    transition: 0.3s;
}
.pagination-custom .page-item.active .page-link {
    background-color: var(--btn-bg) !important;
    color: white !important;
}
.pagination-custom .page-link:hover:not(.disabled) {
    background-color: var(--border-color);
}
</style>
