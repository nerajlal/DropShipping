@if ($paginator->hasPages())
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="page-link disabled">{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                <a href="{{ $url }}" class="page-link {{ $page == $paginator->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach
        @endif
    @endforeach
@endif
