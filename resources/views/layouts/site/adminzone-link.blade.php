<style type="text/css">
	#adminzone-link{
		position: fixed;
		z-index: 99;
		bottom: 0;
		left: 0;
		//transform: translateX(-50%);
		//opacity: 0.7;
		background: #f9f9f9;
		border: 1px solid #ddd;
		transition: 0.5s;
	}
	#adminzone-link:hover{
		opacity: 1;
	}
</style>
@if(auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->role == 'developer'))
  <a href="{{ route('admin.index') }}" class="btn btn-default btn-lg" id="adminzone-link">Админка</a>
@endif