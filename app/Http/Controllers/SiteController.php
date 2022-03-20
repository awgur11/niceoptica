<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Item;
use \App\Models\Page;
use \App\Models\Option;
use \App\Models\Catalog;
use \App\Models\Product;
use \App\Models\Filter;
use \App\Models\Fvalue;
use Illuminate\Notifications\Notification;
use \App\Models\User;
use \App\Http\Services\Justin;

class SiteController extends Controller
{ 
    public function create_page()
    {
        return view('site.create-page');
    }
    public function index()
    {
     //   dd(Justin::call()->getCities('х'));
    //   dd(Justin::call()->getWarehouses('32b69b95-9018-11e8-80c1-525400fb7782'));

        $slider = Item::with('language')->where('type', 'slider')->wherePublic(1)->orderBy('position')->get();

        $catalogs = Catalog::with('language')->orderBy('position')->whereHome_page(1)->get();

        $blog = Page::whereType('blog')->wherePublic(1)->latest()->limit(3)->get();
        $blog = $this->prepareArticles($blog);
        $novelties = Product::with(['picture', 'language'])->where('novelty', 1)->where('public', 1)->orderBy('position')->get();

        $promo = Product::with(['picture', 'language'])->where('promo', 1)->where('public', 1)->orderBy('position')->get();

        $advs = Item::where('type', 'advs')->orderBy('position')->wherePublic(1)->get();

        $brands = Item::where('type', 'brands')->orderBy('position')->wherePublic(1)->get();
 
        $advices = Page::with('language:page_id,title')->where('type', 'services')->wherePublic(1)->orderBy('position')->get();

        return view('site.index', [
            'blog' => $blog,
            'slider' => $slider,
            'catalogs' => $catalogs,
            'advs' => $advs,
            'brands' => $brands,
            'novelties' => $novelties,
            'promo' => $promo,
            'advices' => $advices,
        ]);
    }

    public function send_email(Request $request)
    {
        $all = $request->all();

    //    $admin = \App\Models\User::where('role', 'admin')->first();

        $email_obj = \App\Models\Option::where('key', 'admin_email')->first();

        if($email_obj == null)
            return null;

        foreach(explode(',', $email_obj->value) as $email)
        { 
            (new \App\Models\User)->forceFill([
               'name' => 'Admin',
               'email' => trim($email),
            ])->notify(new \App\Notifications\CallBack($all));
        }
    }

    public function page($alt_title, Request $request)
    {
        $page = Page::with(['language', 'category'])->where('alt_title', $alt_title)->firstOrFail();

        if($page->id == 39)
        {
            $map = Option::with('language')->where('key', 'map')->first()->value;

            return view('site.contacts', [
                'page' => $page,
                'map' => $map
            ]);
        }

        if($page->id == 49)
        {
            $articles = Page::where("type", 'blog')->wherePublic(1);

            if($request->has('category_id'))
                $articles = $articles->where('category_id', $request->category_id);

            $articles_count = $articles->count();

            $articles = $articles->limit(18)->latest();

            if($request->has('offset'))
            {
                $articles = $articles->offset($request->input('offset', 0))->get();

                $articles = $this->prepareArticles($articles);

                return view('layouts.site.cards.articles', ['items' => $articles]);
            }

            $categories = Item::with('language')->where('type', 'categories')->orderBy('position')->get();

            $articles = $articles->get();



            $articles = $this->prepareArticles($articles);


            return view('site.blog', [
                'count' => $articles_count,
                'articles' => $articles,
                'page' => $page,
                'categories' => $categories
            ]);
        }

        if($page->type == 'blog')
        {
            $articles = Page::where("type", 'blog')->where('id', '>', $page->id)->limit(4)->get();

            $articles = $this->prepareArticles($articles);

           
            return view('site.article', [
                'page' => $page,
                'articles' => $articles,
            ]);
        }

        return view('site.page', ['page' => $page]);
    }

