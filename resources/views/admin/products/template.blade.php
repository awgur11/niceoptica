<?php

$value = $value ?? null;

?>

@include('layouts.admin.form.form-input', ['title' => 'Title', 'name' => 'title', 'required' => 'required'])

@include('admin.products.filters-block')

@include('admin.products.params-block')

@include('layouts.admin.form.form-textarea', ['title' => 'Полное описание товара', 'name' => 'content', 'editor' => 'ckeditor', 'value' => $value])

@include('admin.products.price-block', ['value' => $value])

@include('layouts.admin.seo-block', ['value' => $value])