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
			<h1 class="catalog-title">{{ $page->language->title }}</h1>
		</div>
	</div>
</div>
<style type="text/css">
	.cat-item{
		padding: 17px 18px;
		font-family: Nunito Sans;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 17px;
        display: inline-block;
        background: #F1F4FF;
        margin-right: 16px;
        color: #202020;
        border: 1px solid #fff;

	}
	.cat-item.active{
		background: #D7DEFF;
		border: 1px solid #2C50F2;

	}
</style>
<div class="container-fluid my-4">
	<div class="row">
		<div class="col-12">
			<a href="{{ url()->current() }}" class="cat-item @if(!app('request')->has('category_id')) active @endif">
	         	@lang('All news')
	        </a>
	@foreach($categories as $cat)
	         <a href="{{ url()->current().'?category_id='.$cat->id }}" class="cat-item  @if(app('request')->input('category_id') == $cat->id) active @endif">
	         	{{ $cat->language->title }}
	         </a>
	@endforeach
		</div>
	</div>
</div>
<div class="container-fluid my-4">
	<div class="row" id="items-uploaded-list">
		@include('layouts.site.cards.articles', ['items' => $articles])

	</div>
</div>
<div class="container-fluid">
	<div class="row mt-5 justify-content-center">
		<div id="pagination-block">
			<div id="pagination-numbers">
				<span id="uploaded-items-numbers">{{ $count > 18 ? 18 : $count }}</span> @lang('from') {{ $count }} @lang('Newss')
			</div>
		</div>
		<div class="col-12 my-3 d-flex justify-content-center">
			<div id="progress-bar-items"></div>
		</div>
		<div class="col-12 text-center mt-3 @if($count < 19) d-none @endif">
		    <div class="btn btn-primary download-items-ajax-button" data-offset="0" data-step="1" data-total="{{ $count }}" data-url="{!! url()->full() == url()->current() ? url()->full().'?' : url()->full().'&' !!}">
			    @lang('Show more')			
		    </div>
	    </div>
	</div>
</div>

@endsection