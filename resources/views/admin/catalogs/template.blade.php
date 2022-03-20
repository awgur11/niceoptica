<?php

$value = $value ?? null;

?>

@include('layouts.admin.form.form-input', ['title' => 'Title', 'name' => 'title', 'required' => 'required', 'value' => $value])

@include('layouts.admin.form.form-input', ['title' => 'Для меню', 'name' => 'menu', 'required' => 'required', 'value' => $value])

@include('layouts.admin.form.form-preview-block', ['name' => 'preview', 'value' => $value])

@include('layouts.admin.form.form-textarea', ['title' => 'Content', 'name' => 'content', 'editor' => 'ckeditor', 'value' => $value])

@include('admin.catalogs.filters-block', ['filters' => $filters])

@include('layouts.admin.form.form-textarea', ['title' => 'Параметры', 'name' => 'params', 'value' => $value, 'info' => 'Перечислите параметры каталога с новой строки'])

@include('layouts.admin.seo-block', ['value' => $value])

@include('layouts.admin.form.form-checkbox', ['title' => 'Public', 'value' => 1, 'name' => 'public', 'checked' => 1, 'value' => $value])