<style type="text/css">
  #carouselExampleCaptions{
    height: 375px;
    width: 100%;
  }
  .carousel-item{
    height: 375px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
.carousel-caption {
  position: absolute;
  top: 128px;
  left: 132px;
  left: 15%;
  z-index: 10;
  padding-top: 20px;
  padding-bottom: 20px;
  color: #fff;
  text-align: left;
}
.carousel-caption h5{
  font-family: Nunito Sans;
  font-size: 56px;
  font-style: normal;
  font-weight: 300;
  line-height: 67px;
  letter-spacing: 0px;
  text-align: left;
}
.carousel-caption p{
  font-family: Nunito Sans;
  font-size: 32px;
  font-style: normal;
  font-weight: 700;
  line-height: 38px;
  letter-spacing: 0px;
  text-align: left;
  color: #FFD600;
}
@media screen and (max-width: 580px) {
  #carouselExampleCaptions{
    height: 83px;
  }
  .carousel-item{
    height: 83px
  }
  .carousel-caption {
  position: absolute;
  top: 10px;
    left: 48px;
  z-index: 10;
  padding-top: 10px;
  padding-bottom: 10px;
}
.carousel-caption h5{
  font-size: 14px;
  line-height: 17px;
}
.carousel-caption p{
  font-size: 12px;
  line-height: 14px;
  max-width: 200px;
}
  
}

</style>
<div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-ride="carousel">
<!--  <ol class="carousel-indicators">
@foreach($slider as $slide)
    <li data-target="#carouselExampleCaptions" data-slide-to="{{ $loop->index }}" @if($loop->first) class="active" @endif></li>
@endforeach
  </ol>-->
  <div class="carousel-inner">
@foreach($slider as $slide)
    <div class="carousel-item @if($loop->first) active @endif" style="background-image: url({{ $slide->one_preview }});" data-interval="20000">
      <div class="carousel-caption">
        <h5>{{ $slide->language->title ?? null }}</h5>
      @if($slide->language->text1 != null)
        <p>{{ $slide->language->text1 ?? null }}</p>
      @endif
      @if($slide->nol1 != null)
         <a href="{{ $slide->nol1 }}" class="btn btn-danger">@lang('Read more')</a>
      @endif
      </div>
    </div>
@endforeach
  </div>
<style type="text/css">
.carousel-control-prev,
.carousel-control-next,
.carousel-control-prev:hover,
.carousel-control-next:hover{
  opacity: 1;
}
   .carousel-control-prev span,
   .carousel-control-next span{
    background: #fff;
    width: 72px;
    height: 72px;
    background: #fff;
    opacity: 1!important;
    color: #202020;
    position: relative;
    transition: 0.3s;
   }
   .carousel-control-prev span:hover,
   .carousel-control-next span:hover{
    background: #2848DA;
    color: #fff;

   }
   #carouselExampleCaptions .icon-Arrow---Left:before,
   #carouselExampleCaptions .icon-Arrow---Right:before {
    position: absolute;
    top: 25px;
    left: 28px;
    font-size: 20px;
}
@media screen and (max-width: 580px) {
  .carousel-control-prev span,
   .carousel-control-next span{

    width: 32px;
    height: 32px;
  }
  #carouselExampleCaptions .icon-Arrow---Left:before,
  #carouselExampleCaptions .icon-Arrow---Right:before {
    position: absolute;
    top: 12px;
    left: 11px;
    font-size: 10px;
}
  
}
  
</style>

  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="icon-Arrow---Left"></span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="icon-Arrow---Right"></span>
  </a>
</div>