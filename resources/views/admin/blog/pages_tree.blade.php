@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Дерево страниц'])

<div class="container" >
    <div class="row justify-content-end mb-3">
		<div class="col-3" style="padding-bottom: 10px;">
            <a href="{{ route('pages.index', ['type' => $type]) }}" class="btn btn-outline-primary"><i class="fas fa-th-list"></i> Список</a>
        </div>
		<div class="col-3 text-right" style="padding-bottom: 10px;">
	        <a href="{{ route('pages.create', ['type' => $type]) }}" class="btn btn-outline-success"><i class="far fa-plus-square"></i> Создать</a>
	    </div>
	</div>
	<div class="admin-content">
        @include('layouts.admin.tree-sample', ['tree' => $tree])
	</div>
</div>
@endsection