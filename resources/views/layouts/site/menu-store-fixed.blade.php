<!--
<style type="text/css">
    #menu-store-fixed{
    	position: fixed;
    	z-index: 999;
    	background: #fff;
    	top: 0;
    	left: 0;
    	width: 100%;
    	border-bottom: 1px solid #ddd;
    }
    #msf-top-bg{
    	background: linear-gradient(270deg, #3481be 0, #5bb3e6 100%);
    	padding: 5px;
    } 
    #msf-top,
    #msf-bottom{
    	width: 1320px;
    	max-width: 100%;
    	margin: 0 auto;
    }
    #msf-top a.mfs-item{
    	padding: 5px 10px;
    	font-family: fnormal;
    	font-size: 13px;
    	transition: 0.3s;
    	display: inline-block;
    }
    #msf-top a.mfs-item {
    	color: #fff;
    	transition: 0.3s;
    	border-radius: 5px;
    }
    #msf-top a.mfs-item.active{
    	font-family: fbold;
    }
    #msf-top a.mfs-item:not(.active):hover {
		background-color: #fff;
		color: #3481be;
	}
 
    #msf-bottom{
    	padding: 10px 5px;
    }
    .header-icon-link{
    	cursor: pointer;
    }
    .header-icon-link{
    	background: #fff;
    	border-radius: 5px;
    }
    .header-icon-link:hover{
    	//background-color: #5bb3e634;
    	box-shadow: 0 0 5px #5bb3e684 ;
    }
    .header-icon-link img{
    	filter: grayscale(90%);
    	transition: 0.3s;
    }
    .header-icon-link:hover img{
    	filter: grayscale(0%);
    }


	
</style>
<div id="menu-store-fixed">
	<div id="msf-top-bg">
    	<div id="msf-top" class="d-flex justify-content-between">
    		<div class="p-1 d-lg-none">
    			<a href="tel:{{ $site_option['phones'][0]['phone'] ?? null }}" style="color: #fff;">
					<b>{{ $site_option['phones'][0]['phone'] ?? null }}</b>
				</a>
    		</div>
    		<div class="p-1 d-none d-lg-block">
    			include('layouts.site.contacts.socialites')
    			
    		</div>
    		<div class="d-lg-flex d-none">
	        	<a href="{{ route('index') }}" class="mfs-item @if(url()->current() == route('index')) active" @endif>
	    	    	@lang('Home')
	    	    </a>

	@foreach($menu_pages as $mp)
	    	    <a href="{{ route('page', ['alt_title' => $mp->alt_title]) }}" class="mfs-item @if(url()->current() == route('page', ['alt_title' => $mp->alt_title])) active @endif">
	    		    {{ $mp->language->menu }}
	    	    </a>

	@endforeach
	        </div>
	        <div class="d-lg-none open-side-menu-button" style="padding: 5px 20px; color: #fff;">

	        	<i class="fas fa-bars"></i> @lang('Catalogs')
	        </div>
	    </div>
    </div>
	<div id="msf-bottom" class="d-flex justify-content-between align-items-center">
	    <div id="msf-logo-block">
	    	<a href="{{ route('index') }}">
	            <img src="{{ $site_option['firm_logo']['four'] }}" alt="" style="max-width: 100%;">
	        </a>
		</div>
		<div class="d-flex justify-content-end align-items-center">
			<div class="p-2 mr-2 text-center d-none d-lg-block">
				<a href="tel:{{ $site_option['phones'][0]['phone'] ?? null }}" style="color: #333;">
					<b>{{ $site_option['phones'][0]['phone'] ?? null }}</b>
				</a>
				<div data-target="#callbackModal" data-toggle="modal" style="cursor: pointer; color: #c7003d; "><b style="border-bottom: 1px dashed #333;">Обратный звонок</b></div>
			</div>
			<div class="d-none d-md-block" id="search-ajax-desc-block"> 
			    include('layouts.site.header.search-ajax')
		    </div>
			include('layouts.site.header.compare-link')
			include('layouts.site.header.favorites-link')
			include('layouts.site.header.cart-link')
		</div>
	</div>
