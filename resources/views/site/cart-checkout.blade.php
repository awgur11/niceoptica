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
			<h1 class="catalog-title">@lang('Checkout')</h1>
		</div>
	</div>
</div>
<style type="text/css">
	#user-guest-data-block{
		padding: 40px 32px;
		border: 1px solid #dcdcdc;
	}
	#user-guest-data-block h4{
		font-family: Nunito Sans;
        font-size: 24px;
        font-style: normal;
        font-weight: 400;
        line-height: 29px;
        margin-bottom: 30px;
        color: #202020;
	}
	#have-an-account{
		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 19px;
        color: #898989;
        text-decoration: underline;
        display: block;
        margin-bottom: 30px;
	}

#kalk-second-stage-block .form-check {
    padding-left: 30px;

}
</style>
<script type="text/javascript">
	$(document).on('click', '#register-me', function(){
		if($(this).prop('checked'))
			$('#email-checkout-input').attr('required', 'required');
		else
			$('#email-checkout-input').attr('required', false);


	})
</script>
<form action="{{ route('order.store') }}" method="POST" onkeydown="return event.key != 'Enter';"  class="validate-form-ajax">
    @csrf
<div class="container-fluid">
	<div class="row">
    	<div class="col-md-6 col-lg-7">
    @guest
    		<div id="user-guest-data-block" class="mb-3">
    			<div class="d-flex justify-content-between align-items-center">
    				<h4>@lang('Contact details')</h4>
    			
    				<a href="{{ route('cart.auth') }}" id="have-an-account">@lang('Have an account')?</a>

    			</div>
    			<div class="mb-3" style="position: relative;">
    				<input type="checkbox" id="register-me" class="custom" name="register_me">
    				<label for="register-me">@lang('Register me on the site')</label>
    			</div>
    			<div class="row m-0">
    				<div class="col-md-6 mt-3 pl-0">
    					<div class="form-group">
                            <label for='name'>@lang('Name'):</label>
                            <input type="text" class="form-control" name="name"  maxlength="50" placeholder="" required>
                            <span class="d-none text-danger input-error input-error-name"></span>
                        </div>
    				</div>
    				<div class="col-md-6 mt-3 pl-0">
    					<div class="form-group">
                            <label for='name'>@lang('Last name'):</label>
                            <input type="text" class="form-control" name="lastname"  maxlength="50" placeholder="">
                        </div>
    				</div>
    				<div class="col-md-6 mt-3 pl-0">
    					<div class="form-group">
                            <label for='phone'>@lang('Email')</label>
                            <input type="email" id="email-checkout-input" class="form-control" name="email"  maxlength="50">
                        </div>
    				</div>
    				<div class="col-md-6 mt-3 pl-0">
    					<div class="form-group">
                            <label for='phone'>@lang('Phone number'):</label>
                            <input type="text" class="form-control send-phone" name="phone"  maxlength="50" placeholder="" >
                            <span class="d-none text-danger input-error input-error-phone"></span>
                        </div>
    				</div>
    			</div>    			
    		</div>
        @else
<style type="text/css">
    #user-auth-data-block{
        background: #F8F8F8;
        padding: 40px 32px;
        margin-bottom: 15px;
    }
    #user-auth-data-block .uad-name,
    #user-auth-data-block .uad-value{
        font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        line-height: 19px;
    }
    #user-auth-data-block .uad-name{
        font-weight: 300;
        color: #898989;
    }
    #user-auth-data-block .uad-value{
        font-weight: 700;
        color: #202020;
    }
</style>
            <div class="mb-3" id="user-auth-data-block">
                <div class="row justify-content-between align-items-center">
                    <div class="col-6">
                        <h4>@lang('Your data')</h4>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('cabinet.user.data') }}"><i class="icon-Pencil"></i> @lang('Edit')</a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="row">
                        <div class="uad-name col-6 mt-2 pl-0">@lang('Name'):</div>
                        <div class="uad-value col-6 mt-2">{{ auth()->user()->name }}</div>

                        <div class="uad-name col-6 mt-2 pl-0">@lang('Last name'):</div>
                        <div class="uad-value col-6 mt-2">{{ auth()->user()->lastname }}</div>

                        <div class="uad-name col-6 mt-2 pl-0">@lang('Email'):</div>
                        <div class="uad-value col-6 mt-2">{{ auth()->user()->email }}</div>

                        <div class="uad-name col-6 mt-2 pl-0">@lang('Phone number'):</div>
                        <div class="uad-value col-6 mt-2">{{ auth()->user()->phone }}</div>

                    </div>
                </div>
            </div>
        @endguest

    	@auth
    	    @if(auth()->user()->deliveries->count() > 0)
    	    <div class="col-12">
    	       @include('cabinet.layouts.deliveries-items', ['deliveries' => auth()->user()->deliveries])
    	    </div>
    	    @else
    	    <div class="row m-0">
    			@include('cabinet.layouts.add-delivery-block')
    		</div>
    	    @endif
    	@else
    	    <div class="row m-0 mb-3">
    			@include('cabinet.layouts.add-delivery-block')
    		</div>
    	@endauth
            <div class="row m-0" id="payment-block">
                <div class="col-12 mb-5">
                    <h4>@lang('Payment')</h4>
                </div>
                <div class="col-6">
                    <input type="radio" id="payment-0"  class="select-main"  checked name="payment" value="0">
                    <label for="payment-0">@lang('Upon receipt')</label>
                </div>
                <div class="col-6">
                    <input type="radio" id="payment-1"  class="select-main" name="payment" value="1">
                    <label for="payment-1">@lang('Online')</label>                    
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button class="btn btn-primary btn-block" id="make-order-button">
                        @lang('Make order')
                    </button>
                </div>
            </div>
		</div>
		<div class="col-md-6 col-lg-5 pr-md-0">
			@include('layouts.site.cart.cart-content-block-grey')
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
    function ifDeliveryOptionSelected()
    {
        if($('#select-block-delivery-option').length > 0 && $('#select-block-delivery-option input:checked').length == 0)
            $('#make-order-button').addClass('d-none');
        else
            $('#make-order-button').removeClass('d-none');

    }
    $(function(){
        ifDeliveryOptionSelected();
    });
    $(document).on('change', '#select-block-delivery-option input:checked', function(){
        ifDeliveryOptionSelected();
    })
</script>
<style type="text/css">
    #payment-block{
        background: #FFFFFF;
        border: 1px solid #DCDCDC;
        padding: 40px 32px;
    }
    #payment-block h4{
        font-family: Nunito Sans;
        font-size: 24px;
        font-style: normal;
        font-weight: 400;
        line-height: 29px;
    }
</style>





@endsection