<?php

  $route_name = Request::route() != null ? Request::route()->getName() : NULL;
  $tag_title = $site_option['first_tag_title'];
  $tag_description = $site_option['tag_description'];

  if($route_name == 'index')
  {
    $tag_title .= ' | '.$site_option['second_tag_title'];

    $tag_description = $site_option['tag_description'];
  }
  elseif($route_name == 'page')
  {
    if(!isset($page))
      $tag_title = 'error 404';
    else
    {
      $tag_title .= ' | '.$page->language->title;

      if($page->language->description != null)
        $tag_description = $page->language->description;
    }
  }
  elseif($route_name == 'products')
  {
    if(!isset($catalog) || $catalog == null)
      $tag_title = 'error 404';
    else
    {
      $tag_title = $site_option['first_tag_title'].' | '.$catalog->language->title;

      if($catalog->language->description != null)
        $tag_description = $catalog->language->description;
    }
  }
  elseif($route_name == 'product')
  {
    if(!isset($product) || $product == null)
      $tag_title = 'error 404';
    else
    {
      $tag_title = $site_option['first_tag_title'].' | '.$product->language->title;

      if($product->language->description != null)
        $tag_description = $product->language->description;
    }
  }
?>

<title>{{ $tag_title ?? null }}</title>

<meta name="description" content="{{ $tag_description ?? null}}" />

