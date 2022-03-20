<nav class="navbar navbar-expand-md navbar-light bg-light md-3">
  <div class="container">
  <a class="navbar-brand" href="{{ route('admin.index') }}"><b>Админка</b></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-between" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          <i class="fas fa-cogs"></i> Настройки
        </a>
        <div class="dropdown-menu">
          <a href="/" class="dropdown-item"><i class="fas fa-user"></i> Доступ</a>
          <a href="/icons-demo/demo.html" target="_blank" class="dropdown-item">Иконки</a>
        </div>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="nav-item">
        <a href="{{ url('/') }}" class="nav-link"><i class="fas fa-binoculars"></i> Сайт</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
          <i class="fas fa-sign-out-alt"></i> Выход
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </li>
    </ul>
  </div>  
  </div>
</nav>

