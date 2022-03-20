<style type="text/css">
	#car-line{
		background: linear-gradient(120deg, #fff 0%, #fff 30%, #f3f3f3 30%);
		padding-top: 45px;
		padding-bottom: 45px;
	}
	.comment-block{
		padding: 25px;
	}
	.comment-card{
		background: #fff;
		padding: 15px;
		box-shadow: 5px 5px 25px rgba(0,0,0,.4);
	}
	.comment-name{
		font-size: 16px;
		font-family: fbold;
	}
	.comment-text{
		font-family: fitalic;
		font-size: 14px;
		color: #666;
	}
	.next-comments-block{
		font-family: fbold;
		font-size: 16px;
		letter-spacing: 2px;
		color: #333;
		transition: 0.3s;
		cursor: pointer;
		width: 1140px;
		max-width: 100%;
		margin: auto;
	}
	.next-comments-block:hover{
		color: #ff8300;;
	}
</style>
<div class="container-fluid" id="comments-carousel">
	<div class="row">
		<div class="col-12">
			<h2 class="block-title">
				Comments
			</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-12" id="car-line">
			<div class="comments-block">
		@foreach($comments as $co)
				<div class="comment-block">
					<div class="comment-card">
					    <div class="comment-text">{{ $co->comment }}</div>
					    <div class="comment-name mt-2">{{ $co->name }}</div>
					    <div class="comment-stars mt-2">
			@for($i=0; $i<=$co->stars; $i++)
                            <i class="far fa-star star-item" data-id='{{ $i }}'></i>
            @endfor
					    </div>
					</div>
				</div>
		@endforeach
			</div>	
			<div class="mt-3 text-right next-comments-block">
				<span class="">@lang('Next comment') <i class="fas fa-arrow-right"></i></span>
			</div>		
		</div>
	</div>
	<div class="row mt-5">
		<div class="col-lg-10 col-12 text-right">
			<button class="btn btn-primary" data-toggle="modal" data-target="#commentsFormModal">@lang('Leave Your comment')</button>
		</div>
	</div>
</div>
@once
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick/slick.css') }}"/>
<!-- Add the new slick-theme.css if you want the default styling-->
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick/slick-theme.css') }}"/>
<script type="text/javascript" src="{{ asset('/slick/slick/slick.min.js') }}"></script>
@endonce
<script type="text/javascript">
$(document).ready(function(){
	$('.comments-block').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        autoplay: true,
        speed: 1000,
        autoplaySpeed: 15000,
        prevArrow: $('.prev-comments-block'),
        nextArrow: $('.next-comments-block'),
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
                arrows: false
            }
        },
        ]
    });
});
</script>