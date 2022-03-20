<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Services\Justin;

class JustinController extends Controller
{
    public function get_cities(Request $request)
    {
        $string = $request->string;

        if(trim($string) == '')
            return null;

        return Justin::call()->getCities($string);
    }

    public function get_warehouses(Request $request)
    {
        $uuid = $request->uuid;

        if(trim($uuid) == '')
            return null;

        return Justin::call()->getWarehouses($uuid);
    }
}
