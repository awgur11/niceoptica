<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $favorites = $request->cookie('favorites');

        if($favorites != null)
        {
            $favorites_arr = json_decode($favorites, true);

            $products = Product::whereIn('id', $favorites_arr)->get();
        }
        else
            $products = [];

        return view('site.favorites', ['products' => $products]);
    }
    public function add_remove(Request $request)
    {
    //  return response('Hello World')->withoutCookie('favorites');
        $favorites = $request->cookie('favorites');

        $favorites_count = 0;

        $already_exists = false;

        $product_id = (int) $request->id;

        if($favorites != null)
        {  
            $favorites_arr = json_decode($favorites, true);            

            foreach($favorites_arr as $k => $v)
            {
                if($v == $product_id)
                {
                    unset($favorites_arr[$k]);
                    $already_exists = true;
                }
            }
            if(!$already_exists)
            {
                $favorites_arr[] = $product_id;
            }
        }
        else
        {
            $favorites_arr = [$product_id];
        }

        if($favorites_arr == null || $favorites_arr == [])
        {
            return response()->json([
                'favorites_count' => 0,
                'already_exists' => $already_exists
            ])->withoutCookie('favorites');
        }
        $favorites_count = count($favorites_arr);

        $favorites = json_encode($favorites_arr);

        return response()->json([
            'favorites_count' => $favorites_count,
            'already_exists' => $already_exists
        ])->cookie('favorites', $favorites, 60*48); 
    }
}
