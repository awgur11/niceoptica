<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charaset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Admin</title>
<meta name="description" content="" />
<link rel="stylesheet" href="{{ asset('css/icons.css') }}">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="{{ asset('bootstrap-4/css/bootstrap.min.css') }}">
<!-- jQuery library -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<!-- Popper JS -->
<script src="{{ asset('js/popper.min.js') }}"></script>
<!-- Latest compiled JavaScript -->
<script src="{{ asset('bootstrap-4/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/admin.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/admin.css') }}">
<link rel="stylesheet" href="{{ asset('/css/animate.css') }}">
<!--ckeditor--> 
<script src="{{ asset('/ckeditor/ckeditor.js') }}" type="text/javascript" charset="utf-8" ></script>
 
<script src="/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="/tinymce/js/tinymce/plugins/advlist/plugin.min.js"></script>

<!--VUE.JS -->
<!--
<script src="{{ asset('js/vue.min.js') }}"></script>
-->
<script src="{{ asset('js/axios.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<link rel="stylesheet" href="{{ asset('/fontawesome-free/css/all.css') }}">
</head>
<body style="">

@include('layouts.admin.menu')

@if(Session::has('message'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong>    @lang(Session::get('message'))
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if(Session::has('my_errors'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong>    @lang(Session::get('my_errors'))
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@include('layouts.admin.alert-saved-block')

@yield('content')

</body>
</html>


