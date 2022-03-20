@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Создание товара для каталога "'.$catalog->language->title.'"'])


<div class="container">
    <div class="row  mb-3">
        <div class="col-12 ">
            <a href="{{ route('products.index', ['catalog_id' => $catalog->id]) }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
        </div>
    </div>
    <div class="admin-content">
 
@include('layouts.admin.gallery-ajax-block', ['pictures' => $pictures])

@include('layouts.admin.form.form-start', ['action' => route('products.store')])

<input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
<input type="hidden" name="code" value="{{ $catalog->id }}">

@include('admin.products.template')

@include('layouts.admin.form.form-end')

  </div>
</div>




@endsection
