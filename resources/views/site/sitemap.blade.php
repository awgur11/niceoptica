<?php 
echo '<?xml version="1.0" encoding="UTF-8"?>';?>
		<!--	created with www.mysitemapgenerator.com	-->
		<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

@foreach($locales as $locale)

@foreach($pages->where('type', 'pages') as $page)
  <url>
    <loc>{{ url($locale.'/'.$page->alt_title) }}</loc>
    <lastmod>{{date('c', strtotime($page->created_at))}}</lastmod>
    <changefreq>weekly</changefreq>
  </url>
@endforeach

@foreach($catalogs as $catalog)
  <url>
    <loc>{{ url($locale.'/products/'.$catalog->id.'-'.$catalog->alt_title) }}</loc>
    <lastmod>{{date('c', strtotime($catalog->created_at))}}</lastmod>
    <changefreq>weekly</changefreq>
  </url>
@endforeach

@foreach($products as $product)
  <url>
    <loc>{{ url($locale.'/products/'.$product->catalog->id.'-'.$product->catalog->alt_title.'/'.$product->id.'-'.$product->alt_title) }}</loc>
    <lastmod>{{date('c', strtotime($product->created_at))}}</lastmod>
    <changefreq>weekly</changefreq>
  </url>
@endforeach

@endforeach
</urlset>