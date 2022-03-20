@if($delivery != null)
<div style="padding:20px; background-color: #f3f3f3; border: 5px solid #fff; box-shadow: 0 0 1px #999; color: #333; font-weight: 600; ">
    <li>@lang('Delivery method'): {{ $delivery->option }}</li>
   	<li>@lang('City'): {{ $delivery->city }}</li>

	@if($delivery->warehouse != null)
	<li>@lang('Warehouse'): {{ $delivery->warehouse }}</li>
	@endif
	@if($delivery->street != null)
	<li>@lang('Street'): {{ $delivery->street }}</li>
	@endif
	@if($delivery->house != null)
	<li>@lang('House'): {{ $delivery->house }}</li>
	@endif
	@if($delivery->flat != null)
	<li>@lang('Flat'): {{ $delivery->flat }}</li>
	@endif
</div>
@endif