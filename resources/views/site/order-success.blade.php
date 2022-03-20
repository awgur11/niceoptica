@extends('site.base')

@section('content')
<style type="text/css">
    .success-block{
    	border: 1px solid #dcdcdc; 
    	padding: 40px;
    }
	.success-block h4{
		font-family: Nunito Sans;
        font-size: 32px;
        font-style: normal;
        font-weight: 400;
        line-height: 38px;
        color: #202020;
	}
	.success-block h4 span{
		text-decoration: underline;
		color: #2C50F2;
	}
	.success-block p{
		font-family: Nunito Sans;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 27px;
        color: #5E5E5E;
	}
</style>
<div class="container" style=" margin-top: 200px; margin-bottom: 200px; ">
	<div class="row align-items-center justify-content-center" >
		<div class="col-md-12 col-lg-6 success-block" style="">
			<h4>@lang('Your order') <span>№{{ $order_id }}</span> @lang('created and sent for processing').</h4>
			<p class="my-5">@lang('The manager will contact you during the day from 10:00 to 21:00')</p>
			<div class="row m-0 justify-content-between">
				<div class="col-md-6 text-md-left text-center p-0">
			        <a href="{{ route('cabinet.user.orders') }}" class="btn btn-primary" style="width: auto!important;">@lang('View order details')</a>
			    </div>
			    <div class="col-md-6 mt-3 mt-md-0 text-md-right text-center p-0">
    		        <a href="{{ route('index') }}" class="btn btn-outline-primary">@lang('Back to home page')</a>
			    </div>
	
		    </div>
		</div>
	</div>
</div>

@endsection