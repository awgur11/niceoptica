<?php 
echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
 
<channel>
    <title>VannaSan</title> 
    <link>{{ url('/') }}</link> 
    <description>'Интернет-магазин VannaSan.com.ua: Сантехника, мебель для ванной и другие товары для ремонта ванной комнаты.'</description>
@foreach($products as $p)
  @foreach(['', '_ua'] as $locale)
    <item>
      <g:id>{{ $p['id'.$locale] }}</g:id>
      <title>{{ $p['title'.$locale] }}</title>
        <g:product_type>{{ $p['product_type'.$locale] }}</g:product_type>
      <g:description>{{ $p['description'.$locale] }}</g:description>
      <link>{{ $p['link'.$locale] }}</link>
      <g:image_link>{{ $p['picture'] }}</g:image_link>
      <g:availability>in stock</g:availability>
    @isset($p['price'])
      <g:price>{{ number_format($p['price'], 2, '.', '') }} UAH</g:price>
    @else
      <g:sale_price>{{ number_format($p['final_price'], 2, '.', '') }} UAH</g:sale_price>
      <g:price>{{ number_format($p['old_price'], 2, '.', '') }} UAH</g:price>
    @endif
  @if($p['brand'.$locale] != null)
      <g:brand>{{ $p['brand'.$locale] }}</g:brand>
  @endif
      <g:condition>new</g:condition>

    </item>
  @endforeach
@endforeach
</channel>
</rss>