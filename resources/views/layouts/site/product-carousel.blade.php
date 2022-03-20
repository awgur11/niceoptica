<?php
  $class = $class ?? 'some_class';
?>

<script type="text/javascript">
$(document).ready(function(){
	$('.{{ $class }}').slick({
  infinite: true,
  slidesToShow: 5, 
  slidesToScroll: 1,
  arrows: true,
  autoplay: true,
  speed: 3000,
  autoplaySpeed: 6000,
  prevArrow: $('.prev-{{ $class }}'),
  nextArrow: $('.next-{{ $class }}'),
  responsive: [
    {
      breakpoint: 1205,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: true,
        dots: false,
        arrows: true
      }
    },
    {
      breakpoint: 1180,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: false,
        arrows: true
      }
    },
    {
      breakpoint: 976,
      settings: {
      	arrows: true,
        slidesToShow: 2,
        slidesToScroll: 2,
        dots: false,
        arrows: false
      }
    },
    {
      breakpoint: 580,
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
@once
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick/slick.css') }}"/>
<!-- Add the new slick-theme.css if you want the default styling-->
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick/slick-theme.css') }}"/>
<script type="text/javascript" src="{{ asset('/slick/slick/slick.min.js') }}"></script>
<style type="text/css">
  .pr-preview{
    height: 220px;
    position: relative;
  }
  .pr-block{
    padding: 5px;
  }
  .pr-card{
    border: 1px solid #fff;
    transition: 0.3s;
    padding: 10px;
    border: 1px solid #000;
  }
  .pr-card:hover{
    border: 1px solid #c7003d;
  //  background: #f9f9f9;
    box-shadow: 0 0 20px #c7003d34;
  }
  .pr-preview img{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 100%;
    max-height: 170px;
  }
  .pr-title{
    font-family: fnormal;
    font-size: 13px;
    color: #666;
    height: 5em;
    overflow: hidden;
    text-align: center;
  }
  .pr-price{
    color: #333;
    font-family: fbold;
    font-size: 18px;
  }
  .pr-price span{
    font-family: fbold;
    color: #000;
    font-size: 13px;
  }
  .slick-my-button-block{
    position: relative; 
    left: 15px;

  }
  .slick-track{
    padding: 15px 0;
  }
  a:hover{
    text-decoration: none;
  }

@media screen and (max-width: 580px){
  .slick-next{
    left: 95%;
  }
  .slick-prev{
    left:0;
  }
  .pr-preview{
    height: 170px;
    position: relative;
  }
  .slick-my-button-block{
    left: 0;
  }
  .pr-title{
    font-family: 12px;
    height: 4.5em;
    overflow: hidden;
  }


}

</style>
@endonce
<div class="d-flex justify-content-end slick-my-button-block" style="">
  <div class="btn btn-outline-primary m-1 prev-{{ $class }}">
    <i class="fas fa-arrow-left"></i>
  </div>
  <div class="btn btn-outline-primary  m-1 next-{{ $class }}">
    <i class="fas fa-arrow-right"></i>
  </div>
</div>
<div class="{{ $class }}" style="margin: 0 -15px!important;">

@foreach($items as $item)

<div class="pr-block">
  <div class="pr-card">

        <a href="{{ route('product', ['id_catalog' => $item->catalog_id, 'alt_catalog' => $item->catalog->alt_title, 'id' => $item->id, 'alt_title' => $item->alt_title]) }}">
        <div class="pr-preview">
    @if($item->discount != 0)
          <div class="badge badge-danger">
            -{{ $item->discount }}%
          </div>
    @endif
        @if($item->picture != null)
            <img src="{{ asset($item->picture->four_preview) }}" alt="{{ $item->title }}" title="{{ $item->title }}">
        @endif
        </div>
        
      <div class="pr-title">
        {{ $item->language->title ?? $item->title }}
      </div>
      </a>
        <div class="price-block p-2 d-flex justify-content-between align-items-center">
          <button data-toggle="modal" data-target="#cartModal" class="btn btn-danger add-to-cart-button btn-sm"  data-id="{{ $item->id }}" data-price="{{ $item->final_price }}"><i class="fas fa-cart-plus"></i> @lang('To cart')</button>
    @if($item->discount == 0)
            <div class="pr-price ">
                {{ $item->final_price }} <span>грн</span>
            </div>
    @else
            <div class="pr-discount-price d-flex">
                <div class="pr-old-price">
                    {{ $item->price }} <span>грн</span>
                </div>
                <div class="pr-new-price">
                    {{ $item->final_price }} <span>грн</span>
                </div>
                
            </div>
    @endif
        <div>
          <!--      <button class="btn add-to-cart-button" data-filters_for_order="" data-product_id="{{ $item->id}}" data-price="{{ $item->final_price_exchange }}" data-session="{{ Session::getId() }}" src="{{ asset('images/cart-white.png') }}">
                  <i class="ri-shopping-cart-2-line" style="color: #1db839; font-size: 30px;"></i>
                </button> -->
            </div>
        </div>
  </div>
</div>

@endforeach

</div>

