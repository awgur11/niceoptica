<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NovaPochtaController extends Controller
{
    public function get_cities(Request $request)
    {
        if(!$request->has('string'))
            return false;

        $string = $request->input('string');

        if(trim($string) == '')
            return false;

        if(preg_match('/[a-zA-Z0-9]/', $string))
            return false;

        $body = [
            "apiKey" => env('Nova_Poshta'),
            "modelName" => "Address",
            "calledMethod" => "getCities",
            "methodProperties" => [
                "FindByString" => $string,
                "Limit" => 5
                ] 
            ];

        return $this->make_request($body);        
    }

    public function get_warehouses(Request $request)
    {
        $city_ref = $request->input('city_ref');

        $body = [
            
            "modelName" => "AddressGeneral",
            "calledMethod" => "getWarehouses",
            "methodProperties" => [
                "Language" => "ru",
                "CityRef" => $city_ref,
            ],
            "apiKey" => env('Nova_Poshta')
        ];
        
        return $this->make_request($body);
    }

    public function get_streets(Request $request)
    {
        if(!$request->has('string') || !$request->has('city_ref'))
            return false;

        $string = $request->input('string');
        $city_ref = $request->input('city_ref');

        if(trim($string) == '')
            return false;

        if(preg_match('/[a-zA-Z0-9]/', $string))
            return false;

        $body = [
            
            "modelName" => "Address",
            "calledMethod" => "getStreet",
            "methodProperties" => [
               "FindByString" => $string,
                "CityRef" => $city_ref,

            ],
            "apiKey" => env('Nova_Poshta')
        ];
        return $this->make_request($body);
    }

}
