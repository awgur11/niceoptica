<?php

$currencies = $currencies ?? null
?>
<h3>@lang('Price')</h3>
<div class="form-block row pt-3">
	<div class="col-12 col-md-4 col-lg-3">
		<div class="form-group">
			<input type="number" name="price" id="price" placeholder="@lang('Price')" class="form-control" step="0.01" min="0" @isset($value) value="{{ $value->price ?? '' }}" @endisset>
		</div>
	</div>
@if($currencies != null)
	<div class="col-2">
		<div class="form-group">
			<select name="currency_id" class="form-control">
		@foreach($currencies as $currency)
		        <option value="{{ $currency->id }}" @if(isset($value) && $value->currency_id == $currency->id) selected @endif>{{ $currency->code }}</option>
		@endforeach
		    </select>
		</div>
	</div>
@endif
	<div class="col-12 col-md-4 col-lg-3">
		<div class="input-group input-group">
			<div class="input-group-prepend">
                <span class="input-group-text">@lang('Extra charge') %</span>
            </div>
			<input type="number" name="nacenka" id="nacenka" class="form-control" step="0.01" min="0" max="100" @isset($value) value="{{ $value->nacenka ?? null }}" @endisset>
		</div>
	</div>
	<div class="col-12 col-md-4 col-lg-3">
		<div class="input-group input-group">
			<div class="input-group-prepend">
                <span class="input-group-text">@lang('Discount') %</span>
            </div>
			<input type="number" name="discount" id="discount" class="form-control" step="1" min="0" max="100" @isset($value) value="{{ $value->discount ?? null }}" @endisset>
		</div>
	</div>
	<div class="col-12 col-md-4 col-lg-3 text-center">
		<h3 id="final_price"><span>{{ $value->final_price ?? 0 }}</span> грн </h3>
		<input type="hidden" name="final_price" id="final_price_input" value="{{ $value->final_price ?? 0 }}">
	</div>
</div>
<script type="text/javascript">
	$(document).on('keyup', '#price, #nacenka, #discount', function(){
		var price = $('#price').val(),
		    discount = $('#discount').val();

		final_price = price*(1 - discount/100);

		if($('#nacenka').length > 0)
		{
			nacenka = $('#nacenka').val();

			final_price = Math.round(final_price*(1 + nacenka/100)*100)/100;
		}

		$('#final_price span').text(final_price);
		$('#final_price_input').val(final_price);
	})
</script>