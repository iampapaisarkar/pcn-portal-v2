@if ($paginator->hasPages())
<div class="row m-0">
    <div class="col-12 col-md-6 col-lg-6 d-flex align-items-center">
        <div class="dataTables_info" id="multicolumn_ordering_table_info" role="status" aria-live="polite">Showing {{ $paginator->currentPage() }} to {{ $paginator->count() }} of {{ $paginator->count() }} entries</div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
        <ul class="pagination float-right mb-0">
            @if (!$paginator->onFirstPage())
                <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link">&laquo; Previous</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link">Next &raquo;</a></li>
            @endif
        </ul>

        <!-- <ul class="pagination d-md-none">
            @if (!$paginator->onFirstPage())
                <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link">&laquo; Previous</a></li>
            @endif

            <li class="page-item"><span class="page-link">{{ $paginator->currentPage() }} of {{ $paginator->total() }}</span></li>

            @if ($paginator->hasMorePages())
                <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link">Next &raquo;</a></li>
            @endif
        </ul> -->
    </div>
</div>
@endif