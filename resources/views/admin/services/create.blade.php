@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Создание страницы'])

<div class="container">
    <div class="row  mb-3">
        <div class="col-12 ">
            <a href="{{ route('pages.index', ['type' => $type]) }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
        </div>
    </div>
    <div class="admin-content">

@include('layouts.admin.form.form-start', ['action' => route('pages.store', ['type' => $type])])
 
@include('admin.pages.template')
  
@include('layouts.admin.form.form-end')

    </div>
</div>
<div class="container mt-5">
    @include('layouts.admin.gallery-ajax-block', ['pictures' => $pictures])
</div>







@endsection
