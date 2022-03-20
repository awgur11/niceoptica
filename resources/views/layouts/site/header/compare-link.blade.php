<div class="compare-link header-icon-link">
	<a href="{{ route('compare.index') }}">
	    <i class="icon-Pillow-Chart---1"></i>
	    <div class="compare-link-count head-icon-count @if($compare_count == 0) d-none @endif">{{ $compare_count ?? null }}</div>
    </a>
</div>