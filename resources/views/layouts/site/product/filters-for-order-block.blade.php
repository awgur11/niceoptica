@if($product->catalog->filtersForOrder != null)
    @php
        $filters_ids_arr = explode(',', $product->catalog->filtersForOrder);
    @endphp

	@foreach($product->catalog->filters()->whereIn('filters.id', $filters_ids_arr)->get() as $filter)
	<h3>
		<small>{{ $filter->language->title ?? null }}</small>
	</h3>
	<div class="row mb-3">
		<div class="col-12 filter-for-order-block" id="filter-for-order-{{ $filter->id }}">
		@foreach($product->fvalues()->where('filter_id', $filter->id)->get() as $fvalue)
		    <div class="fvalue-for-order-item" data-id="{{ $fvalue->id ?? 0 }}" data-title="{{ $fvalue->language->title ?? null }}" data-filter_id="{{ $filter->id }}">
		    	{{ $fvalue->language->title ?? null }}
		    </div>
		@endforeach
		    <div class="alert alert-warning select-filter d-none mt-3">
                <strong>@lang('Please'),</strong> @lang('Select') {{ $filter->language->title }}
            </div>
		</div>
	</div>
	@endforeach
<style type="text/css">
	.filter-for-order-block{
		padding: 15px;
	}
	.fvalue-for-order-item{
		padding: 15px;
		margin:5px;
		border:1px solid #ddd;
		display: inline-block;
		cursor: pointer;
		transition: 0.3s;
	}
	.fvalue-for-order-item.active{
		background-color: #ddd;
	}
</style>
<script type="text/javascript">
	$(document).on('click', '.fvalue-for-order-item', function(){
		var id = $(this).data('id'),
		    filter_id = $(this).data('filter_id');

		$('#filter-for-order-' + filter_id + ' .fvalue-for-order-item').removeClass('active');
		$('#filter-for-order-' + filter_id + ' .alert-warning.select-filter').addClass('d-none');
		$(this).addClass('active');

		$('.add-to-cart-button').data('filters_for_order', '');
		$('.fvalue-for-order-item.active').each(function() {
			var fvalues = $('.add-to-cart-button').data('filters_for_order');

			if(fvalues != '')
				fvalues += ',';
			fvalues += $(this).data('title');

			$('.add-to-cart-button').data('filters_for_order', fvalues);

		});

		//console.log($('.add-to-cart-button').data());
	});
</script>
@endif