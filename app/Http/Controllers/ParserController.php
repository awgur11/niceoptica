<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;
use App\Http\Services\PictureService;
use App\Http\Services\ParserService;
use Illuminate\Support\Facades\Cache;
use App\Models\Picture;
use App\Models\Catalog;
use App\Models\Product;
use App\Models\Filter;
use App\Models\Fvalue;
use App\Models\Parser;

class ParserController extends Controller
{
    public function index()
    {
        return view('admin.parser.index');
    }

    public function process()
    {
        $continue = true;

        $total_count = Parser::where('status', 0)->where('pause', 0)->count();

        $i = 0;

        while ($continue) {
            $i++;
            if($i > 20)
            {
                $continue = false;
            }
            $item = Parser::where('status', 0)->where('pause', 0)->first();

            if($item == null)
            {
                $continue = false;
                break;
            }
            sleep(10);
            $result = ParserService::factory()->saveProduct($item->url, $item->catalog_id);

            if($result['success'])
            {
                Parser::find($item->id)->update([
                   'status' => 1,
                ]);
                Cache::increment('parser_ready_rows'); 
                Cache::increment('parser_success_rows'); 
            }
            else
            {
                Parser::find($item->id)->update([
                   'status' => 2,
                   'errors' => $result['errors'],
                ]);
                Cache::increment('parser_errors_rows'); 
            }
        }
    }

    public function pause_procceed()
    {
        if(\DB::table('parser')->where('pause', 0)->count() > 0)
        {
           \DB::table('parser')->update([
            'pause' => 1,
           ]);
           return 'pause';
        }
        else
        {
            \DB::table('parser')->update([
            'pause' => 0,
           ]);
           return 'proceed';
        }
    }

    public function get_links(Request $request)
    {
        $catalog_id = $request->input('catalog_id', 0);
 
        return ParserService::factory()->getLinks($request->link, $catalog_id);
    }

