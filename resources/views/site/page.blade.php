@extends('site.base')

@section('content')
<style type="text/css">
	.add-bg{
		position: relative;
	}
	.add-bg:before{
		position: absolute;
		content: "";
		width: 100%;
		height: 100%;
		background: #F1F4FF;
		left: -300px;
		z-index: -1;

	}
		.left-blue-line-block{
		border: 1px solid #DCDCDC;
		border-left: 4px solid #2C50F2;;
		padding: 40px;
		margin-top: 32px;
	}
	.lbl-title{
		font-family: Nunito Sans;
        font-size: 24px;
        font-style: normal;
        font-weight: 400;
        line-height: 29px;
        margin-bottom: 16px;
	}
	.lbl-text-block ul{
		padding-left: 15px;
	}
	.lbl-icon-block{
		width: 64px;
		height: 64px;
		text-align: center;
		background: #f1f4ff;
		font-size: 24px;
		padding: 20px;
		color: #2C50F2;
	}
	.lbl-icon-block-img{
		padding: 5px;
		width: 64px;
		height: 64px;
		text-align: center;
		background: #f1f4ff;
	}
	.lbl-icon-block-img img{
		width: 100%;
	}
</style>
<div class="container-fluid" style="">
	<div class="row mb-3">
		<div class="col-12">
			@include('layouts.site.path-block')
		</div>
	</div>
</div>
<div class="container-fluid p-0" style="overflow: hidden;">
	<div class="container add-bg">
	<div class="row">
		<div class="col-lg-12 d-flex align-items-center justify-content-between" style="background: #F1F4FF;">
			<h1 class="page-title">
			    {!! $page->language->title !!}
		    </h1>
		@if($page->tree_preview != url('/storage/images/no-photo.jpg'))
		    <img src="{{ $page->tree_preview}}" alt="">
		@endif
		</div>
	</div>
    </div>
</div>

<div class="container mt-5">
	<div class="row">
		<div class="col-12 page-content">
			{!! $page->language->content !!}
		</div>
	</div>
</div>

@endsection