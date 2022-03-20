@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Создание каталога'])

<div class="container">
    <div class="row  mb-3">
        <div class="col-12 ">
            <a href="{{ route('catalogs.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
        </div>
    </div>
    <div class="admin-content">

@include('layouts.admin.form.form-start', ['action' => route('catalogs.store')])

@include('admin.catalogs.template')

@include('layouts.admin.form.form-end')
    </div>
</div>


@endsection
