@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Редактирование каталога'])

<div class="container">
    <div class="row  mb-3">
        <div class="col-4 ">
            <a href="{{ route('catalogs.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
        </div>
    @if(auth()->user()->role == 'developer')
        <div class="col-4">
            <button class="btn btn-outline-primary transfer-pictures-button" data-class="Catalog" data-column="content" data-id="{{ $catalog->id }}">Перенос картинок контента</button>
        </div>
    @endif
    </div>
    <div class="admin-content">
 
@include('layouts.admin.form.form-start', ['action' => route('catalogs.update', ['id' => $catalog->id])])

@include('admin.catalogs.template', ['value' => $catalog])

@include('layouts.admin.form.form-end')
    </div>
</div>


@endsection
