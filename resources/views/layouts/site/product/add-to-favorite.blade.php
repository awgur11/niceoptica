<style type="text/css">
    #add-to-favorite{
    	color: #333;
    	font-family: fnormal;
    	font-size: 18px;
    	padding: 25px 15px;
    	text-align: center;
    	cursor: pointer;
        background: #f1f5f8;
    }
</style>
<div id="add-to-favorite">
@if(session('favorites.'.$product->id, 0) == 0)
    <div class="add-to-favorite" data-url="{{ route('add.to.favorite', ['id' => $product->id]) }}">
		<i class="ri-heart-add-line"></i> @lang('Add to favorite')
	</div>
@else 
	<div class="add-to-favorite" data-url="{{ route('add.to.favorite', ['id' => $product->id]) }}">
		<i class="ri-heart-add-fill"></i> @lang('Added to favorite')
	</div>
@endif	
	
</div>
<script type="text/javascript">
	$(document).on('click', '.add-to-favorite', function(){
		var url = $(this).data('url'),
		    heart = $(this);

		$.ajax({
            method: 'GET',
            url: url,
 
            success: function(count)
            {
            	if(count > 0)
            	{
            		$('.add-to-favorite').html('<i class="ri-heart-add-fill"></i> @lang("Added to favorite")');
                    $('#favorites-head .ri-heart-line').removeClass('ri-heart-line').addClass('ri-heart-fill');

            	}
            	else
            	{
            		$('.add-to-favorite').html('<i class="ri-heart-add-line"></i> @lang("Add to favorite")');
                    $('#favorites-head .ri-heart-fill').addClass('ri-heart-line').removeClass('ri-heart-fill');
            	}
                $('.favorites-count').text(count);
                $('.favorites-count-mobile').text(count);
      
            },
            error:  function(xhr, str)
            {
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });
	});

</script>