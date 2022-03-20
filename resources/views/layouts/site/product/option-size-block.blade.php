<style type="text/css">
	.osb-phrase{
		color: #000;
		font-size: 16px;
		letter-spacing: 2px;
		font-family: fnormal;

	}
	.osb-item{
		padding: 15px 20px;
		color: #000;
		border: 1px solid #000;
		position: relative;
		top: -15px;
		margin-left: 10px;
		margin-bottom: 10px;
		transition: 0.3s;
		cursor: pointer;
		display: inline-block;
	}
	.osb-item:hover, .osb-item.active{
		color: #fff;
		background: #000;
	}
@media screen and (max-width:  990px) {
	.osb-item{
		top: 5px;
	}
}
</style>
<script type="text/javascript">
	function select_size_note()
	{
		if($('.osb-item.active').length == 0)
		{
			$('#select-size-note-block').removeClass('d-none');
			return false;
		}
		else
		{
			$('#select-size-note-block').addClass('d-none');
			return true;
		}
	}
	$(document).on('click', '.osb-item', function(){
		if(!$(this).hasClass('active'))
		{
			$('.osb-item').removeClass('active');
			$(this).addClass('active');
		    $('.add-to-cart-button').data('size_id', $(this).data('size_id'));
		    console.log($('.add-to-cart-button').data());

		    select_size_note();
		}

	})
</script>
<div id="option-size-block" class="row  mt-2 mb-2 ">
    <div class="osb-phrase col-lg-4">
        @lang('Select size'):
    </div>
    <div class="col-lg-8">
@foreach($sizes as $size)
        <div class="osb-item" data-size_id="{{ $size->id }}">{{ $size->title }}</div>
@endforeach
    </div>
</div>
<div id="select-size-note-block" class=" mt-2 alert alert-warning d-none">
	<b>@lang('Please')</b>, @lang('Select Your size')
</div>