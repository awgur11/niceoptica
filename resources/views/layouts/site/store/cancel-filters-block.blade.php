<style type="text/css">
	.cfb-item{
		font-family: Nunito Sans;
font-size: 14px;
font-style: normal;
font-weight: 300;
line-height: 17px;
letter-spacing: 0px;
text-align: left;
padding: 10px 15px;
color: #202020;
background: #F6F6F6;
margin-right: 12px;
display: inline-block;
	}
.cfb-item-title, .cfb-item-icon{
	display: inline-block;
}
.cfb-item-icon{
	margin-left: 15px;
	transform: translateY(2px);
}

</style>
<div id="cancel-filters-block" class="my-3 d-md-flex ">
@foreach($cancel_filter_buttons as $cf)
    <a href="{{ $cf['link'] }}" class="cfb-item mt-1">
   	    <div class="cfb-item-title">{{ $cf['fvalue'] }}</div>
   	    <div class="cfb-item-icon"><i class="icon-Cross"></i></div>
    </a>
@endforeach
@if(count($cancel_filter_buttons) > 1)
    <a href="{{ url()->current() }}" class="cfb-item mt-1">
   	    <div class="cfb-item-title">@lang('Clean out')</div>
   	    <div class="cfb-item-icon"><i class="icon-Cross"></i></div>
   </a>
@endif
</div>