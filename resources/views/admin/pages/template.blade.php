<?php

$value = $value ?? null;

?>

@include('layouts.admin.form.form-input', ['title' => "Заголовок", 'name' => 'title', 'required' => 'required', 'value' => $value])

@include('layouts.admin.form.form-input', ['title' => "Для меню", 'name' => 'menu', 'required' => 'required', 'value' => $value ])

@include('layouts.admin.form.form-preview-block', ['name' => 'preview', 'value' => $value,  'file_type' => 'image'])

@include('layouts.admin.form.form-textarea', ['title' => "Содержание", 'name' => 'content', 'editor' => 'ckeditor', 'value' => $value])

@include('layouts.admin.form.form-checkbox', ['title' => 'Опубликовать', 'name' => 'public', 'default' => true, 'value' => $value])

@include('layouts.admin.seo-block', ['value' => $value ])