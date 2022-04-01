<style type="text/css">
    #authModal{
        z-index: 1005000;
    }
    .modal-dialog{
        margin-top: 10vh;
    }
    #authModal #modal-body-login-body,
    #authModal #modal-body-register-body{
        padding: 10px 71px 0;

    }
    #authModal .modal-title{
        font-family: Nunito Sans;
        font-size: 32px;
        text-align: center;
        font-style: normal;
        font-weight: 400;
        line-height: 38px;
        letter-spacing: 0px;
        text-align: center;
        margin-bottom: 24px;
    }
    #authModal .modal-header{
        padding: 10px 10px 0 0 ;
    }
    #authModal .modal-content{
        width: 497px;
        border-radius: 0;
    }
    #authModal p{
        font-family: Nunito Sans;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 22px;
        letter-spacing: 0px;
        text-align: left;
        margin-top: 45px;
        padding-top: 25px;
        border-top: 1px solid #dcdcdc;
        
    }
    .auth-modal-sb{
        display: inline-block;
        width: 56px;
        height: 56px;
        margin: 5.5px;
        border: 1px solid #dcdcdc;
        text-align: center;
        padding: 13px 13px 16px;

    }
    .auth-modal-sb img{
        height: 30px;
    }
    .modal-register-button,
    .modal-login-button{
        cursor: pointer;
    }

</style>
<script type="text/javascript">
    $(document).on('click', '.modal-register-button', function(){
        $('#modal-body-login').addClass('d-none');
        $('#modal-body-register').removeClass('d-none');
    });
    $(document).on('click', '.modal-login-button', function(){
        $('#modal-body-login').removeClass('d-none');
        $('#modal-body-register').addClass('d-none');
    });

</script>


<!-- The Modal -->
<div class="modal" id="authModal" style="">
    <div class="modal-dialog">
        <div class="modal-content">

      <!-- Modal Header -->
            <div class="modal-header" style="border-bottom: none;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

      <!-- Modal body -->
            <div class="modal-body p-0">
                <div id="modal-body-login">
                <div id="modal-body-login-body">

                    <h4 class="modal-title text-center">@lang('Login to your personal account')</h4>
                    <form action="{{ route('user.login') }}" method="POST" class="validate-form-ajax">
                        @csrf
                        <div class="form-group">
                            <label for='name'>@lang('Email'):</label>
                            <input type="email" class="form-control" name="email"  maxlength="50" placeholder="" required="true">
                            <span class="d-none text-danger input-error input-error-email"></span>
                            <div class="text-right">
                                <a href="{{ route('password.request') }}">@lang('Forget password')?</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for='password'>@lang('Password'):</label>
                            <input type="password" class="form-control" name="password"  maxlength="50" placeholder="" required="true">
                            <span class="d-none text-danger input-error input-error-password"></span>
                        </div>
                        <input type="submit" style="padding:17px" class="btn btn-primary btn-block"   maxlength="50" placeholder="" value="@lang('Login')">
                    </form>

                    <p class=" text-center">@lang('Or log in using social networks')</p>
                    <div class="my-2 text-center">
                        <a href="{{ route('redirect.to.facebook') }}" class="auth-modal-sb">
                            <img src="/images/facebook.png" alt="">
                        </a>
                        <a href="{{ route('redirect.to.google') }}" class="auth-modal-sb">
                            <img src="/images/google.png" alt="" >
                        </a>
                    </div>
                </div>
                <div class="p-4 bg-light mt-3 text-center" id="modal-body-login-footer">
                    @lang('Didnt register')? <div class="d-inline-block modal-register-button text-primary">@lang('Register')</div>
                        
                </div>
                </div>

                <div id="modal-body-register" class="d-none">
                <div id="modal-body-register-body">

                    <h4 class="modal-title text-center">@lang('Registration')</h4>
                    <form action="{{ route('user.register') }}" class="validate-form-ajax" method="POST" id="register-form">
                        @csrf
                        <div class="form-group">
                            <label for='name'>@lang('Name'):</label>
                            <input type="text" class="form-control" name="name"  maxlength="50" placeholder="">
                            <span class="d-none text-danger input-error input-error-name"></span>
                        </div>
                        <div class="form-group">
                            <label for='name'>@lang('Email'):</label>
                            <input type="email" class="form-control" name="email"  maxlength="50" placeholder="">
                            <span class="d-none text-danger input-error input-error-email"></span>
                        </div>
                        <div class="form-group">
                            <label for='password'>@lang('Password'):</label>
                            <input type="password" class="form-control" name="password"  maxlength="50" placeholder="">
                            <span class="d-none text-danger input-error input-error-password"></span>
                        </div>
                        <div class="form-group">
                            <label for='password'>@lang('Confirm password'):</label>
                            <input type="password" class="form-control" name="password_confirmation"  maxlength="50" placeholder="">
                            <span class="d-none text-danger input-error input-error-password_confirmation"></span>
                        </div>
                        <input type="submit" style="padding:17px" class="btn btn-primary btn-block"   maxlength="50" placeholder="" value="@lang('Register')">
                    </form>
                    <div style="position: relative;" class="mt-2">
                        <input type="checkbox" id="policy-check" checked class="custom" name="register_me" required>
                        <label for="policy-check">@lang('I agree to the processing of personal data'). {!! $policy_link !!}</label>
                    </div>


                    <p class=" text-center">Or log in using social networks</p>
                    <div class="my-2 text-center">
                        <a href="{{ route('redirect.to.facebook') }}" class="auth-modal-sb">
                            <img src="/images/facebook.png" alt="">
                        </a>
                        <a href="{{ route('redirect.to.google') }}" class="auth-modal-sb">
                            <img src="/images/google.png" alt="" >
                        </a>
                    </div>
                </div>
                <div class="p-4 bg-light mt-3 text-center" id="modal-body-register-footer">
                    @lang("Already registered")? <div class="d-inline-block modal-login-button text-primary">@lang('Login to your account')</div>
                        
                </div>
                </div>

            </div>
        </div>

    </div>
</div>