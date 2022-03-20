@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Оформление'])

<div class="container">
    <div class="row  mb-3">
        <div class="col-12 ">
            <a href="{{ route('admin.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> @lang('Back')
            </a>
        </div>
    </div>
    <div class="admin-content">

@include('layouts.admin.form.form-preview-block-option', ['title' => 'file', 'name' => 'test_file',  'file_type' => 'image', 'max_file_size' => 30, 'thumbs' => 'one, 333'])

@include('layouts.admin.form.form-preview-block-option', ['title' => 'Логотип', 'name' => 'firm_logo', 'thumbs' => 'four, five', 'data_type' => 'image'])

@include('layouts.admin.form.form-preview-block-option', ['title' => 'Логотип', 'name' => 'firm_logo1', 'thumbs' => 'four, five', 'data_type' => 'image'])

@include('layouts.admin.form.form-input-option', ['title' => 'Заголовок каталогов на главной странице', 'name' => 'catalogs_title'])

@include('layouts.admin.form.form-input-option', ['title' => 'Заголовок карусели новинок', 'name' => 'novelty_title'])

@include('layouts.admin.form.form-input-option', ['title' => 'Заголовок карусели топ продаж', 'name' => 'promo_title'])

@include('layouts.admin.form.form-input-option', ['title' => 'Заголовок блока "Полезные советы"', 'name' => 'advices_title'])

@include('layouts.admin.form.form-input-option', ['title' => 'Заголовок блока преимуществ на главной странице', 'name' => 'advs_title'])

<h3 class="text-center">
    Блок "Посоветуйтесь с инженером"
</h3>

@include('layouts.admin.form.form-input-option', ['title' => 'Заголовок ', 'name' => 'ing_block_title'])

@include('layouts.admin.form.form-input-option', ['title' => 'Заголовок ', 'name' => 'ing_block_subtitle'])

@include('layouts.admin.form.form-preview-block-option', ['title' => 'Картинка', 'name' => 'ing_block_img', 'thumbs' => 'five, mini', 'data_type' => 'image'])

@include('layouts.admin.form.form-preview-block-option', ['title' => 'Фон', 'name' => 'ing_block_bg', 'thumbs' => 'fhd, one, mini', 'data_type' => 'image'])

@include('layouts.admin.form.form-textarea-option', ['title' => 'Текстовый блок на главной странице', 'name' => 'index_text_block', 'editor' => 'ckeditor'])


<h3 class="text-center">
    Страница товара
</h3>

@include('layouts.admin.form.form-textarea-option', ['title' => 'Инфо о доставке', 'name' => 'product_delivery_data', 'editor' => 'ckeditor'])

@include('layouts.admin.form.form-textarea-option', ['title' => 'Инфо о гарантии', 'name' => 'product_warranty_data', 'editor' => 'ckeditor'])

@include('layouts.admin.form.form-textarea-option', ['title' => 'Инфо об оплате', 'name' => 'product_payment_data', 'editor' => 'ckeditor'])

<h3 class="text-center">
    Блок "Заказать звонок"
</h3>

@include('layouts.admin.form.form-input-option', ['title' => 'Заголовок над кнопкой', 'name' => 'cbb_title'])

@include('layouts.admin.form.form-preview-block-option', ['title' => 'Фоновый рисунок ', 'name' => 'cbb_bg', 'thumbs' => 'one', 'data_type' => 'image'])

@include('layouts.admin.form.form-input-option', ['title' => 'Заголовок модуля формы обратной связи и кнопки', 'name' => 'cbb_modal_title'])

@include('layouts.admin.form.form-input-option', ['title' => 'Текст ответа при отправке формы', 'name' => 'cbb_modal_answer'])

<h3 class="text-center">
    Корзина
</h3>

@include('layouts.admin.form.form-textarea-option', ['title' => 'Текстовый блок на странице корзины', 'name' => 'cart_text_block', 'editor' => 'ckeditor'])
<!--
<h3 class="text-center">
    Блок "О нас"
</h3>

@include('layouts.admin.form.form-input-option', ['title' => 'Заголовок', 'name' => 'aboutme_title'])

@include('layouts.admin.form.form-input-option', ['title' => 'Подзаголовок', 'name' => 'aboutme_exp'])

@include('layouts.admin.form.form-textarea-option', ['title' => 'Текст', 'name' => 'aboutme_text'])

@include('layouts.admin.form.form-input-option', ['title' => 'ссылка на страницу', 'name' => 'aboutus_link', 'languages' => false])

@include('layouts.admin.form.form-preview-block-option', ['title' => 'Фоновый рисунок ', 'name' => 'aboutus_photo', 'thumbs' => 'one', 'data_type' => 'image'])
-->

<h3 class="text-center">
    Блок "Комментарии"
</h3>

@include('layouts.admin.form.form-input-option', ['title' => 'Заголовок блока', 'name' => 'ccb_title'])

@include('layouts.admin.form.form-input-option', ['title' => 'Заголовок формы', 'name' => 'cfm_title'])

@include('layouts.admin.form.form-input-option', ['title' => 'Ответ формы', 'name' => 'cfm_answer'])



<h3 class="text-center">
    Страница заказа
</h3>
<h5 class="text-center">
    Успешное завершение заказа
</h5>

@include('layouts.admin.form.form-input-option', ['title' => 'Сообшение', 'name' => 'order_success_note'])

@include('layouts.admin.form.form-preview-block-option', ['title' => 'Изображение', 'name' => 'order_success_img', 'thumbs' => 'two', 'data_type' => 'image'])

<h5 class="text-center">
    Ошибка при выполнении заказа
</h5>

@include('layouts.admin.form.form-input-option', ['title' => 'Сообшение', 'name' => 'order_fail_note'])

@include('layouts.admin.form.form-preview-block-option', ['title' => 'Изображение', 'name' => 'order_fail_img', 'thumbs' => 'two', 'data_type' => 'image'])

    </div>
</div>

@endsection