<style type="text/css">
  #menu-phone{
    font-family: fbold;
    margin-left: 3px;
  }
  #menu-phone span{
    font-size: 18px;
    font-family: fnormal;
    margin-left: 10px;
  }
  .bg-light {
    background-color: #fff!important;
    box-shadow: 0 3px 3px rgba(0,0,0,.2);
  }
  .navbar-light .navbar-nav .nav-link {
    color: #333;
    font-family: fnormal;
    font-size: 17px;
    transition: 0.3s;
    padding: 1em;
  }
  .navbar-light .navbar-nav .nav-item:first-child .nav-link {

  }
  .navbar-light .navbar-nav .nav-item:not(.active):hover .nav-link{
    color: #42a01f;
  }
  .navbar-light .navbar-nav .nav-item.active .nav-link {
    font-family: fbold;
    color: #42a01f;
    text-shadow: 3px 3px 2px #fff;
    background: linear-gradient(0deg,#f3f3f3, #fff);
    border-bottom: 2px solid #42a01f;
  }
  .navbar-brand {
    margin-right: 1rem;
  }
  button.navbar-toggler,
  button.navbar-toggler:active,
  button.navbar-toggler:focus,
  button.navbar-toggler:hover{
    border-radius: 0!important;
    border:  none!important;
    outline: none;
  }
  .navbar-toggler img{
    width: 35px;
  }
@media screen and (max-width: 1024px) {
  .navbar-light .navbar-nav .nav-item:first-child .nav-link {
    border-left: none;
    padding-left: 0;
    box-shadow: none;
  }
  .navbar-light .navbar-nav .nav-item.active .nav-link {
    background: #f3f3f3;
  }
  
}
</style>
<script type="text/javascript">
  $(document).on('click', '.navbar-toggler', function(){
    var src = $(this).children('img').attr('src');
    console.log(src);

    if(src == '/images/menu.svg')
      $(this).children('img').attr('src', '/images/remove.png')
    else
      $(this).children('img').attr('src','/images/menu.svg');

  })
</script>
<nav class="navbar navbar-expand-lg bg-light navbar-light fixed-top">
  <div class="container">
  <!-- Brand -->
  <a class="navbar-brand" href="/" style="width: 180px;">
    <img src="{{ $site_option['firm_logo']['six'] ?? null}}" alt="">

  </a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <img src="/images/menu.svg" alt="">
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse justify-content-between" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item @if(route('index') == url()->current()) active @endif">
        <a class="nav-link" href="{{ route('index') }}">@lang('Home')</a>
      </li>
    @foreach($menu_pages as $mp)
      <li class="nav-item @if(route('page', ['alt_title' => $mp->alt_title]) == url()->current()) active @endif">
        <a class="nav-link" href="{{ route('page', ['alt_title' => $mp->alt_title]) }}">
          {{ $mp->language->title }}
        </a>
      </li>
    @endforeach
    </ul>
    <div class="d-none d-lg-block">
      <button class="btn btn-primary" data-target="#callbackModal" data-toggle="modal">
        Мы перезвоним
      </button>
      @include('layouts.site.dropdown-menu-phones')
    </div>
  </div>
</nav>