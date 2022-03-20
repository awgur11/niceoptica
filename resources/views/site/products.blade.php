@extends('site.base')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			@include('layouts.site.path-block')
		</div>
	</div> 
	<div class="row">
		<div class="col-12">
			<h1 class="catalog-title">{{ $catalog->language->title }}</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-9 col-lg-10 d-md-block d-none">
			@include('layouts.site.store.filters-select-block')
		</div>
		<div class="col-6 d-md-none">
			<div class="btn btn-outline-dark custom btn-block d-flex justify-content-between align-items-center sorting-mobile-button">
				@lang('Sorting') <i class="icon-Pillow-Chart---3"></i>
			</div>
			
		</div>
		<div class="col-md-3 col-lg-2 col-6">
			<div class="btn btn-outline-dark custom btn-block d-flex justify-content-between align-items-center all-filters-button">
				@lang('All filters') <i class="icon-Add"></i>
			</div>
		</div>
	</div>
 
	<div class="row">
		<div class="col-12">
			@include('layouts.site.store.cancel-filters-block')
		</div>
	</div> 
	<div class="row">
		@include('layouts.site.store.order-block')
	</div>
</div>
<style type="text/css">

</style>
<div class="container-fluid mt-3">
	<div class="row m-0" style="" id="items-uploaded-list">
		@include('layouts.site.cards.products', ['items' => $products])
	</div>
	<div class="row mt-5 justify-content-center">
		<div id="pagination-block">
			<div id="pagination-numbers">
				<span id="uploaded-items-numbers">18</span> @lang('from') {{ $products_count }} @lang('Productss')
			</div>
		</div>
		<div class="col-12 my-3 d-flex justify-content-center">
			<div id="progress-bar-items"></div>
		</div>
		<div class="col-12 text-center mt-3">
		    <div class="btn btn-primary download-items-ajax-button" data-offset="0" data-step="18" data-total="{{ $products_count }}" data-url="{!! url()->full() == url()->current() ? url()->full().'?' : url()->full().'&' !!}">
			    @lang('Show more')			
		    </div>
	    </div>
	</div>
</div>


<div class="container">
	<div class="row">
		<div class="col-12 page-content">
			{!! $catalog->language->content !!}
		</div>
	</div>
</div>

@endsection