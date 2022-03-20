@extends('admin.base')

@section('content')

<div class="container" style="margin: 30px auto;">
  <div class="jumbotron">
    <h1><small>Редактировать элемента</small></h1>      
  <!--<p></p> --> 
  </div> 
  <div class="row  mb-3">
    <div class="col-12 ">
      <a href="{{action('ItemsController@index', ['type' => $type, 'page' => app('request')->input('return_back_page')])}}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Назад
      </a>
    </div>
  </div>
  <div class="admin-content">

@include('layouts.admin.form.form-start', ['action' => route('items.update', ['id' => $item->id])])

@include('layouts.admin.form.form-preview-block', ['title' => 'Изображение', 'name' => 'preview', 'value' => $item])

@include('layouts.admin.form.form-input', ['title' => 'Title', 'name' => 'title', 'value' => $item])

@include('layouts.admin.form.form-array')

@include('layouts.admin.form.form-textarea', ['title' => 'Description', 'name' => 'text1', 'editor' => 'tinymce', 'value' => $item])

@include('layouts.admin.form.form-checkbox', ['label' => 'Public', 'name' => 'public', 'checked' => true])
  
@include('layouts.admin.form.form-end')

</div>







@endsection