</div>
-->
<style type="text/css">
    #menu-store-fixed{
    	position: relative;
    	z-index: 999999;
    	background: #fff;
    	top: 0;
    	left: 0;
    	width: 100%;
    	border-bottom: 1px solid #2848DA;;
    }

    #menu-store-top>div{
    	padding: 0 15px;
    }
    #menu-store-top{
    	border-left: 1px solid #DCDCDC;
    	border-right: 1px solid #DCDCDC;
    	background: #fff;

    }
    #menu-store-top .mfs-page-item{
    	font-family: 'Nunito Sans', sans-serif;
        font-size: 16px;
        line-height: 19px;
        letter-spacing: 0px;
        text-align: left;
        padding: 15px;
        display: inline-block;
        color: #202020;
    }
    #header-desc-logo{
    	width: 150px; 
    	max-width: 100%; 
    	transform: translateY(-2px);
    }
@media screen and (max-width: 768px) {
	#header-desc-logo{
		transform: translateY(0);

	}
	
}
</style>
<div id="menu-store-fixed" class="container-fluid">
	<div class="row justify-content-between align-items-center d-none d-md-flex" id="menu-store-top">
		<div>
			<a href="{{ route('index') }}">
	            <img src="/images/Vector2.svg" alt="" id="header-desc-logo" style="width: 150px; max-width: 100%; transform: translateY(-2px);">
	        </a>
	    @foreach($menu_pages->where('menu', 1) as $page)
	        <a href="{{ route('page', ['alt_title' => $page->alt_title]) }}" class="mfs-page-item d-none d-lg-inline-block">
	        	{{ $page->language->title }}
	        </a>
	    @endforeach
		</div>
		<div class="d-flex">
			<div class="hover-select-block mr-5">
                <i class="fas fa-phone-alt"></i> {{ $site_option['phones'][0]['phone'] }} <i class="fas fa-chevron-down"></i>
                <div class="hover-select-items">
            @foreach($site_option['phones'] as $ph)
                    <a class="hover-select-item" href="tel: {{ $ph['phone'] }}">{{ $ph['phone'] }}</a>
            @endforeach
                </div>
            </div>
			@include('layouts.site.store.languages-buttons')
		</div>
	</div>

	<div class="row " id="menu-store-bottom">
		<div class="col-md-3 col-xl-2 col-2">
			<div id="catalog-button">
		        <i class="icon-Align---Left"></i> <div class="d-none d-md-inline-block">@lang('Catalog')</div> 
		    </div>
		</div>
		<div class="col-8 pt-1 text-center d-md-none">
			<a href="{{ route('index') }}">
	            <img src="/images/Vector1.svg" alt="" id="header-desc-logo" style="width: 170px; max-width: 100%; transform: translateY(3px);">
	        </a>			
		</div>
		<div class="col-2 d-md-none text-right pt-2">
			@include('layouts.site.header.cart-link')
		</div>
		<div class="col-md-6 col-xl-8" style="padding: 10px 15px">
			@include('layouts.site.header.search-ajax')
		</div>
		<div class="d-none d-md-flex col-md-3 col-xl-2 align-items-center justify-content-around">
			@include('layouts.site.header.auth-link')
			@include('layouts.site.header.compare-link')
			@include('layouts.site.header.favorites-link')
			@include('layouts.site.header.cart-link')
		</div> 
 
	</div>
@include('layouts.site.store.all-filters-side')

@include('layouts.site.side-menu')

@include('layouts.site.store.sorting-mobile-block')
</div>

<style type="text/css">
    #menu-store-bottom{
    	background: #2848DA;
    }
	#catalog-button{
		cursor: pointer;
		color: #fff;
		font-family: 'Nunito Sans', sans-serif;
		font-size: 16px;
		padding: 18px;
	}
	#catalog-button i{
		margin-left: 5px;
	}
@media screen and (max-width: 580px) {
	#catalog-button{
		padding: 10px 0 0;
	}
	#catalog-button i{
		margin-left: 0px;
	}
	
}
</style>