    public function prepareArticles($articles)
    {
        return $articles->map(function($item){
            $item->language->content = mb_substr(str_replace('&nbsp;', '', strip_tags($item->language->content)), 0, 200); 
            $item->created_at_custom = date('d M Y', strtotime($item->created_at));

            if($item->language->language == 'ru')
                $item->created_at_custom = str_replace(['Jan', 'Feb', 'Apr', 'Mar', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], ['Янв', 'Фев', 'Апр', 'Мар', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'], $item->created_at_custom);
            elseif($item->language->language == 'ua')
                $item->created_at_custom = str_replace(['Jan', 'Feb', 'Apr', 'Mar', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], ['Січ', 'Лют', 'Кві', 'Бер', 'Тра', 'Чер', 'Лип', 'Сер', 'Вер', 'Жов', 'Лис', 'Гру'], $item->created_at_custom);
            return $item;
        });
    }

    public function products($id, $alt_title, Request $request)
    {
        $products = Product::with([
            'language', 
            'picture', 
            'fvalues' => function($q){return $q->with(['language', 'filter.language'])->whereHas('filter', function($a) { return $a->where('active', 1);});},
        ]);

        $catalog = Catalog::with([
            'language',
            'filters.language',
            'fvalues.language',
            'children:id,parent_id'
        ])->find($id);

        if($catalog->children->count() > 0)
        {
            $catalogs_ids = $catalog->children->pluck('id');

            $products = $products->whereIn('catalog_id', $catalogs_ids);

            $filters = Filter::with(['language'])->whereHas('catalogs', function($q) use($catalogs_ids) { return $q->whereIn('catalogs.id', $catalogs_ids); })->get();

            $fvalues = Fvalue::whereHas('catalogs', function($q) use($catalogs_ids) { return $q->whereIn('catalogs.id', $catalogs_ids); })->get();

            $catalog->filters = $filters;
            $catalog->fvalues = $fvalues;
        }
        else
            $products = $products->where('catalog_id', $catalog->id)->wherePublic(1);




        foreach($request->except('orderBy', 'paginate', 'colours', 'page', 'available') as $filter => $fvalues_arr)
        {
            if(!is_array($fvalues_arr))
                continue;

            $filter_id = (int) str_replace('filter-', '', $filter);

            $products = $products->whereHas('fvalues', function($q) use($filter_id, $fvalues_arr){
                return $q->where('fvalues.filter_id', $filter_id)->where(function($w) use($fvalues_arr){
                    foreach($fvalues_arr as $fvalue)
                    {
                        $fvalue = explode('-', $fvalue);

                        if(isset($fvalue[0]))
                            $fvalue_id = (int) $fvalue[0];
                        else
                            continue;
                  
                        $w->orWhere('fvalues.id', $fvalue_id);
                    }
                });
            });
        }

        if($request->input('ajax') == 'calculate_products')
            return $products->count();

        $products_count =  $products->count();

        if($request->has('orderBy'))
        {
            if($request->orderBy == 'ascending')
            {
                $col = 'final_price'; $direction = 'ASC';
            }
            elseif($request->orderBy == 'descending')
            {
                $col = 'final_price'; $direction = 'DESC'; 
            }
            elseif($request->orderBy == 'updated_at')
            {
                $col = 'updated_at'; $direction = 'DESC'; 
            }
            else
            {
                $col = 'id'; $direction = 'DESC'; 
            }
            $products = $products->orderBy('products.available', 'DESC')->orderBy('products.'.$col, $direction);
        }

        $products = $products->limit(18)->offset($request->input('offset', 0))->get();

        if($request->has('offset'))
            return view('layouts.site.cards.products', ['items' => $products]);

        //кнопки сбрасывающие фильтры

        $cancel_filter_buttons = [];
        $filters_arr = $request->all();

        foreach($request->all() as $filter => $fvalues){
            if(!is_array($fvalues))
                continue;
            foreach($fvalues as $k => $fvalue)
            {
                $filters_arr_copy = $filters_arr;

                unset($filters_arr_copy[$filter][$k]);

                $fvalue = explode('-', $fvalue)[1];

                $link = http_build_query($filters_arr_copy) == "" ? url()->current() : url()->current().'?'.http_build_query($filters_arr_copy);

                $cancel_filter_buttons[] = [
                    'fvalue' => $fvalue,
                    'link' => $link
                ];
                unset($link);
            }
        }
        return view('site.products', [
            'products' => $products,
            'catalog' => $catalog,
            'cancel_filter_buttons' => $cancel_filter_buttons,
            'products_count' => $products_count
        ]);
    }

    public function product($id_catalog, $alt_catalog, $id, $alt_title, Request $request)
    {
    //    $cookie = \Cookie::forget('cart');
    //   return response('site.index')->withCookie($cookie);
      // dd($request->cookie('cart'));
        $product = Product::with([
            'language', 
            'catalog.filters.language', 
            'picture', 
            'pictures',
            'files',
            'fvalues.language',
            'fvalues.filter.language',
            'pricelist.fvalue_1.language',
            'pricelist.fvalue_1.filter.language'
        ])->findOrFail($id);

        foreach($product->pricelist as $k => $pp)
        {
            $fvalue1 = $product->fvalues->find($pp->param_id_1);

            if($fvalue1 != null)
            {
                $product->pricelist[$k]->param_title_1 = ($fvalue1->language != null ? $fvalue1->language->title : $product->fvalues->find($pp->param_id_1)->title);
                $product->pricelist[$k]->param_filter_1 = ($fvalue1->filter->language != null ? $fvalue1->filter->language->title : $fvalue1->filter->title);
                $product->pricelist[$k]->param_position_1 = $fvalue1->position;
            }
            if($pp->param_id_2 != 0 && $product->fvalues->find($pp->param_id_2) != null)
            {
                $fvalue2 = $product->fvalues->find($pp->param_id_2);
                $product->pricelist[$k]->param_title_2 = $fvalue2->language != null ? $fvalue2->language->title : $fvalue2->title;
                $product->pricelist[$k]->param_filter_2 = $fvalue2->filter->language != null ? $fvalue2->filter->language->title : $fvalue2->filter->title;
                $product->pricelist[$k]->param_position_2 = $fvalue2->position;
            }
        }

        $pricelist_ready = [];

        foreach($product->pricelist as $pp)
        {
            if($pp->fvalue_1 != null && $pp->fvalue_1->filter != null)
            {
                $pricelist_ready[$pp->fvalue_1->filter->language->title][] = [
                    'title' => $pp->fvalue_1->language->title,
                    'price' => $pp->price,
                    'id' => $pp->param_id_1 
                ];

            }
        }
        $product->pricelist_ready = $pricelist_ready;

        $for_cart_fvalues = [];

        foreach($product->fvalues as $fvalue)
        {
            if($fvalue->filter->for_cart == 1)
            {
                $for_cart_fvalues[$fvalue->filter->language->title][] = [
                    'id' => $fvalue->id,
                    'title' => $fvalue->language->title,
                ];
            }
        }
        $product->for_cart_fvalues = $for_cart_fvalues;
/*
        $seria = $product->fvalues->where('filter_id', 61)->first();

        if($seria != null)
        {
            $seria_id = $seria->id;
            $area_items = Product::where('catalog_id', $id_catalog)
                ->whereHas('fvalues', function($q) use($seria_id) {
                    return $q->where('fvalues.id', $seria_id);
                })->select('id', 'alt_title', 'catalog_id')->with([
                    'language:id,title,product_id',
                    'fvalues' => function($w) { return $w->with('language')->where('filter_id', 63);},
                    'catalog:id,alt_title',
                ])->limit(5)->get()->map(function($value){
                    if($value->fvalues->count() == 0)
                        return null; 

                    $value->area = $value->fvalues->first()->language->title;

                    return $value;
                })->filter(function($value){
                    return $value != null;
                }); 

        }
        else
            $area_items = [];
*/

        $advs = Item::where('type', 'advs')->wherePublic(1)->orderBy('position')->get();

        //Другие товары этого бренда

        $brand_fvalues_ids = $product->fvalues->where('filter_id', 336)->pluck('id');

        if($brand_fvalues_ids->count() > 0)
            $products_brand = Product::whereHas('fvalues', function($q) use($brand_fvalues_ids) {
                return $q->whereIn('fvalues.id', $brand_fvalues_ids);
            })->where('id', '<>', $product->id)->limit(10)->get();
        else
            $products_brand = [];

        // раннее просмотренные товары
        $last_products_ids = session('last_products_ids', []);



        if(!in_array($product->id, $last_products_ids))
        {
            $last_products_ids[] = $product->id;

            session(['last_products_ids' => $last_products_ids]);
        }

        $product->language->content = str_replace('pre>', 'p>', $product->language->content);

        $last_products = Product::with([
            'language:title,product_id', 
            'picture', 
        ])->whereIn('id', $last_products_ids)->where('id', '<>', $product->id)->limit(10)->get();

        return view('site.product', [
            'product' => $product,
            'advs' => $advs,
            'products_brand' => $products_brand,
            'last_products' => $last_products
           // 'area_items' => $area_items
        ]);
    }

    public function search_ajax(Request $request)
    {
        $string = $request->input('string');

        if(trim($string) == null)
            return '';

        $if_articule = Product::with('catalog')->whereHas('catalog', function($q){ return $q->where('public', 1);})->where('articule', trim($string))->first();

        if($if_articule != null)
            return redirect()->route('product', ['id_catalog' => $if_articule->catalog_id, 'alt_catalog' => $if_articule->catalog->alt_title, 'id' => $if_articule->id, 'alt_title' => $if_articule->alt_title]);

    $string_arr = explode(' ', $string);

    $catalogs = collect([]);
    $products = collect([]);

    $catalogs_items_count_arr = [];
    $products_items_count_arr = [];

    foreach($string_arr as $sa)
    { 
        $catalogs_temp = Catalog::with('language:id,title')->where('public', 1)->whereHas('language', function($q) use($sa) {
            return $q->where('title', 'LIKE', '%'.$sa.'%');
        })->select('id', 'alt_title')->get();
  
        $catalogs = $catalogs->merge($catalogs_temp);

        $products_temp = Product::with('language:id,title')->where('public', 1)->whereHas('language', function($q) use($sa) {
        return $q->where('title', 'LIKE', '%'.$sa.'%');
      })->select('id', 'alt_title')->get();
      $products = $products->merge($products_temp);
    }
    foreach($catalogs as $catalog)
    {
      if(isset($catalogs_items_count_arr[$catalog->id]))
      {
        $catalogs_items_count_arr[$catalog->id]['count']++;
      }
      else
      {
        $catalogs_items_count_arr[$catalog->id]['id'] = $catalog->id;
        $catalogs_items_count_arr[$catalog->id]['count'] = 1;
      }
    }
    foreach($products as $product)
    {
      if(isset($products_items_count_arr[$product->id]))
      {
        $products_items_count_arr[$product->id]['count']++;
      }
      else
      {
        $products_items_count_arr[$product->id]['id'] = $product->id;
        $products_items_count_arr[$product->id]['count'] = 1;
      }
    }
    // id каталогов с максимальнім количеством совпадений
    $catalogs_ids_arr = collect($catalogs_items_count_arr)->sortByDesc('count')->slice(0, 3)->pluck('id')->all();
    if($catalogs_ids_arr != [])
    {
      $catalogs_ids_imp = implode(',', $catalogs_ids_arr);

      $catalogs = Catalog::with('language')->where('public', 1)->whereIn('id', $catalogs_ids_arr)->orderByRaw("FIELD(id, $catalogs_ids_imp)")->get()->map(function($el) use($string_arr){
        foreach($string_arr as $sa)
        {
          $sa = mb_strtolower($sa);
          $el->language->title = str_replace($sa, '<b>'.$sa.'</b>', mb_strtolower($el->language->title));
        }
        $el->link = route('products', ['id' => $el->id, 'alt_title' => $el->alt_title]);
        return $el;
      })->all();
    }
    else
    {
      $catalogs = [];
    }

    if($request->has('ajax'))
      $slice = 5;
    else
      $slice = 25;

    $products_ids_arr = collect($products_items_count_arr)->sortByDesc('count')->slice(0, $slice)->pluck('id')->all();

    if($products_ids_arr != [])
    {
      $products_ids_imp = implode(',', $products_ids_arr);
      $products = Product::with([
        'language:title,product_id',
        'catalog:id,alt_title',
        'picture',
      ])->whereHas('catalog', function($q){ return $q->where('public', 1);})->select('id', 'alt_title', 'catalog_id', 'price', 'final_price', 'discount')->whereIn('id', $products_ids_arr)->orderByRaw("FIELD(id, $products_ids_imp)")->get()->map(function($el) use($string_arr){
        foreach($string_arr as $sa)
        {
          $sa = mb_strtolower($sa);
          $el->language->title = str_replace($sa, '<b>'.$sa.'</b>', mb_strtolower($el->language->title));
        }
        if($el->catalog != null)
        {
          $el->link = route('product', ['id_catalog' => $el->catalog->id, 'alt_catalog' => $el->catalog->alt_title, 'id' => $el->id, 'alt_title' => $el->alt_title]);
          return $el;
        }
      })->all();
      }
    else
    {
      $products = [];
    }

    if($request->has('ajax'))
    {

      $result = [];
      $result['catalogs'] = $catalogs;
      $result['products'] = $products;

      return json_encode($result);
    }
    else
    {

      if(count($products) == 0)
        return view('site.search', ['products' => null]);
      else
        return view('site.search', ['products' => $products]); 
    }
  }
    public function search(Request $request)
    {
        if(!$request->has('ss'))
            return redirect('/')->with('error', 'Search error');
      
        $search = $request->input('ss');

        $product = Product::with('catalog')->where('articule', $search)->first();

        if($product != null)
            return redirect()->route('product', ['id_catalog' => $product->catalog->id, 'alt_catalog' => $product->catalog->alt_title, 'id' => $product->id, 'alt_title' => $product->alt_title]);

        $search = explode(' ', $search);
        //если ввели модель
        foreach($search as $s)
        {
            $s = mb_strtolower($s);

            $products = Product::whereHas('language', function($q) use($s) { return $q->where('title', 'LIKE', '%'.$s.'%');});

            if($products->count() == 1)
            {
                $product = $products->first();
        
                return redirect()->route('product', ['id_catalog' => $product->catalog->id, 'alt_catalog' => $product->catalog->alt_title, 'id' => $product->id, 'alt_title' => $product->alt_title]);
            } 
        }
        $catalogs_ids = \App\Models\Catalog_languages::where(function($q) use($search) {
            foreach($search as $s)
            {
               $q = $q->orWhere('title', 'LIKE', '%'.$s.'%');
            }
            return $q;
        }); 
        $catalogs_ids = $catalogs_ids->pluck('catalog_id')->all();

        if($catalogs_ids == [])
            return view('site.search', ['products' => null]);

        $fvalues_ids = \App\Models\Fvalue_languages::where(function($q) use($search) {
            foreach($search as $s)
            {
                $q = $q->orWhere('title', 'LIKE', '%'.$s.'%');
            }
            return $q;
        }); 
        $fvalues_ids = $fvalues_ids->pluck('fvalue_id')->all();

        if($fvalues_ids == [])
            return view('site.search', ['products' => null]);

        $products_ids = [];


        foreach($fvalues_ids as $fi)
        {
            if($catalogs_ids != [])
                $products_ids_temp = Product::whereIn('catalog_id', $catalogs_ids)->whereHas('fvalues', function($q) use($fi) {
                        return $q->where('fvalues.id', $fi);
                    })->pluck('id')->all();
            else
            $products_ids_temp = Product::whereHas('fvalues', function($q) use($fi) {
                return $q->where('fvalues.id', $fi);
            })->pluck('id')->all();

            if($products_ids_temp == [])
                continue;

            $products_ids = array_merge($products_ids, $products_ids_temp);
        }
        $products = Product::with('catalog')->whereIn('id', $products_ids)->limit(24)->get();

        if($products->count() == 0)
            return view('site.search', ['products' => null]);
        else
            return view('site.search', ['products' => $products]);  
    }

    public function sitemap()
    {
        $locales = \App\Models\Language::pluck('locale')->map(function($el){
            if($el != \App::getLocale())
                 return $el;
        })->toArray();

        $pages = Page::where('public', 1)
            ->select('id','alt_title', 'created_at', 'type', 'parent_id')
            ->get();

        $catalogs = Catalog::select('id', 'alt_title', 'created_at')->where('public', 1)->get();

        $products = Product::select('id', 'alt_title', 'created_at', 'catalog_id')
            ->with('catalog:id,alt_title')
            ->limit(5)
            ->get(); 

        return response()->view('site.sitemap', [
           'pages' => $pages, 
           'locales' => $locales,
           'products' => $products,
           'catalogs' => $catalogs,
        ])->header('Content-Type', 'text/xml');;
    }

    public function google_feed()
    { 
       $products = Product::select('id', 'code', 'alt_title', 'catalog_id', 'final_price', 'discount')
        ->with([
            'languages',
            'fvalues' => function($q) { return $q->with(['languages', 'filter.languages'])->whereHas('filter', function($w){ return $w->where('merchant', 1); }); },
            'picture',
            'catalog.language'])
        ->where('public', 1)
        ->limit(10)
        ->chunk(100, function($products) use(&$products_obj) {
          foreach($products as $product)
          {

            if($product->picture == null)
              continue;

            if($product->catalog != null)
            {
              $product->product_type = $this->getLangVal($product->catalog, 'ru');
              $product->product_type_ua = $this->getLangVal($product->catalog, 'ua');
            } 
  
            $product->link = route('product', [
                'id_catalog' => $product->catalog_id, 
                'alt_catalog' => $product->catalog->alt_title, 
                'id' => $product->id, 
                'alt_title' => $product->alt_title
            ]);

            $product->picture = $product->picture->five_preview;

            $product->brand = NULL;
            $product->brand_ua = null;

            if($product->fvalues->where('filter_id', 336)->first() != null)
            {
              $product->brand = $this->getLangVal($product->fvalues->where('filter_id', 336)->first(), 'ru');
              $product->brand_ua = $this->getLangVal($product->fvalues->where('filter_id', 336)->first(), 'ua');
            }


            $product->description = NULL;
            $product->description_ua = NULL;

            foreach($product->fvalues as $fvalue)
            {

                $product->description .= $this->getLangVal($fvalue->filter, 'ru').' - '. $this->getLangVal($fvalue, 'ru').'; ';

                $product->description_ua .= $this->getLangVal($fvalue->filter, 'ua').' - '. $this->getLangVal($fvalue, 'ua').'; ';

            }

            $products_obj[$product->id]['id'] = $product->code;
            $products_obj[$product->id]['id_ua'] = $product->code.'-ua';
            $products_obj[$product->id]['title'] = $this->getLangVal($product, 'ru');
            $products_obj[$product->id]['title_ua'] = $this->getLangVal($product, 'ua');
            $products_obj[$product->id]['description'] = $product->description;
            $products_obj[$product->id]['description_ua'] = $product->description_ua;
            $products_obj[$product->id]['link'] = $product->link;
            $products_obj[$product->id]['link_ua'] = str_replace(['.com', '.loc'], ['.com/ru', '.loc/ua'], $product->link);
            $products_obj[$product->id]['picture'] = $product->picture;

            if($product->discount > 0)
            {
              $products_obj[$product->id]['final_price'] = $product->final_price;
              $products_obj[$product->id]['old_price'] = round($product->final_price/(1-$product->discount/100), 2);
            }
            else
              $products_obj[$product->id]['price'] = $product->final_price;

            $products_obj[$product->id]['brand'] = $product->brand;
            $products_obj[$product->id]['brand_ua'] = $product->brand_ua;
            $products_obj[$product->id]['product_type'] = $product->product_type;
            $products_obj[$product->id]['product_type_ua'] = $product->product_type_ua;
          }

        });

      return response()->view('site.feed', ['products' => $products_obj])->header('Content-Type', 'text/xml');
    }
    public function getLangVal($obj, $locale, $field = 'title')
    {
        if($obj->languages->where('language', $locale)->first() != null)
            return $obj->languages->where('language', $locale)->first()->{$field};

        else return null;
    }
}
