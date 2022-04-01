
<!DOCTYPE html>
<html lang="ru-UA">
<head>
<meta charaset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

@include('layouts.site.seo')

@isset($site_option['favicon']['mini'])
  <link rel="icon" type="image/png" href="{{ $site_option['favicon']['mini'] }}"  />
@endisset
 
<link rel="shortlink" href="{{ url()->current() }}" />
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="{{ asset('bootstrap-4/css/bootstrap.min.css') }}">
<!-- jQuery library -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<!-- Popper JS -->
<script src="{{ asset('js/popper.min.js') }}"></script>
<!-- Latest compiled JavaScript -->
<script src="{{ asset('bootstrap-4/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/site.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/site.css') }}">
<!--
<link rel="stylesheet" href="{{ asset('/css/animate.css') }}">
-->
<!-- parallax 
<script src="/js/parallax.min.js"></script> 
-->

<script defer src="{{ asset('/jquery.inputmask.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.send-phone').inputmask("+38 (999) 999 9999");  //static mask
});
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&display=swap" rel="stylesheet">
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{ $site_option['og_title'][$csl] ?? null }}" />
<meta property="og:description"   content="{{ $site_option['og_description'][$csl] ?? null }}" />
@isset($site_option['og_image'][$csl])
<meta property="og:image" content="{{ asset('storage/images'.$site_option['og_image'][$csl]) }}" />
@endisset
<!--
<link rel="stylesheet" href="{{ asset('css/fancybox.min.css') }}" />
<script src="{{ asset('js/fancybox.min.js') }}"></script>
-->
<link rel="stylesheet" href="{{ asset('css/icons.css') }}">
<link rel="stylesheet" href="{{ asset('/fontawesome-free/css/all.css') }}">
<!--http://remixicon.com/-->
<link rel="stylesheet" href="{{ asset('/RemixIcon/remixicon.css') }}">
<meta name="format-detection" content="telephone=no">
<!--VUE.JS -->
<!--
<script src="{{ asset('js/vue.min.js') }}"></script>
<script src="{{ asset('js/axios.js') }}"></script>-->

</head>
<style type="text/css">
  body{
  //  padding-top: 110px;
  }
@media screen and (max-width: 768px) {
  body{
 //   padding-top: 103px;
  }
  
}
@media screen and (max-width: 580px) {
  body{
 //   padding-top: 96px;
  }
  
}
</style>
<body>

@include('layouts.site.alerts-block')

@include('layouts.site.adminzone-link')

@include('layouts.site.store.add-to-cart-modal')

@include('layouts.site.side-menu-mobile')

@include('layouts.site.callback-modal')
 
@include('layouts.site.menu-store-fixed')

@yield('content')

@include('layouts.site.footer')

@include('layouts.site.login-register-modal')

</body>

</html>


