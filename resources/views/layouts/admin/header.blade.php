<style type="text/css">
  #header {
    background: linear-gradient(to right, rgba(255,255,255,1) 0%, rgba(255,255,255, 1) 40%, rgba(255,255,255,0.2) 80%, rgba(255,255,255,0.4) 100%), url(/images/mountain.png) right top no-repeat;
    background-size: contain;
    box-shadow: 1px 1px 3px rgb(0 0 0 / 20%);
    border-radius: 0;
}
  #header .row{
    height: 200px;
  }
</style>
<div class="container my-3" id="header">
  <div class="row align-items-center" >
    <div class="col-12">
      <h4>{{ $title ?? null }}</h4>      
      <p>{!! $content ?? null !!}</p>
    </div>
  </div>
</div>