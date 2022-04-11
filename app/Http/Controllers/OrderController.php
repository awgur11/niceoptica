<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use App\Models\Delivery;
use Illuminate\Support\Facades\Cookie;
use App\Http\Services\LiqPay;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Jobs\OrderSendEmail;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(20);

        return view('admin.orders.orders', ['orders' => $orders]);
    }

    public function destroy($id)
    {
        Order::find($id)->delete();
    }

    public function store(Request $request)
    {
        $order = [];

        if(auth()->check())
        {
            if($request->has('ajaxValidate'))
                return response('OK', 200);

            $order['user_id'] = auth()->id();
            $user = auth()->user();
        }
        else
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
            ]);

            if($request->has('ajaxValidate'))
                return response('OK', 200);

            if($request->input('email') != null)
            {
                $user = User::where('email', $request->email)->first();

                if($user != null)
                {
                    $order['user_id'] = $user->id;

                    Auth::login($user);
                }
                else
                    $email = $request->email;
            }
            else
                $email = 'fakeemail'.rand(111111111, 999999999).'@mail.com';

            if(!isset($order['user_id']))
            {
                $real_password = rand(11111111, 99999999);

                $password = Hash::make($real_password);

                $user_arr = [
                    'name' => $request->input('name'),
                    'lastname' => $request->input('lastname'),
                    'phone' => $request->input('phone'),
                    'email' => $email,
                    'password' => $password,
                ];

                $user = User::create($user_arr);

                $order['user_id'] = $user->id;

                if($request->has('register_me') && $request->email != null)
                {
                    try{
                        \Mail::to($request->email)->send(new \App\Mail\RegisterUser($user));
                    } catch(\Exception $e){
                        Log::debug($e->getMessage());
                    }

                    Auth::login($user);
                }
            }        
        }

        $loyalty_data = $this->loyalty_data($order['user_id']);

        if($request->has('delivery_id'))
        {
            $order['delivery_id'] = $request->delivery_id;

            $delivery = Delivery::find($request->delivery_id);
        }
        elseif($request->input('option') != null)
        {
            $delivery = Delivery::create([
                'option' => $request->input('option'), 
                'city' => $request->input('city'), 
                'warehouse' => $request->input('warehouse'), 
                'street' => $request->input('street'), 
                'house' => $request->input('house'), 
                'flat' => $request->input('flat'), 
                'user_id' => $order['user_id'], 
                'city_ref' => $request->input('city_ref'), 
                'warehouse_ref' => $request->input('warehouse_ref'), 
                'street_ref' => $request->input('street_ref'), 
                'main' => 1
            ]);
            $order['delivery_id'] = $delivery->id;
        }
        else
            $delivery = NULL;

        $order_sum = 0;

        if($request->buy_one_click != null)
        {
            $cart_arr = [
                [
                    'id' => $request->product_id,
                    'count' => 1,
                    'params' => '',
                    'pricelist_id' => 0,
                    'price' => $request->product_price,
                ]
            ];
        }
        else
            $cart_arr = $this->corrent_cart_content($request);    


        foreach($cart_arr as $k => $ca)
        {
            $product = Product::with(['language:product_id,title', 'picture'])->find($ca['id']);
            $cart_arr[$k]['product'] = $product;
            $order_sum += $ca['price']*$ca['count'];
        }

        $order['order'] = $cart_arr;

        $order['loyalty_percent'] = $loyalty_data['loyalty_percent'];

        $order['sum'] = round($order_sum*(1 - $loyalty_data['loyalty_percent']/100));

   
  /*      return view('mail.user-register', [
            'user' => $user,
        ]); 
*/
        $email_obj = \App\Models\Option::where('key', 'admin_email')->first();

        if($email_obj != null)
        {
            foreach(explode(',', $email_obj->value) as $email)
            { 
                $details = [
                    'email' => trim($email), 
                    'cart_arr' => $cart_arr, 
                    'loyalty_percent' => $loyalty_data['loyalty_percent'], 
                    'user' => $user, 
                    'delivery' => $delivery
                ];

                OrderSendEmail::dispatch($details, 'admin');

      //         \Mail::to(trim($email))->send(new \App\Mail\OrderAdmin($cart_arr,  $loyalty_data['loyalty_percent'], $user, $delivery));
            }
        }

        if($user->email != null && strpos($user->email, 'fakeemail') === false)
        {
            $details = [
                'email' => $user->email, 
                'cart_arr' => $cart_arr, 
                'loyalty_percent' => $loyalty_data['loyalty_percent'], 
                'user' => $user, 
                'delivery' => $delivery
            ];
            OrderSendEmail::dispatch($details, 'user');

        //    \Mail::to($user->email)->send(new \App\Mail\OrderClient($cart_arr, $loyalty_data['loyalty_percent'], $user, $delivery));
        }

        $order = Order::create($order);

        if($request->input('buy_one click', 0) != 0)
            return '';

     //   Cookie::expire('cart');

        if($request->has('payment') && $request->payment == 1)
        {
            $public_key = env('LIQPAY_PUBLIC', '');
            $private_key = env('LIQPAY_PRIVATE', '');
 
            $liqpay_obj = new LiqPay($public_key, $private_key);

            $params = array(
                'action'         => 'pay',
                'amount'         => $order['sum'],
                'currency'       => 'UAH',
                'description'    => "покупка",
                'order_id'       => $order->id,
                'version'        => '3',
                'result_url'     => route('order.success', ['order_id' => $order->id]),
                'server_url'     => route('liqpay.success'),
            );
     
            try{
               $liqpay_button = $liqpay_obj->cnb_form($params);
           //    dd($liqpay_button);
               return view('site.liqpay-page', ['liqpay_button' => $liqpay_button]);
            } catch( \Exception $e) {
                Log::debug($e->getMessage());
                return redirect()->route('order.cancel');     
            }
        }

        return redirect()->route('order.success', ['order_id' => $order->id]);
    }

    public function success($order_id)
    {
        return view('site.order-success', ['order_id' => $order_id]);
    }

    public function fail()
    {
        return view('site.order-fail');
    }

    public function liqpay_success(Request $request)
    { 
        $data = $request->data;

    //    var_dump($request->all());

        if(!$request->has('signature'))
            return null;
//data = 'eyJhY3Rpb24iOiJwYXkiLCJhbW91bnQiOjMwNiwiY3VycmVuY3kiOiJVQUgiLCJkZXNjcmlwdGlvbiI6Ilx1MDQzZlx1MDQzZVx1MDQzYVx1MDQ0M1x1MDQzZlx1MDQzYVx1MDQzMCIsIm9yZGVyX2lkIjo2NSwidmVyc2lvbiI6IjMiLCJyZXN1bHRfdXJsIjoiaHR0cHM6XC9cL25pY2VvcHRpY2EuY29tXC9vcmRlclwvc3VjY2Vzc1wvNjUiLCJzZXJ2ZXJfdXJsIjoiaHR0cHM6XC9cL25pY2VvcHRpY2EuY29tXC9vcmRlclwvbGlxcGF5XC9zdWNjZXNzIiwicHVibGljX2tleSI6InNhbmRib3hfaTMzNTExNTk2NzU0In0=' signature=ydT9k7qWNzK2Q6JF8fzA5coUHBA=
        

        $private_key = env('LIQPAY_PRIVATE', '');

        $signature = base64_encode(sha1($private_key.$data.$private_key, 1));

        echo $signature. ' '.$request->signature;

        if($signature != $request->signature)
            return null;
 
        $data =  json_decode(base64_decode($data), true);

        var_dump($data);

        $order = Order::find($data['order_id']);

        $order->update(['paid' => '1']); 
    }
}
