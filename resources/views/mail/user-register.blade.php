<div style='width: 100%; min-height: 100vh; font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"'>
	<div style=" width: 600px; max-width: 100%; margin: auto;">

	@include('layouts.site.mail.header')

	<div style="padding: 5px 20px;  color: #333; font-weight: 600; text-align: center;  margin: 20px 0;">
		<h2>@lang('Dear') {{ $user->name }}<br/>
		@lang('Thanks for registering on our website')</h2>
	</div>

	<div style="padding: 40px 20px; background-color: #F1F4FF;border: 1px solid #2C50F2;">
		<h3 style="margin-bottom: 20px; text-align: center; ">@lang('Your data for authorization on the site'):</h3>
		<table>
			<tr>
				<td style="padding:10px; color:#2C50F2; border-bottom: 1px solid #2C50F2;;">
					<b>@lang('Email')</b>
				</td>
				<td style="padding:10px;  border-bottom: 1px solid #2C50F2;;">
					<i>{{ $user->email }}</i>
				</td>
			</tr>
			<tr>
				<td style="padding:10px; color:#2C50F2;">
					<b>@lang('Your password')</b>
				</td>
				<td>
					<i>{{ $user->real_password }}</i>
				</td>
			</tr>
		</table>
	</div>

	

	


	@include('layouts.site.mail.footer')

    </div>
</div>