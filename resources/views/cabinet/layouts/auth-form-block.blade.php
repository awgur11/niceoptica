<style type="text/css">
	#auth-user-form-block{
		padding: 40px 32px;
		border: 1px solid #dcdcdc;
	}
	#auth-user-form-block h4{
		font-family: Nunito Sans;
        font-size: 24px;
        font-style: normal;
        font-weight: 400;
        line-height: 29px;
        margin-bottom: 30px;
        color: #202020;
	}
	#auth-user-form-block h5{
		font-family: Nunito Sans;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 22px;
        color: #202020;
	}
</style>
<div id="auth-user-form-block">
	<h4>@lang('Log in to speed up the order')</h4>
    <form action="{{ route('user.login') }}" method="POST">
       	@csrf
	    <div class="row">
		    <div class="col-md-4">
			    <div class="form-group">
                    <label for='name'>@lang('Email'):</label>
                    <input type="email" class="form-control" name="email"  maxlength="50" placeholder="" required="true">
                </div>
		    </div>
	        <div class="col-md-4">
			    <div class="form-group">
                    <label for='password'>@lang('Password'):</label>
                    <input type="password" class="form-control" name="password"  maxlength="50" placeholder="" required="true">
                </div>
		    </div>
			<div class="col-md-4" style="padding-top: 32px;">
                <input type="submit" style="padding:17px" class="btn btn-primary btn-block"   maxlength="50" placeholder="" value="@lang('Login')">
   			</div>
	    </div>
	</form>

	<div class="row mb-2 mt-3">
		<div class="col-12">
			<h5>@lang('Or log in using social networks')</h5>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-5 col-md-6">
			<div class="socialite-button @auth @if(auth()->user()->facebook_id != null) active  @endif @endauth">
				<img src="/images/facebook.png" alt="">
				<div class="pl-2">
		@auth 
			@if(auth()->user()->facebook_id != null)
				    {{ auth()->user()->name }}<br/>
				    <a href="{{ route('user.untie', ['soc' => 'facebook']) }}">@lang('untie')</a>
			@else
				    <a href="{{ route('redirect.to.facebook') }}">
      				    @lang('Auth with facebook')
      				</a>
			@endif 
		@else
				    <a href="{{ route('redirect.to.facebook') }}">
      				    @lang('Auth with facebook')
      				</a>
		@endauth
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="socialite-button @auth @if(auth()->user()->google_id != null) active  @endif @endauth">
				<img src="/images/google.png" alt="">
				<div class="pl-2">
		@auth 
			@if(auth()->user()->google_id != null)
				{{ auth()->user()->name }}<br/>
				    <a href="{{ route('user.untie', ['soc' => 'google']) }}">@lang('untie')</a>
			@else
				    <a href="{{ route('redirect.to.google') }}">
				        @lang('Auth with google')
				    </a>
			@endif 
		@else
				    <a href="{{ route('redirect.to.google') }}">
				        @lang('Auth with google')
				    </a>
	    @endauth
				</div>				    
			</div>
		</div>
	</div>
</div>