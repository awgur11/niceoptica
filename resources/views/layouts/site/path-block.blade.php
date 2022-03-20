<style type="text/css">
    #path-block{
    	margin-top: 45px;
    }
	.path-link{
		font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 300;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
color: #898989;
	}
	#path-block .icon-Chevron---Right{
		color: #898989;
	}
	.path-item{
		font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 300;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
color: #202020;
	}
	a:hover{
		text-decoration: none;
	}
</style>
@if(Request::route() != null)
<div id="path-block" class="p-1 d-none d-md-block" >
	
	@if(Request::route()->getName() == 'products')
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a>
	    @if($catalog->parent_id != null) <span class="icon-Chevron---Right"></span> <a class="path-link" href="{{ route('products', ['id' => $catalog->parent->id, 'alt_title' => $catalog->parent->alt_title]) }}">{{ $catalog->parent->language->title }}</a> @endif <span class="icon-Chevron---Right"></span> <span class="path-item">{{ $catalog->language->title }} </span>
	@elseif(Request::route()->getName() == 'product')
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a> <span class="icon-Chevron---Right"></span> <a class="path-link" href="{{ route('products', ['id' => $product->catalog->id, 'alt_title' => $product->catalog->alt_title]) }}">{{ $product->catalog->language->title }}</a> <span class="icon-Chevron---Right"></span> <span class="path-item">{{ $product->language->title }} </span>
	@elseif(Request::route()->getName() == 'cart')
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a> <span class="icon-Chevron---Right"></span> <span class="path-item">@lang('Cart') </span>
	@elseif(Request::route()->getName() == 'cart.checkout')
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a> <span class="icon-Chevron---Right"></span> <a class="path-link" href="{{ route('cart') }}">@lang('Cart')</a> <span class="icon-Chevron---Right"></span> <span class="path-item">@lang('Ordering') </span>
	@elseif(Request::route()->getName() == 'cart.auth')
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a> <span class="icon-Chevron---Right"></span> <a class="path-link" href="{{ route('cart') }}">@lang('Cart')</a> <span class="icon-Chevron---Right"></span> <span class="path-item">@lang('Authorization') </span>
	@elseif(Request::route()->getName() == 'cabinet.user.data')
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a>  <span class="icon-Chevron---Right"></span> <span class="path-item">@lang('Personal Area') </span>
	@elseif(Request::route()->getName() == 'cabinet.user.loyalty')
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a>  <span class="icon-Chevron---Right"></span> <span class="path-item">@lang('Loyalty card') </span>
	@elseif(Request::route()->getName() == 'cabinet.user.delivery')
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a>  <span class="icon-Chevron---Right"></span> <span class="path-item">@lang('Delivery') </span>
	@elseif(Request::route()->getName() == 'cabinet.user.favorites')
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a>  <span class="icon-Chevron---Right"></span> <span class="path-item">@lang('Favorites') </span>
	@elseif(Request::route()->getName() == 'cabinet.user.orders')
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a>  <span class="icon-Chevron---Right"></span> <span class="path-item">@lang('Orders') </span>
	@elseif(Request::route()->getName() == 'compare.catalog')
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a>  <span class="icon-Chevron---Right"></span> <span class="path-item">@lang('Products in comparison') </span>
	@elseif(Request::route()->getName() == 'page' && $page->id == 49)
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a>  <span class="icon-Chevron---Right"></span> <span class="path-item">{{ $page->language->title }} </span>
	@elseif(Request::route()->getName() == 'page' && $page->type == 'blog')
	    @if($menu_pages->where('id', 49)->first() != null)
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a>  <span class="icon-Chevron---Right"></span> <a class="path-link" href="{{ route('page', ['alt_title' => $menu_pages->where('id', 49)->first()->alt_title ]) }}">{{ $menu_pages->where('id', 49)->first()->language->title }}</a>  <span class="icon-Chevron---Right"></span> <span class="path-item">{{ $page->language->title }} </span>
	    @endif
	@elseif(Request::route()->getName() == 'page')
	<a class="path-link" href="{{ route('index') }}">@lang('Home')</a> <span class="icon-Chevron---Right"></span> <span class="path-item">{{ $page->language->title }} </span>
	@endif

</div>
@endif