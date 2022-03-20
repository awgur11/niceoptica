
<style type="text/css">
	.product-price-block{
		padding: 25px 0;
		border-top:1px solid #000;
		border-bottom:1px solid #000;
	//	border-radius: 0 0 20px 20px;
		font-size: 40px;
	//	background-color: #f8f5e9;
	}
	.product-price-new{
		color: #d33;
		font-family: fhand;
		position: relative;
		top: 10px;
		left: 40px;
	}
	.product-price-old .old_price-number{
		color: #999;
		text-decoration: line-through;
		font-family: fnormal;
	}
	.product-price-old .product-unit{
		text-decoration: none!important;
	}
	.product-price{
		color: #333;
		font-family: fhand;
		font-size: 30px;
		color: #f609c8;;
	//	text-shadow: 3px 3px 1px #ddd;
	}
	.product-unit{
		font-size: 18px;
		color: #333;
	}
	.pricelist-row label{
		font-family: fbold;
		color: #333;
	}
	.pricelist-row select{
		font-family: fnormal;
	}
	.pricelist-row select.form-control:focus{
		box-shadow: 0 0 2px #ffa400;
		border: 1px solid #ffa400;;
	}
	
</style> 
@if($product->pricelist->count() > 0)
<script type="text/javascript">
	$(function(){
		//console.log({!! $product->pricelist->toJson() !!});
		save_price_to_cart_button();
		save_cart_params();
		second_pricelist()
	});
	$(document).on('change', '#pricelist-first', function(){
		second_pricelist();
		get_price_from_pricelist();
		save_cart_params();
		change_picture_pricelist();
	});
	$(document).on('change', '#pricelist-second', function(){
		get_price_from_pricelist();
		save_cart_params();
		save_price_to_cart_button();
	});
	function save_price_to_cart_button()
	{
		var price = $('.price-for-cart').text();

		$('.add-to-cart-button').data('price', price);

	//	console.log($('.add-to-cart-button').data());
	}
	function save_cart_params()
	{
		var params = '';
		$('.pricelist-select').each(function(){
			params += $(this).data('title') + ': ' + $(this).children('option:selected').text() + ' ';
		});
		$('.filter-for-cart-select').each(function(){
			params += $(this).data('title') + ': ' + $(this).val() + ' ';
		});
	//	console.log(params);
		$('.add-to-cart-button').data('params', params);

	}
	function second_pricelist()
	{
		if($('#pricelist-second').length == 0)
			return false;

		var pricelist = {!! $product->pricelist->values()->toJson() !!},
		    option = '',
		    param_id_1 = $('#pricelist-first').val();

		    console.log(pricelist);

		$('#pricelist-second').html('');

		pricelist.forEach(function(el, index){
			if(el['param_id_1'] == param_id_1)
				option += '<option value="' + el['param_id_2'] + '">' + el.param_title_2 + '</option>';
		});
		$('#pricelist-second').append(option);
	}
	function get_price_from_pricelist()
	{
		var pricelist = {!! $product->pricelist->toJson() !!},
		    option = '',
		    param_id_1 = $('#pricelist-first').val(),
		    param_id_2 = $('#pricelist-second').val();

		if(param_id_2 == undefined)
		   	param_id_2 = 0;

	//	    console.log(param_id_1 + ' ' + param_id_2);

		pricelist.forEach(function(el, index){
			if(el['param_id_1'] == param_id_1 && el['param_id_2'] == param_id_2)
			{
				$('#price-number').text(el['price']);

				discount = $('#price-number').data('discount');

				if(discount != 0)
				{
    				final_price = Math.round(el['price']*(1 - discount*1/100)*100)/100;
    			    $('#price-number-new').text(final_price);
    			}

				return false;
			}
		});
		save_price_to_cart_button(); 
	}
	function change_picture_pricelist()
	{
		var preview = $('#pricelist-first').children('option:selected').data('preview');
		console.log(preview);

		if(preview != '' && preview != undefined)
		{
			$('#main-preview-img').attr('src', preview);
			$('.add-to-cart-button').data('preview', preview);
		}
	}
</script>
<div class="row pricelist-row">
	<div class="col-md-6">
		<div class="form-group">
		<label for="pricelist-first">{{ $product->pricelist[0]->param_filter_1 }}:</label>
		<select  id="pricelist-first" class="pricelist-select form-control" data-title="{{ $product->pricelist[0]->param_filter_1 }}">

	@foreach($product->pricelist->unique('param_id_1')->sortBy('param_position_1') as $pp)
	        <option value="{{ $pp->param_id_1 }}" data-preview="{{ $pp->preview ?? null }}">{{ $pp->param_title_1 }}</option>
    @endforeach()		
		</select>
	    </div>
	</div>
	@if($product->pricelist->unique('param_id_2')->count() > 1)
	<div class="col-md-6">
		<div class="form-group">
		<label for="pricelist-second">{{ $product->pricelist[0]->param_filter_2 }}:</label>
		<select  id="pricelist-second" class="pricelist-select form-control" data-title="{{ $product->pricelist[0]->param_filter_2 }}">
	    @foreach($product->pricelist->where('param_id_1', $product->pricelist->first()->param_id_1)->sortBy('param_position_2') as $pp)
	        <option value="{{ $pp->param_id_2 }}">{{ $pp->param_title_2 }}</option>
        @endforeach()		
		</select>
	    </div>
	</div>
	@endif
</div>
<div class="mt-2 mb-2">

</div>
@endif
<div class="product-price-block d-flex justify-content-around align-items-center">
@if($product->available == 3)
    <h5 class="text-danger">
    	@lang('not available')
    </h5>
@else	

		<button class="btn btn-outline-dark btn-lg add-to-cart-button" data-filters_for_order="" data-filters_for_cart="" data-product_id="{{ $product->id}}" data-params="" data-price="{{ $product->final_price }}" data-preview="{{ $product->picture->mini_preview ?? null }}"  data-session="{{ Session::getId() }}" src="{{ asset('images/cart-white.png') }}"><i class="ri-shopping-cart-2-line"></i> @lang('Buy')</button>
	
@endif
	<div class="product-price-block-price">
@if($product->discount == 0)
		<div class="product-price">
		    <span class=""></span> <span class="price-number price-for-cart" data-discount="{{ $product->discount ?? 0 }}" id="price-number">{{ $product->final_price }}</span> <span class="product-unit">грн</span>
		</div>
@else
        <div class="product-price-new">
		     <span class="price-number price-for-cart" id="price-number-new" data-discount="{{ $product->discount ?? 0 }}">{{ $product->final_price }}</span> <span class="product-unit">грн</span> 		    	
		</div>
		<div class="product-price-old">
		    <span class=""></span> <span class="old_price-number" id="price-number" data-discount="{{ $product->discount ?? 0 }}">{{ $product->price }}</span> <span class="product-unit">грн</span> 		    	
		</div>    
		  
@endif				
	</div>
</div>

