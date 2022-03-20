<style type="text/css">
	#main-preview{
	  height: 400px;
	  min-height: 100%;
		position: relative;
//		box-shadow: 0 0 2px rgba(0,0,0,0.2);
	text-align: center;
	border: 1px solid #DCDCDC;;
	height: 564px;
	padding-top: 450px;
	}
	#main-preview>img{

		max-width: 90%;
		max-height: 90%;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		z-index: -1;
	}
    #main-preview #zoom-link{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translateX(-50%) translateY(-50%);
		width: 100%;

		transition: 0.5s;
		z-index: 9;
	//	box-shadow: 0px 0px 1px rgba(0,0,0,.4);

	}
	#main-preview #zoom-link>img{
		max-width: 90%;
		padding: 10px;
		background-color: #fff;

	}

	#preview-thumbs{
		margin: 0 -7px;

	}
	#preview-thumbs .preview-thumb{
//		box-shadow: 0 0 2px rgba(0,0,0,0.2);
//		padding: 10px;
		cursor: pointer;
		height: 70px;
		display: flex;
		align-items: center;
		transition: 0.3s;
		text-align: center;
		justify-content: center;
		position: relative;
	}
	#preview-thumbs .preview-thumb.active:after{
		position: absolute;
		bottom: 0px;
		left: 0;
		content: "";
		width: 100%;
		height: 4px;
		border-radius: 5px;
		background-color:  #2C50F2;
	}
	#preview-thumbs .preview-thumb img{
		max-width: 100%;
		max-height: 100%;
	}
	#preview-thumbs .preview-thumb:hover{
	}
@media screen and (max-width: 768px) {
	#main-preview{
	  height: 364px;
	  padding-top: 280px;
	}
	#preview-thumbs .preview-thumb{
		height: 60px;
	}
	
}

	 
</style>
<script src="/SmartPhoto-master/js/smartphoto.min.js"></script>
<link rel="stylesheet" href="/SmartPhoto-master/css/smartphoto.min.css">
<style type="text/css">
	.smartphoto-dismiss{
		position: relative;
	}
	.smartphoto {
    z-index: 9999;
  }
</style>
 <script>
    document.addEventListener('DOMContentLoaded', function () {
      new SmartPhoto(".js-smartPhoto");
      new SmartPhoto(".js-smartPhoto-hide", {
        arrows: false,
        nav: false
      });
      new SmartPhoto(".js-smartPhoto-fit", {
        resizeStyle: 'fit'
      });
    });

  </script> 
<div id="main-preview">

@if($product->promo == 1)
	<div class="promo-flag">
		@lang('TOP sales')
	</div>
@endif
@if($product->discount != 0)
	<div class="sale-flag">
		@lang('Sale')
	</div>
@endif

	<div class="add-to-favorite-button atfb @if(in_array($product->id, $favorites_content)) active @endif" data-id="{{ $product->id }}"> <i class="@if(in_array($product->id, $favorites_content)) ri-heart-fill @else ri-heart-line @endif"></i></div>

	<div class="add-to-compare-button atcb @if(in_array($product->id, $compare_content)) active @endif" data-id="{{ $product->id }}"><i class="icon-Pillow-Chart---1"></i> </div>
	<a href="{{ asset($product->picture->fhd_preview) }}" class="js-smartPhoto"  data-caption="" data-id="" data-group="group" id="zoom-link">
	  <img src="{{ asset($product->picture->fhd_preview) }}" alt="{{ $product->language->title ?? $product->title }}" id="main-preview-img">
	
	</a>
@if($product->pictures->count() > 1)
	<div id="preview-thumbs" class="mt-2 ">
    @foreach($product->pictures as $picture)
    <div class="preview-thumb preview-thumb-{{ $picture->id }} text-center m-2 @if($loop->first) active @endif" data-src="{{ asset($picture->fhd_preview) }}">
    	<img src="{{ asset($picture->five_preview) }}" alt="">
        @if(!$loop->first) 
        <a href="{{ asset($picture->fhd_preview) }}" class="js-smartPhoto"  data-caption="{{ $picture->language->title }}" data-id="{{ $picture->language->title }}" data-group="group" ></a>
        @endif
    </div>
    @endforeach
  </div>
@endif
</div>
@if($product->pictures->count() > 1)
    @once
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick/slick.css') }}"/>
<!-- Add the new slick-theme.css if you want the default styling-->
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick/slick-theme.css') }}"/>
<script type="text/javascript" src="{{ asset('/slick/slick/slick.min.js') }}"></script>
    @endonce
<script type="text/javascript">
$(document).ready(function(){
	$('#preview-thumbs').slick({
  infinite: false,
  slidesToShow: 5,
  slidesToScroll: 1,
  arrows: true,
  dots: true,

    responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: true,
        dots: false,
   //     arrows: false,

      }
    },
    {
      breakpoint: 600,
      settings: {
      	arrows: true,
        slidesToShow: 3,
        slidesToScroll: 2,
        dots: false,
    //    arrows: false,
      }
    },
  ]
});
});
</script>

<script type="text/javascript">
	$(document).on('click', '.preview-thumb', function(){
		var src = $(this).data('src');
		$('#main-preview-img').attr('src', src);
		$('#zoom-link').attr('href', src);

		$('.preview-thumb').removeClass('active');
		$(this).addClass('active');


	})
</script>
@endif
