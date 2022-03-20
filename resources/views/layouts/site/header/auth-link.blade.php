@auth
<a href="{{ route('cabinet.user.data') }}" class="auth-link header-icon-link d-block">
    <i class="icon-Business-Man" style=""></i>
</a>
@else
<div class="auth-link header-icon-link d-block" style="cursor: pointer;"  data-toggle="modal" data-target="#authModal">
    <i class="icon-Business-Man" style=""></i>
</div>
@endif