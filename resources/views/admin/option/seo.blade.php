@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'SEO'])

<div class="container">
    <div class="row  mb-3">
        <div class="col-12 ">
            <a href="{{ route('admin.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> @lang('Back')
            </a>
        </div>
    </div>
    <div class="admin-content">

        @include('layouts.admin.form.form-preview-block-option', ['title' => 'Favicon', 'name' => 'favicon', 'thumbs' => 'mini', 'data_type' => 'img'])

        @include('layouts.admin.form.form-input-option', ['title' => 'Первый заголовок', 'name' => 'first_tag_title'])

        @include('layouts.admin.form.form-input-option', ['title' => 'Второй заголовок', 'name' => 'second_tag_title'])

        @include('layouts.admin.form.form-textarea-option', ['title' => 'Тег Описание', 'name' => 'tag_description'])

        @include('layouts.admin.form.form-preview-block-option', ['title' => 'Фоновый рисунок 404 страницы', 'name' => '404_bg', 'thumbs' => 'fhd', 'data_type' => 'img'])

        @include('layouts.admin.form.form-textarea-option', ['title' => 'Текст 404', 'name' => 'text_404'])

    </div>
</div>

@endsection