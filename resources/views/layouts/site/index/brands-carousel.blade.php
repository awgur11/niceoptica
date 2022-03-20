@once
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick/slick.css') }}"/>
<!-- Add the new slick-theme.css if you want the default styling-->
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick/slick-theme.css') }}"/>
<script type="text/javascript" src="{{ asset('/slick/slick/slick.min.js') }}"></script>
@endonce
<script type="text/javascript">
$(document).ready(function(){
	$('#brands-carousel').slick({
        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 1,
        arrows: true,
        autoplay: false,
        speed: 1000,
        autoplaySpeed: 15000,
        prevArrow: $('.brands-navigation-left'),
        nextArrow: $('.brands-navigation-right'),
        responsive: [
        {
            breakpoint: 1224,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: false,
                arrows: true
            }
        },
        {
            breakpoint: 600,
            settings: {
      	        arrows: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
            }
        },
        ]
    });
});
</script>
<style type="text/css">
    #brands-carousel{
        border: 1px solid #DCDCDC;
    }
    #brands-carousel div:not(:last-child){
        border-right: 1px solid #DCDCDC;
    }
</style>
<div id="brands-carousel">
@foreach($brands as $b)
    <div class="text-center">
        <img src="{{ $b->five_preview}}" alt="" style="max-width: 70%; margin: auto;">
        
    </div>
@endforeach
</div>
