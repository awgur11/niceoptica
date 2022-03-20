<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Client;
 
class CartController extends Controller
{
    public function index(Request $request)
    {
        if($this->corrent_cart_content($request) == [])
            $cart_empty = true;
        else 
            $cart_empty = false;
 
        $cart = $request->cookie('cart');

        $cart_arr = $this->corrent_cart_content($request);

        $cart_content = $this->content($cart_arr);

        return view('site.cart', [
            'cart_empty' => $cart_empty,
            'cart' => $cart,
            'cart_content' => $cart_content
        ]);
    }
    public function change_count(Request $request)
    {
        $product_id = (int) $request->id;
        $cart_index = (int) $request->index;
        $change = (int) $request->change;

        $cart = $request->cookie('cart');

        if($cart == null)
            return null;

        $cart_arr = json_decode($cart, true);

        $cart_arr = $this->corrent_cart_content($request);

        if(($cart_arr[$cart_index]['count'] + $change) > 0)
            $cart_arr[$cart_index]['count'] = $cart_arr[$cart_index]['count'] + $change;
         

        $cart_content = $this->content($cart_arr);

        return response($cart_content)->cookie('cart', json_encode($cart_arr), 60*48);
    }
    public function delete(Request $request)
    {
        $cart_arr = $this->corrent_cart_content($request);

        unset($cart_arr[$request->index]);

        $cart_arr = array_values($cart_arr);

        $cart_content = $this->content($cart_arr);

        return response($cart_content)->cookie('cart', json_encode($cart_arr), 60*48);
    }
// подготавливаем даннные корзины для вывода
    public function content($cart_arr)
    {
        $response = [];

        foreach($cart_arr as $k => $ca)
        {
            $product = Product::with(['language:product_id,title', 'picture'])->find($ca['id']);
            $cart_arr[$k]['product'] = $product;

            if($ca['params'] != '' && $ca['params'] != null && $ca['params'] != [] && is_array($ca['params']))
            {
                $params_prepare = '';
                $params_prepare_shot = '';

                foreach($ca['params'] as $v)
                {
                    $params_prepare .= '<div class="cp-param"><span class="cp-param-title">' . explode('=', $v)[0] . ':</span> <span class="cp-param-value">' . explode('=', $v)[1] . '</span></div>';
                    $params_prepare_shot .= '<div class="scc-param col-md-6"><span class="scc-param-title">' . explode('=', $v)[0] . ':</span> <span class="scc-param-value">' . explode('=', $v)[1] . '</span></div>';
                }
                $cart_arr[$k]['params'] = $params_prepare;
                $cart_arr[$k]['params_shot'] = $params_prepare_shot;
            }
            else
                $cart_arr[$k]['params'] = '';

            $price_prepare = '';

            if(!isset($ca['old_price']))
                $price_prepare = '<div class="cpb-no-discount-price">' . $ca['price'] . ' uah</div>';
            else
                $price_prepare = '<div class="cpb-new-price pr-3">' . $ca['price'] . ' uah</div>
                                <div class="cpb-old-price">' . $ca['old_price'] . ' uah</div>';

            $cart_arr[$k]['price_prepare'] = $price_prepare;

            $cart_arr[$k]['sum'] = $ca['price']*$ca['count'];
        }   
        $response['cart_arr'] = $cart_arr;


        $response['member_discount'] = $this->loyalty_data(auth()->id())['loyalty_percent'];

        return json_encode($response);
    }
    
    // определение цены товара
    public function get_price(Product $product, $pricelist_id = 0)
    {
        $price = [];

        if($pricelist_id == 0)
        {

            $price['price'] = $product->final_price;

            if($product->discount != 0)
                $price['old_price'] = $product->price;

            return $price;
        }
        else
        {
            if($product->pricelist->where('param_id_1', $pricelist_id)->first() != null)
            { 
                $price['price'] = $product->pricelist->where('param_id_1', $pricelist_id)->first()->price;
            
                if($product->discount != 0)
                {
                    $price['old_price'] = $product->pricelist->where('param_id_1', $pricelist_id)->first()->price;

                    $price['price'] = round($price['old_price']*(1 - $product->discount/100));
                }
                else
                    $price['price'] = $product->pricelist->where('param_id_1', $pricelist_id)->first()->price;


                return $price;
            }
            else
                return ['price' => 0];
        }
    }
    public function add(Request $request)
    {
      //  return response('Hello World')->withoutCookie('cart');
        $cart = $request->cookie('cart');

        $product = Product::with('pricelist')->find($request->id);

        $price_arr = $this->get_price($product, $request->pricelist_id);

        $cart_count = 0;

        $product = [
            'id' => $request->id,
            'count' => $request->count,
            'params' => $request->params,
            'pricelist_id' => $request->pricelist_id,
        ];

        $product = array_merge($product, $price_arr);

        if($cart == NULL)
        {
            $cart_arr = [];

            $cart_arr[] = $product;

            $cart_count = $request->count;
        }
        else
        {
            $cart_arr = json_decode($cart, true);         

            $product_added = false;

            foreach($cart_arr as $k => $ca)
            {
                if($ca['id'] == $product['id'] && $ca['price'] == $product['price']  && $ca['params'] == $product['params'])
                {
                    $cart_arr[$k]['count'] += $product['count'];
                    $product_added = true;
                }
                $cart_count += $cart_arr[$k]['count'];
            }

            if(!$product_added)
            {
                $cart_arr[] = $product;
                $cart_count += $product['count'];
            }
        }
        $cart_arr = array_values($cart_arr);
        $cart = json_encode($cart_arr);

        $cart_content = $this->content($cart_arr);

        return response(json_encode($cart_content))->cookie('cart', $cart, 3600*48);       
    }
    public function get_data_for_cart_modal($product_id)
    {
        $response = [];

         $product = Product::with([
            'language', 
            'catalog.filters.language', 
            'picture',
            'fvalues.language',
            'fvalues.filter.language',
            'pricelist.fvalue_1.language',
            'pricelist.fvalue_1.filter.language'
        ])->find($product_id);


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

        $response['price_params_block'] = (string) \View::make('layouts.site.product.price-params-block', ['product' => $product]);

        $response['title'] = $product->language->title;

        $response['discount'] = $product->discount == 0 ? false : true;

        $response['preview'] = $product->picture->four_preview;

        return $response;
    } 

    

    public function auth(Request $request)
    {
    //    if(auth()->check())
     //       return redirect()->route('cart.checkout');

        $cart_arr = $this->corrent_cart_content($request);

        $cart_content = $this->content($cart_arr);

        return view('site.cart-auth', [
            'cart_content' => $cart_content
        ]);
    }

    public function checkout(Request $request)
    {
        $cart_arr = $this->corrent_cart_content($request);
        
        $cart_content = $this->content($cart_arr);

        return view('site.cart-checkout', [
            'cart_content' => $cart_content
        ]);
    }
}
