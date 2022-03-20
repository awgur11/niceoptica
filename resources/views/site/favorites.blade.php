@extends('site.base')

@section('content')

<div class="container" style=" margin-bottom:50px;">
	<div class="row">
		<div class="col-12">
			<h1 class="page-title">@lang('Favorites')</h1>
		</div>
	</div>
</div> 
@if(count($products) == 0)
<div class="container">
	<div class="row">
		<div class="col-12">
			<h2 class="block-title">@lang('Empty')</h2>
		</div>
	</div>
</div>
@else
<div class="container">
	<div class="row">
		@include('layouts.site.cards.products', ['items' => $products])
	</div>
</div>
@endif

@endsection