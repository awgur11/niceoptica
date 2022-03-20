@extends('site.base')

@section('content')
<div class="container-fluid p-0">
@include('layouts.site.slider')
</div>

<div class="container-fluid ">
	<div class="row">
@include('layouts.site.cards.catalogs', ['items' => $menu_catalogs->where('home_page', 1)])		
	</div>
</div>
 
<style type="text/css">
    .index-catalogs-block{
    	border-bottom: 1px solid #DCDCDC;
    	display: flex;
    	max-width: 100%;
    }

	.icb-item{
		font-family: Nunito Sans;
font-size: 18px;
font-style: normal;
font-weight: 400;
line-height: 22px;
letter-spacing: 0px;
text-align: left;
color: #202020;
padding: 15px 0;
min-width: 200px;
max-width: 32%;
text-transform: uppercase;
margin-right: 56px;
display: inline-block;
cursor: pointer;
	}
	.icb-item.active span{
		position: relative;
		cursor: pointer;
	}
	.icb-item.active span:after{
		position: absolute;
		content: "";
		width: 100%;
		height: 5px;
		left: 0;
		bottom: -17px;
		background: #2C50F2;
		z-index: 99;
	}
@media screen and (max-width: 580px) {
	.index-catalogs-block{
    	overflow-x: auto;
    }
    .icb-item{
    	max-width: auto;
    }
        .index-catalogs-block::-webkit-scrollbar {
  display: none;
}
	
}
</style>
<script type="text/javascript">
	function filterTopProducts()
	{
		var id = $('.icb-item.active').data('id');

		$('.top-sale-products .product-block').each(function(){
			if($(this).hasClass('product-catalog-id-' + id))
				$(this).removeClass('d-none');
			else
				$(this).addClass('d-none');
		});
	}
	$(function(){
		$('.icb-item').first().addClass('active');
		filterTopProducts();

		$('.icb-item').click(function(){
			$('.icb-item').removeClass('active');
			$(this).addClass('active');
			filterTopProducts();
		});
	});
</script>
<div class="container-fluid mt-6 mb-5" style="overflow: hidden;">
	<div class="row">
		<div class="col-lg-6 pl-lg-0">
			<h2 class="block-title">@lang('TOP sales')</h2>
		</div>
		<div class="col-lg-6 pr-md-0">
			<div class="index-catalogs-block">
		@foreach($menu_catalogs->where('home_page', 1)->slice(0, 3) as $mc)
				<div class="icb-item" data-id="{{ $mc->id }}">
					<span>{{ $mc->language->title ?? null }}</span>
				</div>
		@endforeach
			</div>
		</div>
	</div>
</div>
<div class="container-fluid top-sale-products">
	<div class="row">
		@include('layouts.site.cards.products', ['items' => $promo])
	</div>
</div>
<style type="text/css">
	.brands-navigation{
		font-size: 17px;
		color: #202020;
		padding: 30px;
		position: relative;
		cursor: pointer;

	}
	.brands-navigation:hover{
		color: #2C50F2;
	}
	#all-news-link{
		font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
color: #2C50F2;

	}
	#all-news-link i{
		position: relative;
		top: 2px;
	}
</style>
<div class="container-fluid mt-6 mb-5">
	<div class="row mb-4">
		<div class="col-lg-6 pl-lg-0">
			<h2 class="block-title">@lang('Brands')</h2>
		</div>
		<div class="col-lg-6 pr-md-0 d-flex justify-content-end">
			<div class="brands-navigation brands-navigation-left">
				<i class="icon-Arrow---Left"></i>
			</div>
			<div class="brands-navigation brands-navigation-right">
				<i class="icon-Arrow---Right"></i>
			</div>

		</div>
	</div>
	<div class="row">
		<div class="col-12 p-0">
			@include('layouts.site.index.brands-carousel')
		</div>
	</div>
</div>

<div class="container-fluid mt-6">
	<div class="row mb-4">
		<div class="col-md-6 pl-lg-0">
			<h2 class="block-title">@lang('News')</h2>
		</div>
		<div class="col-md-6 text-right">
				<a id="all-news-link" href="{{ route('page', ['alt_title' => $menu_pages->find(49)->alt_title])}}">@lang('All news') <i class="icon-Arrow---Right"></i></a>
		</div>
	</div>
	<div class="row" style="border-top: 1px solid #DCDCDC; border-left: 1px solid #DCDCDC;">
		@include('layouts.site.cards.articles', ['items' => $blog])
	</div>
</div>




@endsection