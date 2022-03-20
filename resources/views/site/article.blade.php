@extends('site.base')

@section('content')
<style type="text/css">
	#art-preview-block{
		height: 550px;
		position: relative;
	}
	.sub-block{
		width: 100%;
		height: 100%;
		overflow: hidden;
	}
	#art-preview-block:before{
		position: absolute;
		content: "";
		width: 100%;
		height: 100%;
		background: #F8F8F8;
		left: -150px;
		top: -100px;
		z-index: -1;
	}
	#art-preview-block img{
		width: 100%;
		height: auto;
	}
	#art-container{
		margin-top: 128px;
	}
	#art-title{
		font-family: Nunito Sans;
        font-size: 40px;
        font-style: normal;
        font-weight: 400;
        line-height: 48px;
        color: #202020;
        margin-top: 29px;

	}
	#art-date{
		font-family: Nunito Sans;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 27px;
        color: #898989;
        margin-top: 16px;

	}
	
@media screen and (max-width: 820px) {
	#art-preview-block{
		height: 350px;
	}
	
}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			@include('layouts.site.path-block')
		</div>
	</div> 
</div>
<div class="container" id="art-container">
	<div class="row">
		<div class="col-lg-7 col-md-6" id="art-preview-block">
			<div class="sub-block">
			    <img src="{{$page->tree_preview}}" alt="">
			</div>
		</div>
		<div class="col-md-6 col-lg-5 mt-3 mt-md-0">
			<a href="{{ route('page', ['alt_title' => $menu_pages->where('id', 49)->first()->alt_title, 'category_id' => $page->category_id]) }}"># {{ $page->category->language->title }}</a>
			<h1 id="art-title">
				{{ $page->language->title }}
			</h1>
			<p id="art-date">
				{{ $page->created_at_custom }}
			</p>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-12 page-content">
			{!! $page->language->content !!}
		</div>
	</div>
</div>
<div class="container-fluid" style="margin-top: 50px;">
	<div class="row">
		@include('layouts.site.cards.articles', ['items' => $articles])		
	</div>
</div>

@endsection