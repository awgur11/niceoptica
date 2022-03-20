@extends('admin.base')
@section('content') 



@include('layouts.admin.header', ['title' => 'Каталоги', 'content' => 'Редактирование каталогов сайта'])


<div class="container" >
  <div class="row justify-content-end mb-3">
    <div class="col-2 ">
      <a href="{{ route('catalogs.index.tree') }}" class="btn btn-outline-primary">
        <i class="fas fa-sitemap"></i> Дерево
      </a>
    </div>
    <div class="col-md-2 text-right">
      <a href="{{ route('catalogs.create') }}" class="btn btn-outline-success">
        <i class="far fa-plus-square"></i> Создать
      </a>
    </div>
    @if(auth()->id() == 1)
    <div class="col-4">
      <div class="btn btn-outline-danger" id="delete-store-button">
        @lang('Delete store')
      </div> 
    </div>
    <script>
        $(document).on('click', '#delete-store-button', function(){
 // var confirmaion_q = 'Are you sure want to delete this item?';
    var confirmaion_q = 'Are you sure want to delete store';

    confirm_var = confirm(confirmaion_q );
     if (!confirm_var) return false;
 
    $.ajax({
      method: 'GET',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: "{{ route('delete.store') }}", 
      success: function(response){
        document.location.reload(true);
      // console.log(response);
      },
      error: function(response){
        saved_window_show(response.responseText, false);
      }
    });
  });
    </script>
  @endif
  </div>
  <div class="admin-content">
    <table class="table text-center" >
      <thead>
        <tr>
          <th></th>
          <th>@lang('Picture')</th>
          <th>@lang('Title')</th>
          <th></th>
          <th>@lang('Public')</th>
          <th>На главную</th>
          <th colspan="2"></th>
        </tr>
      </thead>
      <tbody class="sorting-items" data-model="Catalog">
  @forelse($catalogs as $c)
        <tr id="item-{{$c->id}}">
          <td class="item-position @if($loop->index == 0) item-position-first @endif" data-position="{{ $c->position }}" data-column="position" data-table="catalogs" data-id="{{ $c->id }}">
            <span class="btn btn-outline-primary" data-toggle="tooltip" title="Вы можете двигать этот блок"><i class="fas fa-arrows-alt"></i></span>
          </td>
          <td>
            <img src="{{ asset($c->five_preview) }}" width="100px" />
          </td>
          <td>
            {{ $c->language->title }}
            @if($c->parent != null)
                <br> ({{ $c->parent->language->title }})
            @endif
          </td>
          <td>
            <a href="{{ route('products.index', ['catalog_id' => $c->id]) }}" class="btn btn-outline-success"><i class="fas fa-list"></i> Товары {!! $c->products_count != 0 ? '<span class="badge badge-success">'.$c->products_count.'</span>' : '' !!}</a>
          </td>
          <td class="text-center">
            <input type="checkbox" value="1" name="public" class="change_checkbox_ajax" data-id="{{ $c->id }}" data-table="catalogs" data-column="public" @if($c->public == 1) checked @endif>
          </td>
          <td class="text-center">
            <input type="checkbox" value="1" name="home_page" class="change_checkbox_ajax" data-id="{{ $c->id }}" data-table="catalogs" data-column="home_page" @if($c->home_page == 1) checked @endif>
          </td>
          <td>
            <a href="{{ route('catalogs.edit', ['id' => $c->id]) }}" class="btn btn-outline-primary "><i class="fas fa-pencil-alt"></i></a>
          </td>
          <td> 
            <span class="btn btn-outline-danger delete-item" data-url="{{ route('catalogs.delete', ['id' => $c->id]) }}" data-id="{{$c->id}}"><i class="far fa-trash-alt"></i></span>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6">
            <h3 class="text-warning text-center">@lang('Empty')</h3>
          </td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection