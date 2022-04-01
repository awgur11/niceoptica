<?php
  if(Session::has('error') || Session::has('message'))
  {
    if(Session::has('alert_title'))
      $alert_title = Session::get('alert_title');
    elseif(Session::has('error'))
      $alert_title = __('Error');
    elseif(Session::has('message'))
      $alert_title = __('Success');

    if(Session::has('error'))
    {
      $alert_message = Session::get('error');
      $alert_type = 'my-alert-error';
    }
    elseif(Session::has('message'))
    {
      $alert_message = Session::get('message');
      $alert_type = 'my-alert-message';
    }
  }
?>

<style type="text/css">
  .my-alert-bg{
    width: 100%;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 99999999;
    background: rgba(0, 0, 0, 0.4);
    overflow: hidden;
    display: none;
  }
  .my-alert-bg.show{
    display: block;
  }
  .my-alert-block{
    position: absolute;
    z-index: 1;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    width: 350px;
    max-width: 100%;
  }
  .my-alert-header{
    font-family: fbold;
    letter-spacing: 2px;
    font-size: 17px;
  }
  .my-alert-header.my-alert-message{
    background-color: #62d583;
  }
  .my-alert-header.my-alert-error{
    background-color: #e96161;
  }
  .my-alert-body{
    color: #333;
    font-family: fnormal;
    font-size: 15px;
  }
  .close-my-alert{
    cursor: pointer;
  }
</style>
<div class="my-alert-bg @if(Session::has('error') || Session::has('message')) show @endif p-2">
  <div class="my-alert-block">
    <div class="my-alert-header d-flex justify-content-between align-items-center px-3 py-2 {{ $alert_type ?? null }}">
      <div class="my-alert-title">{{ $alert_title ?? null }}</div> <div class="icon-Cross close-my-alert"></div>
    </div>
    <div class="my-alert-body px-3 py-4">
      {{ $alert_message ?? null }}
    </div>
  </div>  
</div>
<script type="text/javascript">
@if(Session::has('error') || Session::has('message'))
  $(function(){
    $('body').addClass('stop-scrolling');
  });
@endif
  $(document).on('click', '.close-my-alert', function(){
    $('.my-alert-bg').removeClass('show');
    $('body').removeClass('stop-scrolling');
  });
</script>
