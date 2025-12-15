<style>
    .page-link {
        transition: all 0.2s ease;
    }
    .page-link:hover {
        background-color: var(--bs-primary) !important;
        color: white !important;
        transform: translateY(-2px);
    }
    .page-item.active .page-link {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }
</style>
@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm justify-content-center m-0 gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link rounded-2 shadow-sm border-0 d-flex align-items-center justify-content-center bg-light text-muted" style="min-width: 32px; height: 32px;" aria-hidden="true">
                        <i class="bi bi-chevron-left small"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-2 shadow-sm border-0 d-flex align-items-center justify-content-center text-dark hover-primary" style="min-width: 32px; height: 32px;" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="bi bi-chevron-left small"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link rounded-2 shadow-sm border-0 d-flex align-items-center justify-content-center text-muted bg-transparent" style="min-width: 32px; height: 32px;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link rounded-2 shadow-sm border-0 d-flex align-items-center justify-content-center bg-primary text-white fw-bold" style="min-width: 32px; height: 32px;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link rounded-2 shadow-sm border-0 d-flex align-items-center justify-content-center text-secondary bg-white hover-primary" style="min-width: 32px; height: 32px;" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-2 shadow-sm border-0 d-flex align-items-center justify-content-center text-dark hover-primary" style="min-width: 32px; height: 32px;" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i class="bi bi-chevron-right small"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link rounded-2 shadow-sm border-0 d-flex align-items-center justify-content-center bg-light text-muted" style="min-width: 32px; height: 32px;" aria-hidden="true">
                        <i class="bi bi-chevron-right small"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
