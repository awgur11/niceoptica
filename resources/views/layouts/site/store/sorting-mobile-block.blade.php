<style type="text/css">
	#sorting-mobile-block{
		width: 100%;
		position: absolute;
		top: 0;
		left: 0;
		height: 100vh;
		padding: 100px 0;
		display: none;
		z-index: -1;
		background: #fff;
	}
	#sorting-mobile-block.active{
		display: block;
	}
	.smb-head{
		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: 19px;
        padding: 24px 16px;
        cursor: pointer;
	}
	    .osf-item-mobile{
        color: #202020;
        padding: 16px 24px;
        font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 300;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
cursor: pointer;
    }
	[type="radio"]:checked.order-radio-mobile + label.osf-item-mobile {
        color: #2C50F2;
        background: #F6F6F6;
    }
    [type="radio"]:not(:checked).order-radio-mobile,
    [type="radio"]:checked.order-radio-mobile {
        position: absolute;
      //  left: -9999px;
    }
    [type="radio"]:not(:checked).order-radio-mobile + .osf-item-mobile .icon-Tick{
    	display: none;
    }
</style>
<script type="text/javascript">
	$(document).on('click', '.sorting-mobile-block-cancel', function(){
		$('#sorting-mobile-block').removeClass('active');
		$('body').removeClass('stop-scrolling');
	});
	$(document).on('click', '.sorting-mobile-button', function(){
		$('#sorting-mobile-block').addClass('active');
		$('body').addClass('stop-scrolling');
	});
</script>
<div id="sorting-mobile-block">
	<div class="smb-head d-flex justify-content-between sorting-mobile-block-cancel">
    	 @lang('Sorting') <i class="icon-Cross"></i>
    </div>
    <div class="sorting-mobile-block">
  <!--          <input type="radio" name="orderBy" @if(app('request')->input('orderBy') == 'popular') checked @endif value="popular" class="order-radio-mobile" id="orderBy-mobile-popular" class="osf-input" form="fsb-form">
            <label class="osf-item-mobile d-flex justify-content-between m-0" for="orderBy-mobile-popular">
                <div>@lang('Popular')</div>
                <div><i class="icon-Tick"></i></div>
            </label>  
            <input type="radio" name="orderBy"  class="order-radio-mobile" @if(app('request')->input('orderBy') == 'novelty') checked @endif value="novelty" id="orderBy-mobile-novelty" class="osf-input" form="fsb-form">
            <label class="osf-item-mobile d-flex justify-content-between m-0" for="orderBy-mobile-novelty">
                <div>@lang('Novelties')</div>
                <div><i class="icon-Tick"></i></div>
            </label> 
            <input type="radio" name="orderBy"  class="order-radio-mobile" @if(app('request')->input('orderBy') == 'ascending') checked @endif value="ascending" id="orderBy-mobile-ascending" class="osf-input" form="fsb-form">
            <label class="osf-item-mobile d-flex justify-content-between m-0" for="orderBy-mobile-ascending">
                <div>@lang('To high price')</div>
                <div><i class="icon-Tick"></i></div>
            </label> 
            <input type="radio" name="orderBy"  class="order-radio-mobile" @if(app('request')->input('orderBy') == 'descending') checked @endif value="descending" id="orderBy-mobile-descending" class="osf-input" form="fsb-form">
            <label class="osf-item-mobile d-flex justify-content-between m-0 " for="orderBy-mobile-descending">
                <div>@lang('To low price')</div>
                <div><i class="icon-Tick"></i></div>
            </label>-->
    </div>
	
</div>
<script type="text/javascript">
	$(function(){
		if($(window).width() < 580)
			$('.order-select-range-block').appendTo('.sorting-mobile-block');
	})
</script>