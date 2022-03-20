<div style='width: 100%; min-height: 100vh; font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"'>
	<div style=" width: 600px; max-width: 100%; margin: auto;">

	@include('layouts.site.mail.header')

	<div style="padding: 5px 20px;  color: #333; font-weight: 600; text-align: center;  margin: 20px 0;">
		<h2>@lang('Dear') {{ $user->name }}<br/>
		@lang('Thank you for placing an order on our website')</h2>
	</div>

	@include('layouts.site.mail.order')

	<div style="padding: 5px 20px;  color: #333; font-weight: 600; text-align: center;  margin: 20px 0;">
		<h3>@lang('Shipping Information')</h3>
	</div>

	@include('layouts.site.mail.delivery')


	@include('layouts.site.mail.footer')

    </div>
</div>

	