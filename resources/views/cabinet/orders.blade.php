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
			<h1 class="catalog-title">@lang('Orders')</h1>
		</div>
	</div>
</div>

@include('cabinet.layouts.menu')
<style type="text/css">
	#orders-table thead td{
		font-family: Nunito Sans;
        font-size: 14px;
        font-style: normal;
        font-weight: 300;
        line-height: 17px;
        color: #898989;
        border-top: none;

	}
	#orders-table tr td:nth-child(2){
		width: 400px;
	}
	#orders-table tr.order-head td{
		font-family: Nunito Sans;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 22px;
        color: #202020;
	}
	.show-body-row{
		cursor: pointer;
		text-align: center;
	}
	.show-body-row.active{
		transform: rotate(180deg);
	}
	.order-body-row img{
		border: 1px solid #DCDCDC;
		background: #fff;
		max-width: 120px;
		max-height: 120px;
	}
	.o-pr-title{
		vertical-align: middle!important;
	}
	.o-pr-title h4{
		font-family: Nunito Sans;
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        
	}
	.params-block span:nth-child(2n){
		font-family: Nunito Sans;
        font-size: 14px;
        font-style: normal;
        font-weight: 300;
        line-height: 17px;
        color: #898989;
  	}
  	.params-block span:nth-child(2n+1){
  		font-family: Nunito Sans;
        font-size: 14px;
        font-style: normal;
        font-weight: 300;
        line-height: 17px;
        color: #202020;
  	}
  	.o-pr-count,
  	.o-pr-price{
  		vertical-align: middle!important;
  		font-family: Nunito Sans;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 22px;
  	}
  	.order-body-row td{
  		border-top: none;
  	}
  	.o-pr-delivery h4{
  		font-family: Nunito Sans;
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
  	}
  	.o-pr-delivery p{
  		font-family: Nunito Sans;
        font-size: 14px;
        font-style: normal;
        font-weight: 300;
        line-height: 17px;
        color: #898989;
  	}
  	.o-pr-delivery p b{
  		color: #202020;
  	}
</style>

<div class="container-fluid">
	<div class="row">
		<div class="col-12 table-responsive">
			<table class="table" id="orders-table">
				<thead>
					<tr>
						<td>@lang('Order date')</td>
						<td>@lang('Order number')</td>
						<td>@lang('Number of goods')</td>
						<td>@lang('Order sum')</td>
						<td>@lang('Order status')</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
    @foreach($orders as $order)
                    <tr class="order-head">
                    	<td>{{ date('d.m.Y', strtotime($order->created_at)) }}</td>
                    	<td>№ {{ $order->id }}</td>
                    	<td>{{ collect($order->order)->sum('count') }}</td>
                    	<td>{{ $order->sum }} грн(-{{ $order->loyalty_percent }}%)</td>
                    	<td>
        @if($order->status)
                             @lang('Paid')
        @else
                             @lang('Awaiting payment')
        @endif
                    	</td>
                    	<td>
                    		<div class="show-body-row" data-id="{{ $order->id }}"><i class="icon-Chevron---Down"></i></div>
                    	</td>
                    </tr>
            @foreach($order->order as $o)

                    <tr class="order-body-row-{{ $order->id }} order-body-row  d-none" >
                    	<td>
                    		<img src="{{ $o['product']['picture']['five_preview']  ?? null}}" alt="">
                    	</td>
                    	<td class="o-pr-title">
                    	    <h4>{{ $o['product']['language']['title'] ?? null }}</h4>
                    	    @if(is_array($o['params']))
                    	       <div class="params-block">
                    	       {!! str_replace('=', ':</span> <span>', '<span>'.implode('</span> <span>', $o['params']).'</span>') !!}
                    	       </div>
                    	    @endif

                    	</td>
                    	<td class="o-pr-count">{{ $o['count'] }}</td>
                    	<td class="o-pr-price">{{ $o['price'] }} грн</td>
                    	<td></td>
                    	<td></td>
                    </tr>
            @endforeach
            @if($order->delivery != null)
                    <tr class="order-body-row-{{ $order->id }} order-body-row d-none">
                    	<td>
                    		@if($order->delivery->option == 'Курьером новой почты' || $order->delivery->option == 'Отделение Новой Почты')
                    		<img src="/images/np-logo.png" alt="">
                    		@endif
                    	</td>
                    	<td class="o-pr-delivery">
                    		<h4>@lang('Delivery')</h4>
                    		<p>

                    			{{ $order->delivery->option }}<br>

                    			@if($order->delivery->option == __('Pickup'))
	        	                   <b>@lang('Address'):</b> {{ $site_option['address'] ?? null }}
                                @endif
                    			@if($order->delivery->city != null)
                    			   <b>@lang('City'):</b> {{ $order->delivery->city }}<br>
                    			@endif
                    			@if($order->delivery->warehouse != null)
                    			   <b>@lang('Warehouse'):</b> {{ $order->delivery->warehouse }}<br>
                    			@endif
   
                    			@if($order->delivery->street != null)
                    			   <b>@lang('Street'):</b> {{ $order->delivery->street }}<br>
                    			@endif
                    			@if($order->delivery->house != null)
                    			  <b> @lang('House'):</b> {{ $order->delivery->house }}<br>
                    			@endif
                    			@if($order->delivery->flat != null)
                    			  <b> @lang('Flat'):</b> {{ $order->delivery->flat }}<br>
                    			@endif
                    		</p>
                    	</td>
                    	<td></td>
                    	<td></td>
                    	<td></td>
                    	<td></td>
                    </tr>
        @endif
    @endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).on('click', '.show-body-row', function(){
		var id = $(this).data('id');

		$('.order-body-row-' + id).toggleClass('d-none');
		$(this).toggleClass('active');

	})
</script>
@endsection