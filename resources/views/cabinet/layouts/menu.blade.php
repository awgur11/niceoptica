<style type="text/css">
	#cm-block{
		
		border-bottom: 1px solid #dcdcdc;
		margin-bottom: 58px;
	}
	#cm-block .cm-item{
		font-family: Nunito Sans;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 22px;
        text-transform: uppercase;
        color: #202020;
        margin-right: 56px;
        white-space: nowrap;
        padding: 15px;
	}
	#cm-block .cm-item.active{
		position: relative;
	}
	#cm-block .cm-item.active:after{
		position: absolute;
		bottom: 0px;
		left: 15px;
		content: "";
		width: 70%;
		height: 3px;
		background: #2C50F2;
	}
	.disabled-link{
		pointer-events:none;
        opacity:0.6; 
	}
</style>
<div class="container-fluid" id="cm-block">
	<div class="row">
		<a href="{{ route('cabinet.user.data') }}" class="col-md cm-item @if(route('cabinet.user.data') == url()->current()) active @endif">@lang('Personal Area')</a>

		<a href="{{ route('cabinet.user.loyalty') }}" class="col-md cm-item @if(route('cabinet.user.loyalty') == url()->current()) active @endif">@lang('Loyalty card')</a>

		<a href="{{ route('cabinet.user.orders') }}" class="col-md cm-item @if(route('cabinet.user.orders') == url()->current()) active @endif @if(!auth()->check()) disabled-link @endif">@lang('Purchase history')</a>

		<a href="{{ route('cabinet.user.delivery') }}" class="col-md cm-item @if(route('cabinet.user.delivery') == url()->current()) active @endif @if(!auth()->check()) disabled-link @endif">@lang('Delivery addresses')</a>

		<a href="{{ route('cabinet.user.favorites') }}" class="col-md cm-item @if(route('cabinet.user.favorites') == url()->current()) active @endif">@lang('Favorites')</a>
	</div>
</div>
