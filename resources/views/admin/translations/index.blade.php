@extends('admin.base')

@section('content')


<div class="container" style="margin: 30px auto;">
  <div class="jumbotron">
    <h1><small>Переводы</small></h1>      
    <p>редактирование файлов перевода</p>
  </div>
  <div class="row  mb-3"> 
    <div class="col-12 ">
      <a href="{{ action('LanguagesController@index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> @lang('Back')
      </a>
    </div>
  </div>
  <div class="admin-content">
    <h2>Выберите язык с которым будете работать</h2>
    <div class="mt-5 text-center">
  @foreach($languages as $lang)
        <a href="{{ route('translations.scan.views', ['locale' => $lang->locale, 'title' => $lang->title]) }}" class="btn btn-outline-primary">{{ $lang->title }}</a>
  @endforeach
    </div>
  </div>
</div>

@endsection