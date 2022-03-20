@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Дерево каталогов'])

<div class="container" >
    <div class="row justify-content-end mb-3">
        <div class="col-3" style="padding-bottom: 10px;">
            <a href="{{ route('catalogs.index') }}" class="btn btn-outline-primary"><i class="fas fa-th-list"></i> Список</a>
        </div>
        <div class="col-3 text-right" style="padding-bottom: 10px;">
            <a href="{{ route('catalogs.create') }}" class="btn btn-outline-success"><i class="far fa-plus-square"></i> Создать</a>
        </div>
    </div>
    <div class="admin-content">
        @include('layouts.admin.tree-sample', ['tree' => $tree])
    </div>
</div>
@endsection