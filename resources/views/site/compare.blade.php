@extends('site.base')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			@include('layouts.site.path-block')
		</div>
	</div> 
	<div class="row">
		<div class="col-12">
			<h1 class="catalog-title">@lang('Products in comparison')</h1>
		</div>
	</div>
</div>
<style type="text/css">
    #comp-table td{
    	padding: 15px;
    }
    #comp-table tr:nth-child(2n) td{
    	background-color:  #F8F8F8;
    }
	#pcb{
		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 300;
        line-height: 19px;
        color: #898989;
   	}
   	#pcb span{
   		color: #202020;
   	}
   	.pr-td{
   		width: 328px;
   		position: relative;
   	}
   	.remove-compare{
   		position: absolute;
   		top: 20px;
   		right: 20px;
   		color: #898989;
   		font-size: 20px;
   		cursor: pointer;
   	}
   	.compare-img-block{
   		min-height: 155px;
   	}
   	.pr-td img{
   		max-width: 100%;
   		border: 1px solid #dcdcdc;
   		background-color: #fff;
   		padding: 20px;
   	}
   	.prc-title{
   		font-family: Nunito Sans;
        font-size: 24px;
        font-style: normal;
        font-weight: 400;
        line-height: 29px;
        color: #202020;
        margin-top: 29px;
        height: 3.7em;
        overflow: hidden;
   	}
   	.prc-block-stars{
   		letter-spacing: 4px;
        color: #FFD02C;
   	}
   	.prc-block-price{
   		font-family: Nunito Sans;
        font-size: 20px;
        font-style: normal;
        font-weight: 600;
        line-height: 24px;
        color: #202020;
   	}
   	.prc-filter{
   		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: 19px;
        color: #202020;
   	}
   	.prc-fvalue{
   		font-family: Nunito Sans;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 22px;
        color: #202020;
   	}
   	.delete-all-compare{
   		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 19px;
        color: #898989;
        cursor: pointer;
        position: absolute;
        bottom: 35px;
        display: block;
   	}
   	.delete-all-compare:hover{
   		color: #d33;
   	}
@media screen and (max-width: 820px) {
	.prc-title{
		font-size: 16px;
		line-height: 20px;
		height: 4em;
	}
	
}
</style>
<div class="container-fluid mt-3">
	<div class="row">
		<div class="col-12 table-responsive">
			<table id="comp-table">
				<tr>
					<td style="height: 300px; width: 250px!important; vertical-align: top; position: relative;">
						<div class="select-block mr-1 mt-2 mt-md-0 col p-0" id="select-block">
			                <div class="select-block-title">@lang('Catalog')</div>
			                <div class="select-current-value-block d-flex justify-content-between">
				                <div class="select-current-value">{{ $catalog->language->title }}</div>
				                <div class="dd"><i class="icon-Chevron---Down"></i></div>
			                </div>
			                <div class="select-range-block">
	                    @foreach($catalogs as $c)
				                <input type="radio" id="srb-{{ $loop->index }}" class="srb-input srb-change-compare-catalog" name="catalog_id" value="{{ $c->id }}" @if($c->id == $catalog->id) checked @endif  data-id="{{ $catalog->id }}">
	                            <label class="srb-item d-flex justify-content-between m-0" for="srb-{{ $loop->index }}" >
	                                <div>{{ $c->language->title }}</div>
	                                <div><i class="icon-Tick"></i></div>
	                            </label>
	                    @endforeach
			                </div>
		                </div>
		                <p class="mt-4" id="pcb">@lang('Productss'): <span>{{ $products->count() }}</span></p>
		                <a href="{{ route('compare.delete.all') }}" class="delete-all-compare" id="dac-button">
		                	<i class="icon-Trash"></i> @lang('Clear the list')
		                </a>
					</td>
				@foreach($products as $product)
					<td class="pr-td pr-td-{{ $product->id }}">
						<div class="compare-img-block">
						    <img src="{{ $product->picture->four_preview }}" alt="">
					    </div>
						<div class="add-to-compare-button remove-compare " data-id="{{ $product->id }}"><i class="icon-Trash"></i> </div>
						<div class="prc-title">
							{{ $product->language->title }}
						</div>
						<div class="prc-block-stars mt-2">
			                <i class="fas fa-star"></i>
			                <i class="fas fa-star"></i>
			                <i class="fas fa-star"></i>
			                <i class="fas fa-star"></i>
			                <i class="fas fa-star"></i>
		                </div>
		                <div class="prc-block-price my-4">
		                	{{ $product->final_price }} uah
		                </div>
		                <div class="mb-4">
		                	<button data-toggle="modal" class="btn btn-primary show-cart-modal-button"  data-id="{{ $product->id }}" data-price="{{ $product->final_price }}"> @lang('Add to cart')</button>
		                </div>
					</td>
				@endforeach
				</tr>
			@foreach($catalog->filters as $filter)
				<tr>
					<td class="prc-filter">{{ $filter->language->title }}</td>
				@foreach($products as $pr)
				    <td class="prc-fvalue pr-td-{{ $pr->id }}">
    				    	<span>{{ $pr->fvalues->where('filter_id', $filter->id)->implode('language.title', '; ') }}</span>

				    </td>
				@endforeach
				</tr>
			@endforeach
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).on('click', '.srb-change-compare-catalog', function(){
		var catalog_id = $(this).val();

		window.location.href = "/compare/" + catalog_id;
	});
	$(document).on('click', '.add-to-compare-button', function(){
		var id = $(this).data('id');

		$('.pr-td-' + id).addClass('d-none');

	})
</script>

@endsection