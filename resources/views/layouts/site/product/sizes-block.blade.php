@if($product->sizes()->count() > 1)
	<h3>
		<small>@lang('Sizes')</small>
	</h3>
	<div class="row mb-3">
		<div class="col-12 sizes-block" id="sizes-block">
		@foreach($product->sizes as $size)
		    <div class="size-block" data-id="{{ $size->id ?? 0 }}" data-title="{{ $size->language->title ?? null }}" id="size-block-{{ $size->id }}">
		    	{{ $size->language->title ?? null }}
		    </div>
		@endforeach
		    <div class="alert alert-warning select-size d-none mt-3">
                <strong>@lang('Please'),</strong> @lang('Select size')
            </div>
		</div>
	</div>
<style type="text/css">
	.size-block{
		padding: 15px;
	} 
	.size-block{
		padding: 15px;
		margin:5px;
		border:1px solid #ddd;
		display: inline-block;
		cursor: pointer;
		transition: 0.3s;
	}
	.size-block.active{
		background-color:#f6fbfe;
		border:1px solid #247bae;
	}
</style>
<script type="text/javascript">
	$(document).on('click', '.size-block', function(){
		var id = $(this).data('id');

		$('#sizes-block .size-block').removeClass('active');
		$('#sizes-block .alert-warning.select-size').addClass('d-none');
		$(this).addClass('active');

    	$('.add-to-cart-button').data('size_id', id);

    	console.log($('.add-to-cart-button').data());

    	colours_for_size(id);
	});
	//ПРОВЕРКА НАЛИЧИЯ ЦВЕТОВ ДЛЯ ВЫБРАННОГО РАЗМЕРА
	function colours_for_size(size_id){
		var range = <?php echo json_encode($product->range->toArray()); ?>

		$('.colour-block').addClass('d-none');

		range.forEach(function(el){
			if(el.size_id == size_id)
				$('#colour-block-' + el.colour_id).removeClass('d-none'); 
		});
	}
</script>
@endif


