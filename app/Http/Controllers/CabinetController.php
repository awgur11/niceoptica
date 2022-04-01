<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Delivery;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class CabinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function user_data()
    {
        return view('cabinet.user-data');
    }

    public function loyalty()
    {
        $user_id = auth()->check() ? auth()->id() : 0;
        
        $loyalty_data = $this->loyalty_data($user_id);

        return view('cabinet.loyalty',[
            'orders_count' => $loyalty_data['orders_count'],
            'orders_sum' => $loyalty_data['orders_sum'],
            'loyalty_percent' => $loyalty_data['loyalty_percent'],
            'loyalties' => $loyalty_data['loyalties']
        ]);
    }
    public function delivery()
    {
        $deliveries = Delivery::where('user_id', auth()->id())->get();

        return view('cabinet.delivery', [
            'deliveries' => $deliveries,
        ]);
        
    }

    public function favorites(Request $request)
    {
        $favorites = $request->cookie('favorites');

        if($favorites != null)
        {
            $favorites_arr = json_decode($favorites, true);

            $products = Product::whereIn('id', $favorites_arr)->get();
        }
        else
            $products = collect([]);

        return view('cabinet.favorites', ['products' => $products]);
    }

    public function orders()
    {
        $orders = \App\Models\Order::where('user_id', auth()->id())->with('delivery')->get();

        return view('cabinet.orders', [
            'orders' => $orders
        ]);
    }
 
    public function change_user_data(Request $request)
    {
        $user = User::find(auth()->id());

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        return back()->with('message', __('Saved'));
    }

    public function change_password(Request $request)
    {
        $user = User::find(auth()->id());
       
        if(Hash::check($request->old_password, $request->user()->password))
        {
            if($request->new_password == $request->repeat_password)
            {
                $user->update(['password' => Hash::make($request->new_password)]);

                return back()->with('message', __('Password has been changed successfully')); 
            }
            else
            {
                return back()->with('error', __('You entered the wrong password again'));
            }
            
        }
        else
        {
            return back()->with('error', __('You entered your old password incorrectly'));
        }
 
    }
}
