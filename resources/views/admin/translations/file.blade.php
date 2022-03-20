@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Переводы', 'content' => 'Редактирвоание файла переводов <b>'.$language_title.'</b>'])

<div class="container" >
  <div class="row  mb-3">
    <div class="col-12 ">
      <a href="{{ route('languages.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Назад
      </a>
    </div>
  </div>
<script type="text/javascript">
  function translate_phrase(id, phrase)
  {
    var from = $('#from').val(),
        to = $('#to').val();

    $.ajax({
      method: 'POST',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: "{{ route('translate.one.phrase') }}",
      data: {
        from: from,
        to: to,
        phrase: phrase
      },
      success: function(response){
        $('#input-translation-' + id).val(response);
        console.log(response);
        
      },
      error: function(response){
        saved_window_show(response.responseText, false);
      }
    });
  }
  $(document).on('click', '.translate-phrase', function(){
    var id = $(this).data('id'),
        phrase = $('#input-phrase-' + id).val();

    translate_phrase(id, phrase);
  });
  $(document).on('click', '#translate-empty-button', function(){
    $('.none-transpated').each(function(index){

      var id = $(this).data('id'),
          phrase = $(this).val();

          console.log(id + ' ' + phrase);

          setTimeout(translate_phrase, index*1000, id, phrase)
    });
  });

</script>
  <div class="admin-content">
<form action="{{ route('translations.save.file')}}" method="POST">
    <div class="row">
      <div class="col-md-6 col-lg-4">
        <div class="input-group mb-3 input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text">Перевести с</span>
          </div>
          <input type="text" id="from" value="en" name="from" class="form-control">
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="input-group mb-3 input-group-sm">
          <div class="input-group-prepend">
            <span class="input-group-text">Перевести на</span>
          </div>
          <input type="text" id="to" value="{{ $locale }}" name="to" class="form-control">
        </div>
      </div>      
    </div>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>№</th>
          <th>@lang('Phrase')</th>
          <th>@lang('Translation')</th>
          <th>
            
          </th>
        </tr>
      </thead>
      <tbody>
    @foreach($file as $k => $v)
        <tr id="row-{{ $loop->iteration }}">
          <td>{{ $loop->iteration }}</td>
          <td>
            <input type="text" name="phrases[]" value="{{ $k }}" readonly class="form-control" id="input-phrase-{{ $loop->iteration }}">
          </td>
          <td>
            <input type="text" name="translations[]" value="{{ $v }}" class="form-control" id="input-translation-{{ $loop->iteration }}">
          </td>
          <td>
            <button type="button" class="btn btn-outline-primary translate-phrase" data-id="{{ $loop->iteration }}">@lang('Translate')</button>
          </td>
          <td><button type="button" class="btn btn-outline-danger delete-phrase" data-id="{{ $loop->iteration }}">@lang('Delete')</button></td>
        </tr>
    @endforeach
        <tr>
          <th colspan="4" class="text-center">None translated phrases</th>
          <td>
            <button type="button" class="btn btn-outline-success" id="translate-empty-button">Translate all</button>
          </td>
        </tr>
    @foreach($absent_phrases as $v)
        <tr id="row-{{ $loop->iteration + count($file) }}">
          <td>{{ $loop->iteration + count($file) }}</td>
          <td>
            <input type="text" name="phrases[]" value="{{ $v }}" readonly class="form-control none-transpated" id="input-phrase-{{ $loop->iteration + count($file) }}" data-id="{{ $loop->iteration + count($file) }}">
          </td>
          <td>
            <input type="text" name="translations[]" value="" class="form-control" id="input-translation-{{ $loop->iteration + count($file)}}">
          </td>
          <td>
            <button type="button" class="btn btn-outline-primary translate-phrase" data-id="{{ $loop->iteration + count($file) }}">@lang('Translate')</button>
          </td>
          <td>
            <button type="button" class="btn btn-outline-danger delete-phrase" data-id="{{ $loop->iteration + count($file) }}">@lang('Delete')</button>
          </td>
        </tr>
    @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5" class="text-center">
            <button class="btn btn-outline-success btn-lg">Записать изменения в файл</button>
          </td>
        </tr>
      </tfoot>
    </table>
</form>
  </div>


</div>
<script type="text/javascript">
  $(document).on('click', '.delete-phrase', function(){
    var id = $(this).data('id');
    $('#row-' + id).hide(500,function(){$(this).remove()});
  })
</script>







@endsection
