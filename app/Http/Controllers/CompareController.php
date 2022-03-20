<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;
use App\Models\Catalog;

class CompareController extends Controller
{
    public function delete_all(Request $request)
    {
        Cookie::expire('compare');

        return redirect()->route('index');

    }
    public function index(Request $request)
    {
        $compare = $request->cookie('compare');

        if($compare == null)
            return redirect()->route('index');

        $compare_arr = json_decode($compare, true);


        $products = Product::with([
            'catalog.filters.language',
            'picture',
            'fvalues.language'])->find($compare_arr);

        $first_catalog_id = $products->pluck('catalog_id')->unique()->first();

        if($first_catalog_id == null)
            return redirect()->route('index');

        return redirect()->route('compare.catalog', ['catalog_id' => $first_catalog_id]);




        $filters_arr = [];

        foreach($products as $pr)
        {
            foreach($pr->catalog->filters as $f)
            {
                if(!isset($filters_arr[$f->id]))
                    $filters_arr[$f->id] = $f->language->title;
            }
        }

        return view('site.compare', [
            'products' => $products,
            'filters_arr' => $filters_arr
        ]);

    }
    public function catalog(Request $request, $catalog_id)
    {
        $catalog = Catalog::with(['language', 'filters.language'])->find($catalog_id);

        $compare = $request->cookie('compare');

        if($compare == null)
            return redirect()->route('index');

        $compare_arr = json_decode($compare, true);


        $products = Product::with([
            'catalog.filters.language',
            'picture',
            'fvalues.language'])->find($compare_arr);

        $catalogs_ids = $products->pluck('catalog_id')->unique();

        $catalogs = Catalog::with('language:title,catalog_id')->find($catalogs_ids);

        return view('site.compare', [
            'products' => $products->where('catalog_id', $catalog_id),
            'catalogs' => $catalogs,
            'catalog' => $catalog
        ]);

    }
    public function add_remove(Request $request)
    {
    //  return response('Hello World')->withoutCookie('compare');
        $compare = $request->cookie('compare');

        $compare_count = 0;

        $already_exists = false;

        $product_id = (int) $request->id;

        $compare_arr = [];

        if($compare != null)
        {  
            $compare_arr = json_decode($compare, true);            

            foreach($compare_arr as $k => $v)
            {
                if($v == $product_id)
                {
                    unset($compare_arr[$k]);
                    $already_exists = true;
                }
            }
            if(!$already_exists)
            {
                $compare_arr[] = $product_id;
            }
        }
        else
        {
            $compare[] = $product_id;
        }

        if($compare == null || $compare == [])
        {
            return response()->json([
                'compare_count' => 0,
                'already_exists' => $already_exists
            ])->withoutCookie('compare');
        }
        $compare_count = count($compare_arr);

        $compare = json_encode($compare_arr);

        return response()->json([
            'compare_count' => $compare_count,
            'already_exists' => $already_exists
        ])->cookie('compare', $compare, 60*48); 
    }
}
