@extends('admin.base')

@section('content')
<style type="text/css">
  td{
    background-color: #fff;
  }
</style>

@include('layouts.admin.header', ['title' => 'Языки сайта'])
<div class="container">
  <div class="row justify-content-end mb-3">
    <div class="col-2 text-right">
      <button  class="btn btn-primary edit-item" data-toggle="modal" data-target="#formModal" data-modal_title="Добавить язык" data-action="{{ route('languages.store') }}" data-title="" data-shot="" data-locale="">
        <i class="far fa-plus-square"></i> Добавить
      </button>
    </div>
  </div>
  <div class="admin-content">
    <table class="table text-center table-hover">  
      <thead>
        <tr class="table-info">
          <th></th>
          <th>Заголовок</th>
          <th>Кратко</th>
          <th>Локаль</th>
          <th>Вкл/Выкл</th>
          <th colspan="3"></th>
        </tr>
      </thead>
      <tbody class="sorting-items" data-model="Language">
@if($languages->count() == 0)
        <tr >
          <td colspan="7">
	          <h3 class="text-warning text-center">@lang("Empty")</h3>
          </td>
        </tr>
@else
@foreach($languages as $ki => $vi)
        <tr id="item-{{$vi->id }}" >
          <td class="item-position @if($loop->index == 0) item-position-first @endif" data-position="{{ $vi->position }}" data-table="languages" data-id="{{ $vi->id }}" data-column="position">
            <span class="btn btn-outline-primary" data-toggle="tooltip" title="@lang('You can this move row')"><i class="fas fa-arrows-alt"></i></span>
          </td>
          <td>
            {{ $vi->title }}
          </td>
          <td>
            {{ $vi->shot }}
          </td>
          <td>
            {{ $vi->locale }}
          </td>
          <td>
    @if(config('app.fallback_locale') == $vi->locale)
            <b class="text-success">Основной</b>
    @else
            <label class="checkbox-inline"><input type="checkbox" value="1" name="turnon" class="change_checkbox_ajax" data-id="{{ $vi->id }}" data-table="languages" data-column="turnon" data-value="1" @if($vi->turnon == 1) checked @endif></label>
    @endif 
          </td>
          <td>
            <a href="{{ route('translations.scan.views', ['locale' => $vi->locale, 'title' => $vi->title]) }}" class="btn btn-info"><i class="fas fa-wrench"></i></a>
          </td>
          <td>
            <button class="btn btn-outline-primary edit-item" data-toggle="modal" data-target="#formModal" data-modal_title="Редатировать язык" data-action="{{ route('languages.update', ['id' => $vi->id]) }}" data-title="{{ $vi->title }}" data-shot="{{ $vi->shot }}" data-locale="{{ $vi->locale }}">
            <i class="fas fa-pencil-alt"></i> </button>
          </td>
          <td> 
    @if(App::getLocale() != $vi->locale)
            <span class="btn btn-outline-danger delete-item" data-url="{{ route('languages.delete', ['id' => $vi->id]) }}" data-id="{{ $vi->id }}"><i class="far fa-trash-alt"></i> </span>
    @endif
          </td>
        </tr>
   @endforeach
      </tbody>
@endif    
      <tfoot>
        <tr>
          <td colspan="7" class="text-center">
            <a href="/" class="btn btn-outline-primary">Переводы</a>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<script type="text/javascript">
  $(document).on('click', '.edit-item', function(){
    var data = $(this).data(),
        fields = ['title', 'shot', 'locale'];

    $('#formModal h5').text(data.modal_title);
    $('#formModal form').attr('action', data.action);

    fields.forEach(function(el){
      console.log(el);
      $('#formModal #' + el).val(data[el]);

    });
  });
</script>

<!-- ADD SLIDE -->
<div id="formModal" class="modal fade" role="dialog" aria-labelledby="formModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <!-- Modal content-->
    <div class="modal-content" >
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Добавить язык</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body block-body ">

@include('layouts.admin.form.form-start', ['action' => route('languages.store') ])
  
@include('layouts.admin.form.form-input', ['title' => 'Заголовок', 'name' => 'title', 'required' => 'required', 'maxlength' => 50, 'languages' => false])

@include('layouts.admin.form.form-input', ['title' => 'Кратко', 'name' => 'shot', 'required' => 'required', 'maxlength' => 3, 'languages' => false])

@include('layouts.admin.form.form-input', ['title' => 'Локаль', 'name' => 'locale', 'required' => 'required', 'maxlength' => 2, 'languages' => false])
  
@include('layouts.admin.form.form-end')
            
      </div>
    </div>
  </div>
</div>






@endsection