<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\Product;
use App\Models\Catalog;
use App\Models\Currency;
use App\Models\Filter;
use App\Models\Pricelist;
use App\Models\Fvalue;
use App\Models\Picture;
use Illuminate\Support\Facades\Auth;
use Sunra\PhpSimple\HtmlDomParser;
use App\Http\Services\ProductService;

class ProductController extends Controller
{
    public function index($catalog_id, Request $request)
    {
        $products = Product::with('picture')->where('catalog_id', $catalog_id);

        if($request->has('search'))
        {
            $search = $request->search;

            if(is_numeric($search))
            {
                $search = $search;

                if(Product::find($search) != null)
                    return redirect()->route('product.edit', ['id' => $search]);
            }
            $products = $products->where('title', 'LIKE', '%'.$request->search.'%');
        }

        if($request->has('brand_id') && $request->brand_id != '')
        {
            $brand_id = $request->brand_id;

            $products = $products->whereHas('fvalues', function($q) use($brand_id) {
                return $q->where('fvalues.id', $brand_id);
            });
        }
        $products = $products->orderBy('position')->paginate(50);

        $catalog = Catalog::find($catalog_id);

        $filter = Fvalue::with('language')->whereHas('catalogs', function($q) use($catalog){
            return $q->where('catalog_id', $catalog->id);
        })->where('filter_id', 60)->get();

        return view('admin.products.products', [
            'products' => $products, 
            'catalog' => $catalog,
            'filter' => $filter
        ]);
    }

    public function create($catalog_id)
    {
        $catalog = Catalog::with('language')->find($catalog_id);

        foreach($catalog->languages as $k => $lang)
        {
            $catalog->languages[$k]->params = explode(PHP_EOL, $lang->params);
        }

        $pictures = Picture::with('languages')
            ->wherePage_id(0)
            ->whereProduct_id(0)
            ->whereAdvert_id(0)
            ->whereUser_id(auth()->id())
            ->orderBy('position')
            ->get();

        return view('admin.products.create', [
            'catalog' => $catalog,
            'pictures' => $pictures
        ]);
    }

    public function store(Request $request, $parser = null)
    {
        $all = $request->all();

        $all = ProductService::call()
            ->getArray($all)
            ->altTitle()
            ->array;
        
        $product = Product::create($all);

        if(isset($all['fvalues']))
            $product->fvalues()->attach($all['fvalues']);

        //сохранение картинок галереи
        Picture::where('product_id', 0)
            ->where('page_id', 0)
            ->where('advert_id', 0)
            ->where('user_id', $all['user_id'])
            ->update(['product_id' => $product->id]);

        $product->languages()->createMany($all['languages']);

        $product->update([
            'code' => ($product->catalog_id*1000 + $product->id)
        ]);

        //сохранение прайслиста
        if(isset($all['pricelist']) && is_array($all['pricelist']))
        {
            $min_price = 0;

            foreach($all['pricelist'] as $param_id_1 => $value)
            {
                foreach($value as $param_id_2 => $price)
                {
                    if($price == null)
                    continue;

                    $min_price = $min_price == 0 || $min_price > $price ? $price : $min_price;
          
                    Pricelist::create([
                        'param_id_1' => $param_id_1,
                        'param_id_2' => $param_id_2,
                        'price' => $price,
                        'product_id' => $product->id
                    ]);
                }
            }
            if($product->discount != 0)
                $final_price = $min_price*(1 - $product->discount/100);
            else
                $final_price = $min_price;


            $product->update([
                'price' => $min_price,
                'final_price' => $final_price
            ]);
        }

     //   return $product->id;

        if($parser == null)
            return back()->with('message','Saved');
        else
            return $product->id;
    }
 
