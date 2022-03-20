<style type="text/css">
  .my-alert{
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    max-width: 100%;
    box-shadow: 0 0 55px rgba(0,0,0,.1);
    z-index: 99999999;
  }
</style>
@if(Session::has('message'))
<div class="my-alert alert alert-success alert-dismissible fade show" role="alert">
  <strong>@lang('Success')!</strong>    @lang(Session::get('message'))
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if(Session::has('error'))
<div class="my-alert alert alert-danger alert-dismissible fade show" role="alert">
  <strong>@lang('Error')!</strong>    @lang(Session::get('error'))
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
@if($errors->any())
<div class="my-alert alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong>  
    <ul> 
  @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
  @endforeach
    </ul>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
