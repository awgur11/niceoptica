<style type="text/css">
	.ocb-phrase{
		color: #000;
		font-size: 16px;
		letter-spacing: 2px;
		font-family: fnormal;

	}
	.ocb-item{
		padding: 15px 20px;
		color: #000;
		border: 1px solid #999;
		position: relative;
		top: -25px;
		margin-left: 10px;
		margin-top: 15px;
		transition: 0.3s;
		cursor: pointer;
		display: inline-block;
	}
	.ocb-item i{
		opacity: 0;
		padding: 3px;
		background-color: #fff;
		transition: 0.3s;
	}
	.ocb-item:hover i, .ocb-item.active i{
		opacity: 1;
	}
	.ocb-item:hover, .ocb-item.active{
		border: 1px solid #000;

	}
@media screen and (max-width:  990px) {
	.ocb-item{
		top: -5px;
	}
}
</style>
<script type="text/javascript">
	function select_colour_note()
	{
		if($('.ocb-item.active').length == 0)
		{
			$('#select-colour-note-block').removeClass('d-none');
			return false;
		}
		else
		{
			$('#select-colour-note-block').addClass('d-none');
			return true;
		}
	}
	$(document).on('click', '.ocb-item', function(){
		if(!$(this).hasClass('active'))
		{
			$('.ocb-item').removeClass('active');
			$(this).addClass('active');
		    $('.add-to-cart-button').data('colour_id', $(this).data('colour_id'));
		    console.log($('.add-to-cart-button').data());

		    select_colour_note();
		}

	})
</script>
<div id="option-size-block" class="row mt-2 mb-2">
    <div class="ocb-phrase col-lg-4">
        @lang('Select colour'):
    </div>
    <div class=" col-lg-8">
@foreach($colours as $colour)
    <div class="ocb-item" data-colour_id="{{ $colour->id }}" style="background-color: {{ $colour->rgb }};"><i class="fas fa-check"></i>
    </div>
@endforeach
    </div>
	
</div>
<div id="select-colour-note-block" class=" mt-2 mt-md-0 alert alert-warning d-none">
	<b>@lang('Please')</b>, @lang('Select colour You like')
</div>