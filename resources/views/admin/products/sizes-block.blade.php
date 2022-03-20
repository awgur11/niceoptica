@if(isset($catalog) && $catalog->sizes()->count() > 0)
<h3 class="text-center">@lang('Set product`s sizes')</h3>
<div class="col-sm-12 form-block" id="sizes-block">
@foreach($catalog->sizes as $size)
    <div class="form-check-inline">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="sizes[]" value="{{ $size->id }}" @if(isset($product) && $product->sizes()->find($size->id) != null) checked @endif data-title="{{ $size->title }}">{{ $size->title }}
        </label>
    </div>
@endforeach
</div>
<div class="form-group mt-3 text-right">
  	<button type="button" class="btn btn-sm btn-success" id="select-all-sizes-button">@lang('Select all')</button>
</div>
<script type="text/javascript">
	$(document).on('click', '#select-all-sizes-button', function(){
		$('#sizes-block input[type = "checkbox"]').each(function(){
			if($(this).prop('checked') === true)
				$(this).prop('checked', false)
			else
				$(this).prop('checked', true);

			creating_range();
		    fill_range();

		})
	})
</script>
@endif