<div style="padding: 5px 20px; border: 1px solid #f3f3f3; color: #333; font-weight: 600; ">
		<p><b>@lang('Name')</b>: <i>{{ $user->name ?? null }} {{ $user->middlename ?? null }} {{ $user->lastname ?? null }}</i></p>
		<p><b>Email</b>: <i>{{ $user->email }}</i></p>
		<p><b>@lang('Phone number')</b>: <i>{{ $user->phone }}</i></p>
	</div>