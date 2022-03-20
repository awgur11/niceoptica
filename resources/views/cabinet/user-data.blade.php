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
			<h1 class="catalog-title">@lang('Personal Area')</h1>
		</div>
	</div>
</div>

@include('cabinet.layouts.menu')

<div class="container-fluid">
	<div class="row">
@auth
        <div class="col-12 text-right">
        	<div style="display: inline-block; font-size: 20px; font-family: Nunito Sans; cursor: pointer;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="fas fa-sign-out-alt"></i> 
        		@lang('Logout')
            </div>

        </div>
    	<div class="col-md-6 col-lg-4">
    <form method="POST" action="{{ route('cabinet.change.user.data') }}">
		@csrf 
			<div class="form-group">
                <label for='name'>@lang('Name'):</label>
                <input type="text" class="form-control" name="name"  maxlength="50" placeholder="" required="true" value="{{ auth()->user()->name ?? null }}">
            </div>
	    	<div class="form-group">
                <label for='phone'>@lang('Phone number'):</label>
                <input type="text" class="form-control send-phone" name="phone"  maxlength="50" placeholder="" value="{{ auth()->user()->phone ?? null }}">
            </div>
            <div class="form-group">
                <label for='phone'>@lang('Email')</label>
                <input type="email" class="form-control" name="email"  maxlength="50" required="" value="{{ auth()->user()->email ?? null }}">
            </div>
            <div class="mt-5 form-group mb-0">
            	<button class="btn btn-primary btn-block">@lang('Save')</button>
            </div>
    </form>
		</div>
		<div class="col-md-6 col-lg-4">
	<form method="POST" action="{{ route('cabinet.change.password') }}">
		@csrf
			<div class="form-group">
                <label for='old_password'>@lang('Old password'):</label>
                <input type="password" class="form-control" name="old_password"  maxlength="50" placeholder="" required>
            </div>
		    <div class="form-group">
                <label for='phone'>@lang('New password'):</label>
                <input type="password" class="form-control" name="new_password"  maxlength="50" placeholder="" required>
            </div>
            <div class="form-group">
                <label for='repeat_password'>@lang('Repeat password')</label>
                <input type="password" class="form-control" name="repeat_password"  maxlength="50" required>
			</div>
			<div class="mt-5 form-group mb-0">
            	<button class="btn btn-primary btn-block">@lang('Change password')</button>
            </div>
    </form>
		</div>
		<div class="col-md-6 col-lg-4 pr-md-0" style="padding-top: 28px;">
			<div id="socialites-block">
				<h3 class="block-title">@lang('Link to social networks')</h3>
			
			    <div class="socialite-button @auth @if(auth()->user()->facebook_id != null) active  @endif @endauth mt-5">
				    <img src="/images/facebook.png" alt="">
				    <div class="pl-2">
				    @auth 
				        @if(auth()->user()->facebook_id != null)
				            {{ auth()->user()->name }}<br/>
				            <a href="{{ route('user.untie', ['soc' => 'facebook']) }}">@lang('untie')</a>
				        @else
				           @lang('Auth with facebook')
				        @endif 
				    @else
				        @lang('Auth with facebook')
				    @endauth
				    </div>
			    </div>
			    <div class="socialite-button @auth @if(auth()->user()->google_id != null) active  @endif @endauth mt-5">
				    <img src="/images/google.png" alt="">
				    <div class="pl-2">
				    @auth 
				        @if(auth()->user()->google_id != null)
				            {{ auth()->user()->name }}<br/>
				            <a href="{{ route('user.untie', ['soc' => 'google']) }}">@lang('untie')</a>
				        @else
				           @lang('Auth with google')
				        @endif 
				    @else
				        @lang('Auth with google')
				    @endauth
				    </div>				    
			    </div>
			</div>
		</div>
	@else
	<div class="col-md-8 col-lg-6">
	    @include('cabinet.layouts.auth-form-block')
    </div>
	@endauth
	</div>
</div>
<style type="text/css">
    #socialites-block{
    	background: #F8F8F8;
    	height: 100%;
    	padding: 32px;
    }
	.socialite-button{
		display: flex;
		align-items: center;
		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 300;
        line-height: 19px;
        background: #fff;
        color: #202020;
        width: 238px;
	}
	.socialite-button img{
		padding: 15px;
		background: #fff;
	}
	.socialite-button.active{
		background: transparent;
	}
</style>



@endsection