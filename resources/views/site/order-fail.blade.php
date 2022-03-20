@extends('site.base')

@section('content')

<div class="container" style="min-height: 70vh; margin-top: 200px;">
	<div class="row align-items-center" style="min-height: 70vh;">
		<div class="col-12">
			<h3>@lang('Sorry'),</h3>
			<h4>{{ $site_option['order_fail_note'] }}</h4>
		</div>
		<div class="col-12 text-center">
			<img src="{{ $site_option['order_fail_img']['two'] }}" alt="" style="max-width: 100%; width: 550px;">
		</div>
		<div class="col-12 text-center">
			<a href="{{ route('index') }}" class="btn btn-primary">@lang('Home')</a>
		</div>
	</div>
</div>

@endsection