    public function save_product(Request $request)
    {
        $response = [
            'success' => true,
            'errors' => ''
        ];

        $product = [];

        $product['catalog_id'] = $request->catalog_id;

        $catalog = Catalog::find($product['catalog_id']);

        $link = $request->link;

        try{
           $document = HtmlDomParser::file_get_html($link);
        } catch (\Exception $e) {

            $response = [
                'success' => false,
                'errors' => $e->getMessage(),
            ];

            return $response;
        }
  
       // PictureService::call()->addLink('http://viva-kitchen.com/images/kuhni/51-Delfi.jpg')->savePicture()->resize(['fhd', 'two', 'four', 'five'])->toDB();
     
        $product['languages'][0]['language'] = 'ru';
        $product['languages'][0]['title'] = trim($document->find('h1', 0)->plaintext);
        $product['alt_title'] = alt_title($product['languages'][0]['title']);

        //определяем блок с описанием товара и, если есть, извлекаем
        $item_lis = $document->find('.js-product-tabs li');

        foreach($item_lis as $is)
        {
            if(trim($is->plaintext) == 'Описание')
            {
                $content_id = $is->find('a', 0)->href;
                $product['languages'][0]['content'] = $document->find($content_id, 0)->innertext;
                break;
            }

        }

        $product['price'] = $document->find('.price-block', 0) != null ? $document->find('.price-block', 0)->plaintext : 0;

        $product['price'] = (int) str_replace(['₽', ' '], '', $product['price']);

        $product['price'] = round($product['price']/2.5, -1);
        $product['final_price'] = $product['price'];
        //фильтры и значения
        $fvalue_ids = array();

        $lines = $document->find('#product-features .line-bottom');

        foreach($lines as $line)
        {
            $filter_title = trim($line->find('.line-bottom-name', 0)->plaintext);

            $filter_obj = Filter::whereHas('languages', function($q) use($filter_title) {
                return $q->where('title', $filter_title);
            })->first();

            if($filter_obj == null)
            {
                $filter_all = [];
                $filter_all['languages'] = [];
                $filter_all['languages'][0] = [];
                $filter_all['languages'][0]['title'] = $filter_title;
                $filter_all['languages'][0]['language'] = 'ru';

                $request = new Request;

                $request->replace($filter_all);

                $filter_id = app()->call('App\Http\Controllers\FilterController@store', ['request' => $request, 'parser' => 'parser']);
            }
            else
            {
                $filter_id = $filter_obj->id;
            }

            if($filter_title == 'С функциями')
            {
                $fvalues_titles = explode(',', trim($line->find('.line-bottom-value', 0)->plaintext));
            }
            else
                $fvalues_titles = [$line->find('.line-bottom-value', 0)->plaintext];


            foreach($fvalues_titles as $fvalue_title)
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

        $main_picture = $document->find('#product-core-image a.a-image');
        $additional_pictures = $document->find('#slider-nav a');

        $product_pictures = count($additional_pictures) > 0 ? $additional_pictures : $main_picture ;
        foreach($product_pictures as $img)
        {     
            $pictures_link = 'https://vsekondicioneri.ru'.$img->href;
 
            PictureService::call()
                ->addLink($pictures_link)
                ->savePicture()
                ->resize(['fhd', 'two', 'four', 'five'])
                ->toDB($product_id);
        }
/*
        $product_info = $document->find('.syrattach_info');

        foreach($product_info as $info)
        {
            $info_link = 'https://vsekondicioneri.ru'.$info->find('a', 0)->href;

            PictureService::call()
                ->addLink($info_link)
                ->savePicture()
                ->toDB($product_id);
        } */
        unset($document);
        unset($lines);
        unset($fvalue_ids);
        unset($filter_id);

        return json_encode($response);
    }
    public function monitor()
    {
       // Cache::clear();
        $parser_total_rows = Cache::remember('parser_total_rows', 24*3600, function(){
            return \DB::table('parser')->count();
        });

        $parser_ready_rows = Cache::remember('parser_ready_rows', 24*3600, function(){
            return \DB::table('parser')->where('status', '<>', 0)->count();
        });

        $parser_success_rows = Cache::remember('parser_success_rows', 24*3600, function(){
            return \DB::table('parser')->where('status', 1)->count();
        });

        $parser_errors_rows = Cache::remember('parser_errors_rows', 24*3600, function(){
            return \DB::table('parser')->where('status', 2)->count();
        });

        return [
            'parser_total_rows' => $parser_total_rows,
            'parser_ready_rows' => $parser_ready_rows,
            'parser_success_rows' => $parser_success_rows,
            'parser_errors_rows' => $parser_errors_rows,
        ];
    }
}
//https://vsekondicioneri.ru/category/konditsionery/?brand%5B%5D=1319&brand%5B%5D=1324&brand%5B%5D=1330&brand%5B%5D=1342&brand%5B%5D=1367&brand%5B%5D=1389&brand%5B%5D=1411&brand%5B%5D=1413&brand%5B%5D=1545&brand%5B%5D=1572&brand%5B%5D=1610&brand%5B%5D=1622&brand%5B%5D=1648&brand%5B%5D=1664&brand%5B%5D=1856&brand%5B%5D=1894&brand%5B%5D=2213&brand%5B%5D=291&brand%5B%5D=292&brand%5B%5D=293&brand%5B%5D=294&brand%5B%5D=295&brand%5B%5D=296&brand%5B%5D=3177&brand%5B%5D=545&brand%5B%5D=5755&brand%5B%5D=5761&brand%5B%5D=58&brand%5B%5D=7445&brand%5B%5D=8

//https://vsekondicioneri.ru/category/konditsionery/nastennie-split-sistemy/?brand%5B%5D=1319&brand%5B%5D=1324&brand%5B%5D=1330&brand%5B%5D=1342&brand%5B%5D=1367&brand%5B%5D=1389&brand%5B%5D=1411&brand%5B%5D=1413&brand%5B%5D=1545&brand%5B%5D=1572&brand%5B%5D=1610&brand%5B%5D=1622&brand%5B%5D=1648&brand%5B%5D=1664&brand%5B%5D=1856&brand%5B%5D=1894&brand%5B%5D=2213&brand%5B%5D=291&brand%5B%5D=292&brand%5B%5D=293&brand%5B%5D=294&brand%5B%5D=295&brand%5B%5D=296&brand%5B%5D=3177&brand%5B%5D=545&brand%5B%5D=5755&brand%5B%5D=5761&brand%5B%5D=58&brand%5B%5D=7445&brand%5B%5D=8

//https://vsekondicioneri.ru/category/otoplenie/obogrevateli/?brand%5B0%5D=1319&brand%5B1%5D=1324&brand%5B2%5D=1330&brand%5B3%5D=1342&brand%5B4%5D=1367&brand%5B5%5D=1389&brand%5B6%5D=1411&brand%5B7%5D=1413&brand%5B8%5D=1545&brand%5B9%5D=1572&brand%5B10%5D=1610&brand%5B11%5D=1622&brand%5B12%5D=1648&brand%5B13%5D=1664&brand%5B14%5D=1856&brand%5B15%5D=1894&brand%5B16%5D=2213&brand%5B17%5D=291&brand%5B18%5D=292&brand%5B19%5D=293&brand%5B20%5D=294&brand%5B21%5D=295&brand%5B22%5D=296&brand%5B23%5D=3177&brand%5B24%5D=545&brand%5B25%5D=5755&brand%5B26%5D=58&brand%5B27%5D=8