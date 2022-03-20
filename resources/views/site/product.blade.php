@extends('site.base')

@section('content')

<style type="text/css">
	h1.product-title{
		font-size: 30px;
		font-family: fnormal;
		color: #333;
		text-transform: uppercase;
	}
	.product-code{
		font-family: fnormal;
		font-size: 16px;
		background: #5bb3e634;
	}
	.product-code span{
		font-family: fbold;
	}
	.price-block .price-word{
		font-family: fbold;
		font-size: 18px;
		color: #333;
	}
	.price-block .price-number{
		font-family: fnormal;
		font-size: 30px;
		color: #42a01f;
	}
	.price-block .price-currency{
		font-family: fbold;
		font-size: 13px;
		color: #000;
	}
	.product-params .table tr td{
		vertical-align: middle;
	}
	.product-params .table tr td:first-child{
		font-family: fbold;
		color: #333;
	}
	.product-params .table tr td:nth-child(2){
		font-family: fitalic;
		color: #666;
	}
@media screen and (max-width: 580px) {
	h1.product-title{
		font-size: 20px;
	}
	
}

</style>
<div class="container-fluid" >
	<div class="row mb-3">
		<div class="col-12" style="overflow: hidden;">
			@include('layouts.site.path-block')
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 pr-lg-0 mb-md-2 mb-lg-0" style="overflow: hidden;">
			@include('layouts.site.product.preview')
		</div> 
		<div class="col-lg-6 pl-lg-0 ">
			@include('layouts.site.product.price-block2')
		</div>
		<div class="col-12 order-2 order-md-3 mt-4">
			@include('layouts.site.product.content-tabs')
		</div>
	</div>
</div>

@include('layouts.site.product.advs-block', ['items' => $advs])

@if(count($products_brand) > 0)
<div class="container-fluid">
	<div class="row pl-1 pl-lg-0">
			<h2 class="block-title">
				@lang('Another products') {{ $product->fvalues->where('filter_id', 336)->first()->language->title }}
			</h2>

	</div>
	<div class="row">
		@include('layouts.site.cards.products', ['items' => $products_brand])
	</div>
</div>
@endif

@if(count($last_products) > 0)
<div class="container-fluid" style="margin-top: 124px;">
	<div class="row pl-1 pl-lg-0">
			<h2 class="block-title">
				@lang('Viewed products') 
			</h2>

	</div>
	<div class="row">
		@include('layouts.site.cards.products', ['items' => $last_products])
	</div>
</div>
@endif

@endsection