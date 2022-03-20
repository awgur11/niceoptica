@extends('site.base')

@section('content')
<style type="text/css">
	h2.block-title{
		text-align: center;
		color: #2C50F2;;
		font-weight: 600;
	}
</style>

<div class="container-fluid" >
	<div class="row mb-3">
		<div class="col-12" style="overflow: hidden;">
			@include('layouts.site.path-block')
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<h1 class="catalog-title">@lang('Favorites')</h1>
		</div>
	</div>
</div> 

@include('cabinet.layouts.menu')
<script type="text/javascript">
	$(document).on('click', '.add-to-favorite-button', function(){
        var id = $(this).data('id');

        $('#product-block-' + id).hide(300, function(){
        	$(this).remove();

        	if($('.product-block').length == 0)
        	    $('.empty-note').removeClass('d-none');
        });

        

    });
</script>
<div class="container-fluid mt-3">
	<div class="row m-0" style="" id="products-list">
		@include('layouts.site.cards.products', ['items' => $products])
		<div class="col-12 text-center empty-note mt-5 @if($products->count() > 0) d-none @endif">
			<h2 class="block-title">@lang('Empty')</h2>
		</div>
	</div>
</div>

@endsection