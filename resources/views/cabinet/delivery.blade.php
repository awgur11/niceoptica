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
			<h1 class="catalog-title">@lang('Delivery')</h1>
		</div>
	</div>
</div>

@include('cabinet.layouts.menu')


<div class="container-fluid" >
	@include('cabinet.layouts.deliveries-items', ['deliveries' => $deliveries])
</div>

<div class="container-fluid">
	<div class="row">
        <form action="{{ route('delivery.store') }}" method="POST" style="width: 100%;" autocomplete="off">
	        @csrf
            @include('cabinet.layouts.add-delivery-block')
        </form>
    </div>
</div>





@endsection