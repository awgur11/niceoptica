
<div class="favorites-link header-icon-link">
	<a href="{{ route('cabinet.user.favorites') }}">
	    <i class="icon-Heart"></i>

	    <div id="" class="favorites-link-count head-icon-count @if($favorites_count == 0) d-none @endif">{{ $favorites_count ?? 0 }}</div>

    </a>
</div>