<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\Parser;
use App\Models\Catalog;
use App\Models\Product;
use App\Models\Filter;
use App\Models\Fvalue;
use Sunra\PhpSimple\HtmlDomParser;
use App\Http\Services\PictureService;
use Illuminate\Support\Facades\Cache;

class ParserService
{
	public function __construct()
	{
 
	}

	public static function factory()
	{
		return new ParserService();
	}

	public function saveProduct($link, $catalog_id)
	{
		$response = [
            'success' => true,
            'errors' => ''
        ];

        $product = [];

        $product['catalog_id'] = $catalog_id;

        $catalog = Catalog::find($product['catalog_id']);

        $link = $link;

        try{
           $document = HtmlDomParser::file_get_html($link);
        } catch (\Exception $e) {

            $response = [
                'success' => false,
                'errors' => $e->getMessage(),
            ];

            return $response;
        }   
        $product['languages'][0]['language'] = 'ru';
        $product['languages'][0]['title'] = trim($document->find('h1', 0)->plaintext);
        $product['alt_title'] = alt_title($product['languages'][0]['title']);


        //определяем блок с описанием товара и, если есть, извлекаем
/*        $item_list = $document->find('.js-product-tabs li');

        foreach($item_list as $is)
        {
            if(trim($is->plaintext) == 'Описание')
            {
                $content_id = $is->find('a', 0)->href;
                $product['languages'][0]['content'] = $document->find($content_id, 0)->innertext;
                break;
            }
        }
*/
        /*PRICE*/
 /*       $product['price'] = $document->find('.price-block', 0) != null ? $document->find('.price-block', 0)->plaintext : 0;

        $product['price'] = (int) str_replace(['₽', ' '], '', $product['price']);

        $product['price'] = round($product['price']/2.5, -1);
        $product['final_price'] = $product['price']; */
        $product['price'] = 100;
        $product['final_price'] = 100;

        /*FILTERS AND VALUES*/
        $fvalue_ids = array();

        //собираем все фильтры и значения с сайта
        $site_filters_arr = [];

        $lines = $document->find('.itm-props-lst tr');

        foreach($lines as $line)
        {
            $filter_title = trim($line->find('td', 0)->plaintext);

            if($filter_title == 'Количество в упаковке (шт)')
                continue;

            if($filter_title == 'Бренд/Производитель')
            {
                $site_filters_arr['Бренд'] = [];
                $site_filters_arr['Производитель'] = [];
            }
            else
                $site_filters_arr[$filter_title] = [];

            $fvalue_title = $line->find('td', 1)->innertext;

            if(strpos($fvalue_title, '<br>') != false)
            {
                $fvalue_title_arr = explode('<br>', $fvalue_title);

                $site_filters_arr['Бренд'][] = strip_tags($fvalue_title_arr[0]);

                if(isset($fvalue_title_arr[1]))
                    $site_filters_arr['Производитель'][] = strip_tags($fvalue_title_arr[1]);
            }
            else
                $site_filters_arr[$filter_title][] = strip_tags($fvalue_title);
        }

        foreach($document->find('.paramsitem') as $pi)
        {
            if($pi->find('.col-4', 0) == null)
                continue;

            $filter_title = str_replace(':', '', $pi->find('.col-4', 0)->innertext);
            if($filter_title == 'Количество')
                continue;

            $site_filters_arr[$filter_title] = [];


            if($pi->find('.col-4', 1) == null)
                continue;

            $fvalues_option = $pi->find('.col-4', 1)->find('option');

            foreach($fvalues_option as $fo)
            {
                if(trim($fo->plaintext) == 'Выберите')
                    continue;

                $site_filters_arr[$filter_title][] = $fo->plaintext;
            }
        }


        foreach($site_filters_arr as $filter => $fvalues_arr)
        {

            $filter_obj = Filter::whereHas('languages', function($q) use($filter) {
                return $q->where('title', $filter);
            })->first();

            if($filter_obj == null)
            {
                $filter_all = [];
                $filter_all['languages'] = [];
                $filter_all['languages'][0] = [];
                $filter_all['languages'][0]['title'] = $filter;
                $filter_all['languages'][0]['language'] = 'ru';

                $request = new Request;

                $request->replace($filter_all);

                $filter_id = app()->call('App\Http\Controllers\FilterController@store', ['request' => $request, 'parser' => 'parser']);
            }
            else
            {
                $filter_id = $filter_obj->id;
            }

            foreach($fvalues_arr as $fvalue_title)
            {
                $fvalue_title = trim($fvalue_title);

                $fvalue_obj = Fvalue::whereHas('languages', function($q) use($fvalue_title) {
                   return $q->where('title', $fvalue_title);
                })->where('filter_id', $filter_id)->first();

                if($fvalue_obj == null)
                {
                    $fvalue_all = [];
                    $fvalue_all['filter_id'] = $filter_id;
                    $fvalue_all['languages'] = [];
                    $fvalue_all['languages'][0] = [];
                    $fvalue_all['languages'][0]['title'] = $fvalue_title;
                    $fvalue_all['languages'][0]['language'] = 'ru';

                    $request = new Request;

                    $request->replace($fvalue_all);

                    $fvalue_id = app()->call('App\Http\Controllers\FvalueController@store', ['request' => $request, 'parser' => 'parser']);
                }
                else
                {
                    $fvalue_id = $fvalue_obj->id;
                }
                $catalog->filters()->syncWithoutDetaching($filter_id);
                $catalog->fvalues()->syncWithoutDetaching($fvalue_id);
                $fvalue_ids[] = $fvalue_id;
            }
        }


        $request = new Request;
        $request->replace($product);

        $product_id = app()->call('App\Http\Controllers\ProductController@store', ['request' => $request, 'parser' => 'parser']);

        Product::find($product_id)->fvalues()->attach($fvalue_ids);

      //  $main_picture = $document->find('#product-core-image a.a-image');
     //   $additional_pictures = $document->find('#slider-nav a');

      //  $product_pictures = count($additional_pictures) > 0 ? $additional_pictures : $main_picture ;
        $product_pictures = $document->find('img[itemprop=image]');
        foreach($product_pictures as $img)
        {     
            $pictures_link = 'https://dostavkalinz.com.ua'.$img->{'data-src'};

 
            PictureService::call()
                ->addLink($pictures_link)
                ->savePicture()
                ->resize(['fhd', 'two', 'tree', 'four', 'five'])
                ->toDB($product_id);
        }
        unset($document);
        unset($lines);
        unset($fvalue_ids);
        unset($filter_id);

        return $response;
	}

	public function getLinks($link, $catalog_id)
	{
		$page = 0;
        $continue = true;
        $links = [];

        while ($continue) {
      
            $page++;
      
            if($page>1)
            {
                $link .= '?PAGEN_1='.$page;
                //$continue = false;
            }
            if($page > 7)
            {
                $continue = false;
                break;
            }

            sleep(2);
          
            $document = HtmlDomParser::file_get_html($link);           

            $cards = $document->find('.productblock');
    
            if(count($cards) == 0)
            {
                $continue = false;
                break;
            }
            foreach($cards as $k => $card)
            {
                Parser::create([
                    'url' => 'https://dostavkalinz.com.ua/'.$card->find('a', 0)->href,
                    'catalog_id' => $catalog_id,
                ]);

                $links[] = 'https://dostavkalinz.com.ua/'.$card->find('a', 0)->href;
            }
            $parser_total_rows = \DB::table('parser')->count();

            Cache::put('parser_total_rows', $parser_total_rows, 3600*24);
        } 
        return json_encode($links);
	}
}