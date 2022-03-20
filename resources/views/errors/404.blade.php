@extends('site.base')

@section('content')
<style type="text/css">
#block-404 img{
  max-width: 100%;
}
#block-404 p{
  font-family: Nunito Sans;
font-size: 18px;
font-style: normal;
font-weight: 400;
line-height: 27px;
letter-spacing: 0px;
text-align: left;
color: #5E5E5E;
}
#block-404 h3{
  font-family: Nunito Sans;
font-size: 32px;
font-style: normal;
font-weight: 400;
line-height: 38px;
letter-spacing: 0px;
text-align: left;
color: #202020;

}

</style>


<div class="container py-5" id="block-404">
  <div class="row justify-content-center align-items-center">
      <div class="col-md-5 d-none d-md-block">
        <img src="{{ $site_option['404_bg']['fhd'] ?? null}}" alt="">
      </div>
      <div class="col-md-7 col-lg-5">
        <div class="bg-light p-4">
          <h3>@lang('Error 404')</h3>
          <p class="my-3">
            {{ $site_option['text_404'] ?? null }}
          </p>
          <a href="/" class="btn btn-primary btn-block">
            @lang('Home page')
          </a>
          
        </div>
        
      </div>
  </div>
</div>

@endsection