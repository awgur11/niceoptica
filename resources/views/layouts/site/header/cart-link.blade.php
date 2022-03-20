<div class="cart-link header-icon-link">
	<a href="{{ route('cart') }}">
	    <i class="icon-Shopping-Bag"></i>
	    <div class="cart-link-count head-icon-count @if($cart_count == 0) active @endif">{{ $cart_count ?? null }}</div>
    </a>
</div>