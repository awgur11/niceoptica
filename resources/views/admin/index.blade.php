@extends('admin.base')

@section('content')
<style type="text/css">
  #main-admin-table td{
    vertical-align: middle;
  }

</style>

@include('layouts.admin.header', ['title' => 'Основные разделы сайта'])

<?php

$items = [
  [
    'title' => 'Страницы',
    'content' => 'Создание/редактирование страниц сайта',
    'link' => route('pages.index', ['type' => 'pages']),
    'icon' => '<i class="far fa-newspaper"></i>',
    'roles' => ['admin', 'developer'],
  ],
  [
    'title' => 'Категории блога',
    'content' => 'Создание категорий для блога',
    'link' => route('items.index', ['type' => 'categories']),
    'icon' => '<i class="fas fa-folder-open"></i>',
    'roles' => ['admin', 'developer'],
  ],
  [
    'title' => 'Блог',
    'content' => 'Создание/редактирование новостей',
    'link' => route('pages.index', ['type' => 'blog']),
    'icon' => '<i class="far fa-newspaper"></i>',
    'roles' => ['admin', 'developer'],
  ],
  [
    'title' => 'Каталоги',
    'content' => 'Создание/редактирование каталогов сайта',
    'link' => route('catalogs.index'),
    'icon' => '<i class="fas fa-folder-open"></i>',
    'roles' => ['admin', 'developer'],
  ],
  [
    'title' => 'Фильтры и значения',
    'content' => 'Создание/редактирование фильтров и их значений',
    'link' => route('filters.index'),
    'icon' => '<i class="fas fa-filter"></i>',
    'roles' => ['admin', 'developer'],
  ],
  [
    'title' => 'Языки',
    'content' => 'Создание/редактирование основных языков сайта',
    'link' => route('languages.index'),
    'icon' => '<i class="fas fa-language"></i>',
    'roles' => ['developer'],
  ],
  [
    'title' => 'Слайдер',
    'content' => 'Редактирование слайдера на главной странице',
    'link' => route('items.index', ['type' => 'slider']),
    'icon' => '<i class="far fa-images"></i>',
    'roles' => ['admin', 'developer'],
  ],

  [
    'title' => 'Карта лояльности',
    'content' => 'Создание логики для карты лояльности',
    'link' => route('items.index', ['type' => 'loyalty']),
    'icon' => '<i class="far fa-images"></i>',
    'roles' => ['admin', 'developer'],
  ],
  [
    'title' => 'Бренды',
    'content' => 'Добавление логотипов брендов в карусель на главной странице',
    'link' => route('items.index', ['type' => 'brands']),
    'icon' => '<i class="fab fa-wordpress"></i>',
    'roles' => ['developer'],
  ],
/*  [
    'title' => 'Оформление',
    'content' => 'Редактирование заголовков, изображений и др',
    'link' => route('option.index', ['page' => 'design']),
    'icon' => '<i class="fas fa-desktop"></i>',
    'roles' => ['admin', 'developer'],
  ],
  [
    'title' => 'Доступ',
    'content' => 'Редактирование имени и почты администратора, а так же изменение пароля',
    'link' => route('option.index', ['page' => 'dostup']),
    'icon' => '<i class="fas fa-user"></i>',
    'roles' => ['admin', 'developer'],
  ], */
  [
    'title' => 'Контакты',
    'content' => 'Редактирование контактов',
    'link' => route('option.index', ['page' => 'contacts']),
    'icon' => '<i class="far fa-address-book"></i>',
    'roles' => ['admin', 'developer'],
  ],
 
  [
    'title' => 'Преимущества',
    'content' => "Иконки на странице товара с возможностью добавить ссылку на любую страницу",
    'link' => route('items.index', ['type' => 'advs']),
    'icon' => '<i class="icon-Flash"></i>',
    'roles' => ['admin', 'developer'],
  ],
  [
    'badge' => $unchecked_comments_count > 0 ? '<span class="badge badge-light">'.$unchecked_comments_count.'</span>' : null,
    'btn' => $unchecked_comments_count > 0 ? 'btn-warning' : 'btn-outline-primary',
    'title' => 'Comments',
    'content' => 'Публикация либо удаление комментариев пользователей',
    'link' => route('comments.unchecked'),
    'icon' => '<i class="far fa-comments"></i>',
    'roles' => ['admin', 'developer'],
  ],


  [
    'title' => 'СЕО',
    'content' => 'Элементы сайта, необходимые для продвижения',
    'link' => route('option.index', ['page' => 'seo']),
    'icon' => '<i class="fab fa-buromobelexperte"></i>',
    'roles' => ['admin', 'developer'],
  ],
/*  [
    'title' => 'Parser',
    'content' => 'Parsing sites',
    'link' => route('parser.index'),
    'icon' => '<i class="fas fa-bong"></i>',
    'roles' => ['developer'],
  ], */
  [
    'title' => __('Orders'),
    'content' => __('Orders list'),
    'link' => route('orders.index'),
    'icon' => '<i class="fas fa-briefcase"></i>',
    'roles' => ['admin', 'developer'],
  ],
];

?>

<div class="container">
  <div class="admin-content">
  	<table class="table" id="main-admin-table">
  @foreach($items as $item)
    @if(in_array(auth()->user()->role, $item['roles']))
      <tr>
        <td>
          <a href="{{ $item['link'] }}" class="btn {{ $item['btn'] ?? 'btn-outline-primary' }}">
            {!! $item['icon'] !!} {{ $item['title'] }}
            {!! $item['badge'] ?? null !!}
          </a>
        </td>
        <td>
          {{ $item['content'] }}
        </td>
      </tr>
    @endif
  @endforeach

  	</table>
  </div>
</div>


@endsection