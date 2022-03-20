<div id="price-params-blocks" class="mb-3">
@if($product->different_eyes)
    <div id="different-eyes-buttons-block" class="mt-2 text-center text-md-left">
    	<div class="btn-group">
    	<div class="btn btn-info use different-eyes-button" data-eyes="@lang('Both eyes')">@lang('Same')</div>
    	<div class="btn btn-info different-eyes-button show-second" data-eyes="@lang('Left eye')">@lang('Different')</div>
        </div>
    </div>
@endif

<?php $pp_blocks_arr = $product->different_eyes == 0 ? ['first'] : ['first', 'second'];
 ?>

@foreach($pp_blocks_arr as $pba)
	<div id="product-params-block-{{ $pba }}" class="row m-0 mt-5 product-params-block @if(!$loop->first) d-none @else d-flex @endif" data-id="{{ $product->id }}" data-price="{{ $product->price }}" data-count="0" data-params="" data-sum="" data-pricelist_id="0" data-discount="{{ $product->discount ?? 0 }}">
    @if($product->different_eyes)
        <div class="product-params-row-title">
        	@if($loop->first)
    	        @lang('Both eyes')
    	    @else
    	        @lang('Right eye')
    	    @endif
        </div>
    @endif
    @foreach($product->for_cart_fvalues as $filter => $fvalues)
	    <div class="select-block mr-1 mt-2 mt-md-0 col p-0" id="select-block-for_cart-{{ $pba }}-{{ $loop->index }}">
		    <div class="select-block-title">{{ $filter }}</div>
		    <div class="select-current-value-block d-flex justify-content-between">
			    <div class="select-current-value">{{ $fvalues[0]['title'] }}</div>
			    <div class="dd"><i class="icon-Chevron---Down"></i></div>
		    </div>
	 	    <div class="select-range-block">
	    @foreach($fvalues as $fvalue)
			    <input type="radio" id="srb-for_cart-{{ $pba }}-{{ $loop->parent->index }}{{ $loop->index }}"  class="srb-input for-cart-input" name="params_{{ $pba }}[{{ $filter }}]" data-filter="{{ $filter }}" value="{{ $fvalue['title'] }}" @if($loop->first) checked @endif>
	            <label class="srb-item d-flex justify-content-between m-0" for="srb-for_cart-{{ $pba }}-{{ $loop->parent->index }}{{ $loop->index }}" data-value="{{ $fvalue['title'] }}" data-block_id="for_cart-{{ $pba }}-{{ $loop->parent->index }}">
	                <div>{{ $fvalue['title'] }}</div>
	                <div><i class="icon-Tick"></i></div>
	            </label>
	    @endforeach
		    </div>
	    </div>
    @endforeach

    @foreach($product->pricelist_ready as $filter => $fvalues)
	    <div class="select-block mr-1 mt-2 mt-md-0 col p-0" id="select-block-pricelist-{{ $pba }}-{{ $loop->index }}">
			<div class="select-block-title">{{ $filter }}</div>
			<div class="select-current-value-block d-flex justify-content-between">
				<div class="select-current-value">{{ $fvalues[0]['title'] }}</div>
				<div class="dd"><i class="icon-Chevron---Down"></i></div>
			</div>
			<div class="select-range-block">
	    @foreach($fvalues as $fvalue)
				<input type="radio" id="srb-pricelist-{{ $pba }}-{{ $loop->index }}"  class="srb-input pricelist-input" name="params_{{ $pba }}[{{ $filter }}]" data-price="{{ $fvalue['price'] }}" data-id="{{ $fvalue['id'] }}" data-filter="{{ $filter }}" value="{{ $fvalue['title'] }}" @if($loop->first) checked @endif>
	            <label class="srb-item d-flex justify-content-between m-0" for="srb-pricelist-{{ $pba }}-{{ $loop->index }}" data-value="{{ $fvalue['title'] }}" data-block_id="pricelist-{{ $pba }}-{{ $loop->parent->index }}" >
	                <div>{{ $fvalue['title'] }}</div>
	                <div><i class="icon-Tick"></i></div>
	            </label>
	    @endforeach
			</div>
		</div>
    @endforeach
	    <div class="count-block  mt-2 mt-md-0" id="count-block-{{ $pba }}">
		    <input type="number" name="count" class="count-input" style="display: none;" value="1">
		    <div class="count-block-title">
			    @lang('Quantity')
		    </div>
		    <div class="count-block-main d-flex">
			    <div class="count-block-value">
				    1
			    </div>
			    <div class="count-block-buttons">
				    <div class="count-block-button count-block-button-up" data-inc="1" data-id="{{ $pba }}">
					    <i class="icon-Chevron---Up"></i>
				    </div>
				    <div class="count-block-button count-block-button-down muted" data-inc="-1" data-id="{{ $pba }}">
					    <i class="icon-Chevron---Down"></i>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>
@endforeach
</div>