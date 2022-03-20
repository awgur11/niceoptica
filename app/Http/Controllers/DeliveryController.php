<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;

class DeliveryController extends Controller
{
    public function store(Request $request)
    {
        $create = $request->all();
        $create['user_id'] = auth()->id();

        Delivery::create($create);

        return back()->with('message', __('Saved'));
    }
  
    public function delete($id)
    {
        Delivery::where('id', $id)->where('user_id', auth()->id())->delete();
    }

    public function select_main($id)
    {
        Delivery::where('user_id', auth()->id())->update([
            'main' => 0]);

        Delivery::where('id', $id)->where('user_id', auth()->id())->update([
            'main' => 1]);
    }
}
