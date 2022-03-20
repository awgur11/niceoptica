@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Редактирование товара для каталога "'.$catalog->language->title.'"'])


<div class="container">
    <div class="row  mb-3">
        <div class="col-12 ">
            <a href="{{ route('products.index', ['catalog_id' => $catalog->id]) }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
        </div>
    </div>
    <div class="admin-content">
 
@include('layouts.admin.gallery-ajax-block', ['pictures' => $product->pictures])

@include('layouts.admin.form.form-start', ['action' => route('products.update', ['id' => $product->id])])

<input type="hidden" name="catalog_id" value="{{ $catalog->id }}">

@include('admin.products.template', ['value' => $product])

@include('layouts.admin.form.form-end')

<div class="form-control row">
    <div class="col-12">
        @foreach($product->files as $file)
        
            <a href="{{ asset('storage/files'.$file->preview_path.$file->preview_name) }}">link</a>
        @endforeach
    </div>
</div>

  </div>
</div>




@endsection
