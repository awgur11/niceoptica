@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Контакты'])

<div class="container">
    <div class="row  mb-3">
        <div class="col-12 ">
            <a href="{{ route('admin.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> @lang('Back')
            </a>
        </div>
    </div>
    <div class="admin-content">

@include('layouts.admin.form.form-phones2-option')
 
@include('layouts.admin.form.form-input-option', ['title' => 'Почта для отображения на сайте', 'type' => 'email', 'name' => 'site_email', 'languages' => false])

@include('layouts.admin.form.form-input-option', ['title' => 'Время работы',  'name' => 'working_time'])

@include('layouts.admin.form.form-input-option', ['title' => 'Адрес',  'name' => 'address'])

@include('layouts.admin.form.form-textarea-option', ['title' => 'Карта',  'name' => 'map', 'languages' => false])

@include('layouts.admin.form.form-input-option', ['title' => 'Почта для получения сообщений с сайта', 'name' => 'admin_email', 'languages' => false, 'note' => 'Перечислите почтовые ящики через запятую'])

@include('layouts.admin.form.form-socialites-option')

    </div>
</div>

@endsection