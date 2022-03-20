@extends('admin.base')

@section('content')

<script type="text/javascript">
  $(document).on('click', '.create-item-button', function(){
    var data = $(this).data(),
        lang_fields = ['text1', 'text2', 'text3'],
        langs = ['ru', 'ua', 'en'];

    langs.forEach(function(lang){
      lang_fields.forEach(function(lf){
        if(tinymce.get('languages-' + lf + '-' + lang) != null)          
          tinymce.get('languages-' + lf + '-' + lang).setContent('');
      });
    });

    $('#itemModal h5').text(data.modal_title);
    $('#itemModal form').attr('action', data.action);
    $('#itemModal #public').prop('checked', false);

    $('#itemModal input.form-control, #itemModal textarea.form-control').val('');
    $('#itemModal img').attr('src', "{{ asset('storage/images/no-photo.jpg') }}");
  });

  $(document).on('click', '.edit-item-button', function(){
    var data = $(this).data();

    $('#itemModal h5').text(data.modal_title);
    $('#itemModal form').attr('action', data.action);

    console.log(data.edit);

    $.ajax({
      url: data.edit,
      method: 'GET',
      data:{
        ajax: 'ajax',
      },
      dataType: 'json',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      error: function(error){
        console.log(error);

      },
      success: function(data){
        var lang_fields = ['title', 'string1', 'string2', 'string3', 'text1', 'text2', 'text3'],
            fields = ['nol1', 'nol2', 'nol3'];

        fields.forEach(function(el){
          if($('#itemModal #' + el).length > 0)
            $('#itemModal #' + el).val(data[el]);
        });

        $('#itemModal img').attr('src', data.mini_preview);

        if(data.preview_path != null)
          $('#delete-picture-checkbox-block').removeClass('d-none');
        else
          $('#delete-picture-checkbox-block').addClass('d-none');
    
        data.languages.forEach(function(el, key){
          
          lang_fields.forEach(function(field){

            if($('#itemModal #languages-' + field + '-' + el.language).length > 0)
              $('#itemModal #languages-' + field + '-' + el.language).val(el[field]);

            if(tinymce.get('languages-' + field + '-' + el.language) != null)          
              tinymce.get('languages-' + field + '-' + el.language).setContent(el.text1);
          });
        });
        if(data.public)
          $('#itemModal #public').prop('checked', true);
        else
          $('#itemModal #public').prop('checked', false);
      }
    });
  });
</script>

@include('layouts.admin.header', ['title' => 'We are experts', 'content' => 'Добавление редактирование блоков в разделе "We are experts"'])

<div class="container">
<!-- include('layouts.admin.search-block') -->
  <div class="row justify-content-end mb-3">
    <div class="col-2 text-right">
    <button  class="btn btn-outline-success create-item-button" data-toggle="modal" data-target="#itemModal" data-modal_title="Создать элемент" data-action="{{ route('items.store', ['type' => $type]) }}"><i class="far fa-plus-square"></i> @lang('Create')</button>
   <!-- <a href="{{ route('items.create', ['type' => 'items']) }}" class="btn btn-outline-success"><i class="far fa-plus-square"></i> @lang('Create')</a>-->
    </div>
  </div>
  <div class="admin-content">
    <table class="table text-center" id="sortable-table">
        <thead class="table-info">
          <tr>
            <th></th>
            <th>@lang("Picture")</th>
            <th>@lang("Title")</th>
            <th>@lang("Public")</th>
            <th colspan="2"></th>
          </tr>
        </thead>
        <tbody >
@if($items->count() == 0)
          <tr >
            <td colspan="8">
	            <h3 class="text-warning text-center">@lang("Empty")</h3>
            </td>
          </tr>
@else
  @foreach($items as $ki => $item)
          <tr id="item-{{$item->id }}" >
            <td class="item-position @if($loop->index == 0) item-position-first @endif" data-position="{{ $item->position }}" data-table="items" data-id="{{ $item->id }}">
              <span class="btn btn-outline-primary" data-toggle="tooltip" title="@lang('You can this move row')"><i class="fas fa-arrows-alt"></i></span>
            </td>
            <td><img src="{{ asset($item->mini_preview) }}" style="border-radius: 5px; max-width:100px; max-height:100px;" /></td>
            <td>{{ $item->language->title ?? null }}</td>
            <td>
              <input type="checkbox" value="1" name="public" class="change_checkbox_ajax" data-id="{{ $item->id }}" data-table="items" data-column="public" @if($item->public == 1) checked @endif>
            </td>
   
            <td>
       <button class="btn btn-outline-primary edit-item edit-item-button" data-toggle="modal" data-target="#itemModal" data-modal_title="@lang('Updating item')" data-action="{{ route('items.update', ['id' => $item->id]) }}" data-edit="{{ route('items.edit', ['type' => $type, 'id' => $item->id]) }}"><i class="fas fa-pencil-alt"></i></button>
            <!--   <a href="{{ route('items.edit', ['id' => $item->id, 'type' => $type]) }}" class="btn btn-outline-primary">
                 @lang('Edit')
               </a>-->
            </td>
            <td> <span class="btn btn-outline-danger delete-item" data-url="{{ route('items.delete', ['id' => $item->id])}}" data-id="{{ $item->id }}"><i class="far fa-trash-alt"></i></span></td>
          </tr>
   @endforeach
@endif    
        </tbody>
      </table>
      <div class="col-sm-12 text-center">
        {{ $items->links() }}
      </div>
    </div>
  </div>
</div>


<!-- MODAL -->
<div id="itemModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
    <div class="modal-content col-sm-12" style="padding:0;">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
            <div class="modal-body block-body ">
  
@include('layouts.admin.form.form-start')
  
@include('layouts.admin.form.form-preview-block', ['title' => 'Slide', 'name' => 'preview', 'value' => NULL])

@include('layouts.admin.form.form-input', ['title' => 'Title', 'name' => 'title', 'value' => NULL])

@include('layouts.admin.form.form-textarea', ['title' => 'Description', 'name' => 'text1'])

@include('layouts.admin.form.form-checkbox', ['label' => 'Public', 'title' => 'Опубликовать', 'name' => 'public', 'checked' => true, 'value' => NULL])
  
@include('layouts.admin.form.form-end')
            
            </div>
        </div>
    </div>
</div>
<!--  CKEDITOR.instances['languages-text1' + '-' + el.language].setData(el.text1);-->
@endsection