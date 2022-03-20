@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Новости', 'content' => 'Список статей блога'])

<div class="container" >
  <div class="row justify-content-end mb-3">
    <div class="col-2 ">
    <!--  <a href="{{ route('pages.index.tree', ['type' => $type]) }}" class="btn btn-outline-primary">
        <i class="fas fa-sitemap"></i> Дерево
      </a>-->
    </div>
	  <div class="col-md-2 text-right">
	    <a href="{{ route('pages.create', ['type' => $type]) }}" class="btn btn-outline-success">
        <i class="far fa-plus-square"></i> Создать
      </a>
	  </div>
  </div>
  <div class="admin-content">
    <table class="table text-center" >
      <thead class="table-info">
        <tr>

          <th class="text-center">Изображение</th>
          <th class="text-center">Заголовок</th>
          <th class="text-center">Опубликовать</th>
          <th colspan="2"></th>
        </tr>
      </thead>
      <tbody   data-model="Page">
@if($pages->count() == 0)
        <tr>
          <td colspan="6">
	          <h3 class="text-warning text-center">Пусто</h3>
          </td>
        </tr>
@endif
@foreach($pages as $page)
        <tr id="item-{{$page->id}}">

          <td>
            <img src="{{ $page->five_preview }}" width="100px" max-height="100px" />
          </td>
          <td>
            {{ $page->language->title ?? null }}
          </td>
          <td class="text-center">
            <input type="checkbox" value="1" name="public" class="change_checkbox_ajax" data-id="{{ $page->id }}" data-table="pages" data-column="public" @if($page->public == 1) checked @endif>
          </td>
          <td> 
            <a href="{{ route('pages.edit', ['id' => $page->id]) }}" class="btn btn-outline-primary "><i class="fas fa-pencil-alt"></i></a>
          </td>
          <td> 
            <span class="btn btn-outline-danger delete-item" data-url="{{ route('pages.delete', ['id' => $page->id]) }}" data-id="{{ $page->id }}"><i class="far fa-trash-alt"></i></span>
          </td>
        </tr>
@endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="6">
           {{ $pages->appends(app('request')->input())->links() }}
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
@endsection