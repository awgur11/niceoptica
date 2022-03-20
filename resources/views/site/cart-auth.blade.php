@extends('site.base')

@section('content')

<div class="container-fluid" >
	<div class="row mb-3">
		<div class="col-12" style="overflow: hidden;">
			@include('layouts.site.path-block')
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<h1 class="catalog-title">@lang('Authorization')</h1>
		</div>
	</div>
</div>

<div class="container-fluid" >
	<div class="row mb-3">
		<div class="col-lg-6">
			@include('cabinet.layouts.auth-form-block')
		    <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-block mt-3">@lang('Continue without authorization')</a>
		</div>
		<div class="col-md-12 col-lg-5 pr-lg-0 mt-3 mt-lg-0">
			@include('layouts.site.cart.cart-content-block-grey')		
		</div>
	</div>
</div>





@endsection