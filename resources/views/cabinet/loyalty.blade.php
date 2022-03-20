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
			<h1 class="catalog-title">@lang('Loyalty card')</h1>
		</div>
	</div>
</div>

@include('cabinet.layouts.menu')
<style type="text/css">
	#loy-statistic-block{
		padding: 32px;
		background: #F8F8F8;
	}
	#loy-statistic-block h3{
		font-family: Nunito Sans;
        font-size: 24px;
        font-style: normal;
        font-weight: 400;
        line-height: 29px;
        margin-bottom: 17px;
        color: #202020;
	}
	#loy-statistic-block .table td{
		border-top: none;
		padding: 6px 0;
	}
	#loy-statistic-block .table tr td:first-child{
		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 300;
        line-height: 19px;
        color: #898989;

	}
	#loy-statistic-block .table tr td:nth-child(2){
		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 600;
        line-height: 19px;
   }
   .loy-block{
   	    padding: 24px;
   	    border: 1px solid #dcdcdc;
   }
   .loy-percent{
   	    font-family: Nunito Sans;
        font-size: 48px;
        font-style: normal;
        font-weight: 700;
        line-height: 58px;
        color: #898989;
        margin-right: 24px;
    }
    .loy-title{
    	font-family: Nunito Sans;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 22px;
        color: #202020;
    }
    .loy-block.active{
    	background: #D7DEFF;
        border: 1px solid #2C50F2;
    }
    .loy-block.active .loy-percent{
    	color: #2C50F2;
    }
</style>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-4">
			<div id="loy-statistic-block">
				<h3>@lang('My stats')</h3>
				<table class="table">
					<tr>
						<td>@lang('Made orders'):</td>
						<td>{{ $orders_count }}</td>
					</tr>
					<tr>
						<td>@lang('For the amount'):</td>
						<td>{{ $orders_sum }} uah</td>
					</tr>
					<tr>
						<td>@lang('Member discount'):</td>
						<td>{{ $loyalty_percent }}%</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="row">
	@foreach($loyalties as $loyalty)
	             <div class="loy-block col-md-6 d-flex align-items-center @if($loyalty->nol1 == $loyalty_percent) active @endif">
	             	<div class="loy-percent">{{ $loyalty->nol1 }}%</div>
	             	<div class="loy-title">{{ $loyalty->language->title }}</div>
	             </div>
	@endforeach
			</div>
		</div>
	</div>
</div>

@endsection