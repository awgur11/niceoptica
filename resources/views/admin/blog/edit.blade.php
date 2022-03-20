@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Редактирование статьи'])

<div class="container" style="">
  <div class="row  mb-3">
    <div class="col-4 ">
      <a href="{{ route('pages.index', ['type' => $page->type]) }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Назад
      </a>
    </div>
  @if(auth()->user()->role == 'developer')
    <div class="col-4">
      <button class="btn btn-outline-primary transfer-pictures-button" data-class="Page" data-column="content" data-id="{{ $page->id }}">Перенос картинок контента</button>
    </div>
  @endif
  </div>
  <div class="admin-content">

@include('layouts.admin.form.form-start', ['action' => route('pages.update', ['id' => $page->id])])
 
@include('admin.blog.template', ['value' => $page])
  
@include('layouts.admin.form.form-end')
      
  </div>
</div>
<div class="container mt-5">
    @include('layouts.admin.gallery-ajax-block', ['pictures' => $page->pictures])
</div>

@endsection