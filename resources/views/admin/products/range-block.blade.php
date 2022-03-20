<h3 class="text-center">@lang('Product`s range')</h3>
<div id="range-list" class="form-block" style="padding:15px;">
	<h3 class="text-center text-warning">@lang('Empty')</h3>
	
</div>
<div class="text-right bt-3 mb-3">
	<button type="button" class="btn btn-sm btn-success" id="select-all-range">@lang('Select all')</button>
</div>
<script type="text/javascript">
	$(document).on('click', '#select-all-range', function(){
		$('#range-list input[type = "checkbox"]').each(function(){
			if($(this).prop('checked') === true)
				$(this).prop('checked', false)
			else
				$(this).prop('checked', true);

		})
	})
	$(function(){
		creating_range();
		fill_range();
	});
	$(document).on('click', '#colours-block .form-check-input, #sizes-block .form-check-input', function(){
        creating_range();
        fill_range();
	});
	function creating_range()
	{
		if($('#colours-block .form-check-input:checked').length > 0 && $('#sizes-block .form-check-input:checked').length > 0)
		{
			$('#range-list').html('');

			$('#colours-block .form-check-input:checked').each(function(){
				var colour_id = $(this).val(), 
				    colour_title = $(this).data('title');
				    $('#range-list').append('<br/>');

				$('#sizes-block .form-check-input:checked').each(function(){
					var size_id = $(this).val(),
					    size_title = $(this).data('title');;
					$('#range-list').append('<div class="form-check-inline label-block"><label class="form-check-label"><input type="checkbox" class="form-check-input range-' + colour_id + '-' + size_id + '"   name="range[]" value="' + colour_id + '-' + size_id + '">' + colour_title + '-' + size_title + '</label></div>');
				});
			});

		}
	}

	function fill_range()
	{
@isset($product)
		var range = <?php echo json_encode($product->range->toArray()); ?>;
		
		range.forEach(function(el){
			$('.range-' + el.colour_id + '-' + el.size_id).prop('checked', true);
		});
@endisset
	}

</script>
<style type="text/css">
	.label-block{
		min-width: 110px;
	}
</style>