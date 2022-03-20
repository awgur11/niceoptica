<style type="text/css">
	#filters-form-cart-block label{
		font-family: fbold;
	}
</style>
<div id="filters-form-cart-block" class="mt-4 mb-4 row">
@foreach($product->catalog->filters->where('for_cart', 1) as $filter)
   <div class="filter-for-cart-block col-md-6">
   	    <label>{{ $filter->language->title }}:</label>
   	    <select class="filter-for-cart-select form-control" data-title="{{ $filter->language->title }}">
   	@foreach($filter->fvalues as $fvalue)
   	        <option value="{{ $fvalue->language->title }}">{{ $fvalue->language->title }}</option>
   	@endforeach
   	    </select>
   </div>
@endforeach
</div>
<script type="text/javascript">
	$(document).on('change', '.filter-for-cart-select', function(){
		save_cart_params();
	})
</script>