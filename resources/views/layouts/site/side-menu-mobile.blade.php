<script type="text/javascript">
	$(document).on('click', '#catalog-button', function(){
		if($(window).width() <= 768)
		{
			$('#side-menu-mobile').toggleClass('show');
		}
	});
	$(document).on('click', '.close-mobile-menu-button', function(){
		$('#side-menu-mobile').removeClass('show');

	})
</script>
<style type="text/css">
	#side-menu-mobile{
		position: fixed;
		top: 0;
		left: 0;
		z-index: 9999999;
		height: 100vh;
		width: 290px;
		overflow-y: auto;
		overflow-x: unset;
		background: #fff;
		transform: translateX(-100%);
		transition: 0.5s;
	}
	#side-menu-mobile.show{
		transform: translateX(0);
		box-shadow: 3px 0 3px rgba(0,0,0,0.1);
	}
	#side-menu-mobile-bg{
	    display: none;
		width: 1440px;
		top: 0;
		left: 0;
		max-width: 100%;
		height: 100vh;
		background: rgba(0,0,0,.8);
		position: absolute;
		z-index: 9999998;
	}
	#side-menu-mobile.show + #side-menu-mobile-bg{
		display: block;
		
	}
	.auth-block{
		height: 56px;
		background: #2848DA;
		color: #fff;
		position: relative;
	}
	.auth-lang .hover-select-block{
		color: #fff;
	}
	#side-menu-mobile .catalogs-block,
	#side-menu-mobile .cb-icons-block,
	#side-menu-mobile .cb-phones-block{
	    border-bottom: 1px solid #DCDCDC;
	}
	#side-menu-mobile .catalogs-block .cb-item{
		font-family: Nunito Sans;
        font-size: 14px;
        display: block;
        font-style: normal;
        font-weight: 400;
        line-height: 17px;
        letter-spacing: 0px;
        text-align: left;
        color: #202020;
	}
	#side-menu-mobile .cb-icons-block .header-icon-link a i{
		color: #202020;
	}
	#side-menu-mobile .cb-phones-block .cbp-item{
		font-family: Nunito Sans;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 17px;
        letter-spacing: 0px;
	}
	.close-mobile-menu-button{
		position: absolute;
		right: 20px;
		padding: 10px;
		font-size: 25px;
		color: #fff;
	}
	.cbi-item a{
		color: #202020;
	}
</style>
<div id="side-menu-mobile">
	<div class="auth-block d-flex align-items-center justify-content-between">
		
@auth
        <div class="auth-name px-4">
         	{{ auth()->user()->name }}
        </div>
@else
        <div class="auth-name px-4 d-flex align-items-center">
        	<div>
        	    <i class="icon-Business-Man mr-3" style="font-size: 24px;"></i>
        	</div>
        	<div>
        	    @lang('Log into account')
        	</div>
        </div>
@endauth
        <div class="auth-lang p-2">
         	@include('layouts.site.store.languages-buttons')
        </div>      
	</div>

	<div class="catalogs-block p-3">
@foreach($menu_catalogs as $mc)
        <a class="cb-item py-2" href="{{ route('products', ['id' => $mc->id, 'alt_title' => $mc->alt_title]) }}">
         	{{ $mc->language->title }}         	
        </a>
@endforeach
	</div>
 
	<div class="cb-icons-block p-3">
		<div class="cbi-item py-2 d-flex">
		     @include('layouts.site.header.cart-link') <a href="{{ route('cart') }}" class="ml-2 d-block">@lang('Cart')</a>
		</div>
		<div class="cbi-item py-2 d-flex">
			@include('layouts.site.header.compare-link') <a href="{{ route('compare.index') }}" class="d-block ml-2">@lang('Comparison')</a>
		</div>
		<div class="cbi-item  py-2 d-flex">
			@include('layouts.site.header.favorites-link') <a href="{{ route('favorites') }}" class="ml-2 d-flex">@lang('Favorites')</a>
		</div>
	</div>

	<div class="cb-phones-block p-3">
		<div class="cbp-item d-flex py-2 justify-content-between">
			<div><i class="fas fa-phone-alt"></i> <a href="tel:{{ $site_option['phones'][0]['phone'] }}" style="color:#202020;">{{ $site_option['phones'][0]['phone'] }}</a></div>
			<div class="text-muted">9:00 - 21:00</div>
		</div>
		<div class="cbp-item d-flex py-2">
			<i class="fas fa-phone-alt"></i> <div class="ml-2" data-toggle="modal" data-target="#callbackModal">@lang("We'll call You Back")</div>
		</div>
	</div>

	<div class="catalogs-block p-3">
@foreach($menu_pages as $page)
        <a class="cb-item py-2" href="{{ route('page', ['alt_title' => $page->alt_title]) }}">
         	{{ $page->language->title }}         	
        </a>
@endforeach
	</div>
@auth
    <div class="smb-logout-block p-3">
    	<form action="{{ route('user.logout') }}" method="POST">
        	@csrf               
            <button type="submit" style="display: inline-block; font-size: 14px; font-family: Nunito Sans; cursor: pointer; border: none; background-color: transparent;" > <i class="icon-Sign-Out mr-2"></i> @lang('Sign out')
        	</button>
        </form>
    </div>
@endauth
	
</div>
<div id="side-menu-mobile-bg">
	<div class="close-mobile-menu-button">
		<i class="icon-Cross"></i>
	</div>
</div>