    public function edit($id)
    {
        $product = Product::with([
           'languages',
           'catalog.language',
           'catalog.filters.language',
           'catalog.fvalues.language',
           'pricelist'
        ])->find($id);

        $service = ProductService::call()
            ->getProduct($product)
            ->catalogParams()
            ->productParams();

        $product = $service->product;

        $catalog = $service->catalog;

        if($product->pricelist->count() == 0)
        {
            $product->pricelist_obj = '{}';
  //        $product->params_obj_1 = null;
//          $product->params_obj_2 = '{0:""}';
            $pricelist_filter_id1 = null;
            $pricelist_filter_id2 = null;
        }
        else
        {
            $pricelist_arr = [];
      // идентификаторы фильтров, которые используются как прайслисты
            $pricelist_filter_id1 = null;
            $pricelist_filter_id2 = null;

            $pricelist_filter1 = $product->fvalues->find(($product->pricelist[0]->param_id_1));

            $pricelist_filter_id1 = $pricelist_filter1 != null ? $pricelist_filter1->filter_id : 0;

            $pricelist_filter2 = $product->fvalues->find(($product->pricelist[0]->param_id_2));

            $pricelist_filter_id2 = $pricelist_filter2 != null ? $pricelist_filter2->filter_id : 0;;   
            foreach($product->pricelist as $pr)
            {
                $pricelist_arr[$pr->param_id_1][$pr->param_id_2] = $pr->price;
            }
            $product->pricelist_obj = json_encode($pricelist_arr);
            $product->pricelist_filter_id1 = $pricelist_filter_id1;
            $product->pricelist_filter_id2 = $pricelist_filter_id2;
        }

        return view('admin.products.edit', [
           'product' => $product,
           'catalog' => $catalog,
        ]);
    }
  
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $all = $request->all();

        $all = ProductService::call()
            ->getArray($all)
            ->altTitle()
            ->array;

        //сохранение картинок галереи
        Picture::where('product_id', 0)
            ->where('page_id', 0)
            ->where('advert_id', 0)
            ->where('user_id', auth()->id())
            ->update(['product_id' => $product->id]);

        $product->update($all);

        if(isset($all['fvalues']))
            $product->fvalues()->sync($all['fvalues']);

        foreach($all['languages'] as $lang)
        {
            if($product->languages()->where('language', $lang['language'])->first() != null)
                $product->languages()->where('language', $lang['language'])->update($lang);
            else
                $product->languages()->create($lang);
        }
        //сохранение прайслиста
        if(isset($all['pricelist']) && is_array($all['pricelist']))
        {
            $min_price = 0;

            Pricelist::where('product_id', $product->id)->delete();
      
            foreach($all['pricelist'] as $param_id_1 => $value)
            {
                foreach($value as $param_id_2 => $price)
                {
                    if($price == null)
                        continue;

                    if(isset($all['percent']) && $all['percent'] != 0 && $all['percent'] != null && is_numeric($all['percent']))
                        $price = round((100 + $all['percent'])/100*$price, 2);

                    if($min_price == 0)
                        $min_price = $price;
                    else
                        if($min_price > $price)
                            $min_price = $min_price == 0 || $min_price > $price ? $price : $min_price;
                    $pricelist_obj = Pricelist::query()
                        ->where('param_id_1', $param_id_1)
                        ->where('param_id_2', $param_id_2)
                        ->where('product_id', $product->id)
                        ->first();

                    if($pricelist_obj == null)  
                        Pricelist::create([
                            'param_id_1' => $param_id_1,
                            'param_id_2' => $param_id_2,
                            'price' => $price,
                            'product_id' => $product->id
                        ]);
                    elseif($pricelist_obj->price != $price)
                        $pricelist_obj->update([
                            'price' => $price
                        ]);
                    elseif($pricelist_obj->price == '' || $pricelist_obj->price == 0)
                         $pricelist_obj->delete();

                    unset($pricelist_obj);
                }
            }
            if($product->discount != 0)
                $final_price = $min_price*(1 - $product->discount/100);
            else
                $final_price = $min_price;

      $product->update([
        'price' => $min_price,
        'final_price' => $final_price
      ]);
    }
        return back()->with('message','Saved');
    } 

    public function destroy($id)
    {
        $product = Product::find($id);
        
        if($product->pictures->count() > 0)
        {
            foreach($product->pictures as $p)
            {
                delete_picture($p->preview_path, $p->preview_name);
            }
            $product->pictures()->delete();
        }
        $product->delete();
    }
    public function delete_all($catalog_id)
    {
        $products = Product::where('catalog_id', $catalog_id)->pluck('id');

        foreach($products as $product_id)
        {
            $this->destroy($product_id);
        }
        return back()->with('message', __('All products ware deleted successfully'));
    }
}
