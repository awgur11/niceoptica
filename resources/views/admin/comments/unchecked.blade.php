@extends('admin.base')
@section('content')
<style type="text/css">
  .article-title-cell{
    max-width: 150px;
    overflow: hidden;
  }
</style>

@include('layouts.admin.header', ['title' => 'Комментарии', 'content' => 'Публикация либо удаление комментариев пользователей'])

<div class="container-fluid" style="margin-top: 30px; ">
  <div class="row">
    <div class="col-sm-12 text-right mb-3">
      <a class="btn btn-outline-primary" href="{{ route('comments.checked') }}"><i class="fas fa-upload"></i> Опубликовать всё</a>
    </div>
    <div class="col-sm-12">
      <table class="table categories-list-table ">
        <thead>
          <tr class="table-info">
            <th ></th>
            <th>@lang('Name')</th>
            <th>Email</th>
            <th>@lang('Comments')</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
@forelse($comments as $comment)
          <tr id="item-{{$comment->id}}" @if($comment->status == 0) class='table-warning' @endif>
            <td> 
              <span class="btn btn-outline-danger btn-sm delete-item" data-url="{{ route('comments.delete', ['id' => $comment->id])}}" data-id="{{ $comment->id }}" data-toggle="tooltip" title="@lang('Delete')"><i class="far fa-trash-alt"></i></span>
            </td>
            <td>{{ $comment->name }}</td>
            <td>{{ $comment->email }}</td>
            <td style="width: 50%;">{{ $comment->comment }}</td>
            <td class="article-title-cell">
              {{$comment->page->title ?? null}}
            </td>
          </tr>
@empty
          <tr>
            <td colspan="5">
              <h3 class="text-warning text-center">@lang('Empty')</h3>
            </td>
          </tr>
@endforelse
          <tr>
             <td colspan='5' class="text-center">{{$comments->links()}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection