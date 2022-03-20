@if($product->colours()->count() > 1)
<style type="text/css">
    .colour-block{
    	position: relative;
    	cursor: pointer;
    	padding: 0 10px 10px 10px;
    	text-align: center;
    	border-left: 2px solid #fff;
    	transition: 0.3s;
    }
    .colour-block.active{
    	background-color: #f6fbfe;
    	border-left: 2px solid #247bae;
    }
	.colour-sample{
		width: 30px;
		height: 30px;
		padding: 10px;
		border:1px solid  #fff;
		transition: 0.3s;
		opacity: 0.8;
		box-shadow: 0 0 5px #fff inset, 3px 3px 10px rgba(0,0,0,.2);
		display: inline-block;
		transform: translateY(7px);
		margin-right: 10px;
	} 
	.colour-sample.active{

	}
	.colour-title{
		font-size: 14px;
		color: #666;
		display: inline-block;

	}
</style>
<script type="text/javascript">
	$(document).on('click', '.colour-block', function(){
		var id = $(this).data('id');
		$('.colour-block').removeClass('active');
		$(this).addClass('active');
		$('.thumb-colour-' + id).first().click();
		$('.colour-block>.colour-sample').removeClass('active');
		$(this).children('.colour-sample').addClass('active');

		$('.select-product-colour').addClass('d-none');

		$('.add-to-cart-button').data('colour_id', id);

		sizes_for_colour(id);

	});
		//ПРОВЕРКА НАЛИЧИЯ РАЗМЕРОВ ДЛЯ ВЫБРАННОГО ЦВЕТА
	function sizes_for_colour(colour_id){
		var range = <?php echo json_encode($product->range->toArray()); ?>

		$('.size-block').addClass('d-none');

		range.forEach(function(el){
			if(el.colour_id == colour_id)
				$('#size-block-' + el.size_id).removeClass('d-none'); 
		});
	}
</script>
<h3 style=""><small>@lang('Colours')</small></h3>
<div class="row mb-3 mt-3" id="colours-block">
	@foreach($product->colours as $colour)
		@php
	       $background = $colour->preview != null ? 'url('.asset('storage/thumbnails'.$colour->preview).')' : $colour->rgb;
	    @endphp
	<div class="colour-block col-sm-3 col-6" data-id="{{ $colour->id }}" id="colour-block-{{ $colour->id }}">
		<div class="colour-sample" style="background: {{ $background }}"></div>
		<div class="colour-title">{{ $colour->language->title ?? null }}</div>
	</div>
	@endforeach
	<div class="alert alert-warning select-product-colour d-none mt-3">
       <strong>@lang('Please'),</strong> @lang('Select product colour')
    </div>
</div>
@endif