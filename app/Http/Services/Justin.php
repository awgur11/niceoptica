<?php 

namespace App\Http\Services;

use GuzzleHttp\Client;

class Justin
{

	private $url = 'https://api.justin.ua/justin_pms/hs/v2/runRequest';

	public static function call()
	{
		return new Justin();
	}

	public function getCities($string)
	{
		$response_arr = [];
        $response_arr['success'] = false;
        $response_arr['data'] = [];

		if(trim($string) == '')
			return $response_arr;

		$client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);


        $body = [
        	"keyAccount" => env('JUSTIN_LOGIN'),
        	"sign" => sha1(env('JUSTIN_PASSWORD').':'.date('Y-m-d')),
        	"request" => "getData",
            "type" => "catalog",
            "name" => "cat_Cities",
            "language" => "RU",
            "TOP" => 10,
            "filter" => [
            	[
            	    "name" => "descr",
                    "comparison" => "like",
                    "leftValue" => $string
                ]
            ]
        ];

        $response = $client->post($this->url, ['body' => json_encode($body)]);

        $content = json_decode($response->getBody()->getContents(), true);
       

        if(!isset($content['data']) || $content['data'] == [])
            return $response_arr;

        $response_arr['success'] = true;

        foreach($content['data'] as $d)
        {
        	$response_arr['data'][] = [
        		'title' => $d['fields']['descr'],
        		'uuid' => $d['fields']['uuid']
        	];
        }
        return json_encode($response_arr);
	}

	public function getWarehouses($uuid = null)
	{
		$response_arr = [];
        $response_arr['success'] = false;
        $response_arr['data'] = [];


		if(trim($uuid) == '')
			return $response_arr;

		$client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);


        $body = [
        	"keyAccount" => env('JUSTIN_LOGIN'),
        	"sign" => sha1(env('JUSTIN_PASSWORD').':'.date('Y-m-d')),
        	"request" => "getData",
            "type" => "request",
            "name" => "req_DepartmentsLang",
            "language" => "ru",
        //    "TOP" => 150,
            "params" => [
            	"language" => "ru",
            ],
           "filter" => [
          	    [
            	    "name" => "city",
                    "comparison" => "equal",
                    "leftValue" => $uuid

                ] 
            ] 
        ];

        $response = $client->post($this->url, ['body' => json_encode($body)]);

        $content = json_decode($response->getBody()->getContents(), true);


        if(!isset($content['data']) || $content['data'] == [])
            return $response_arr;

        $response_arr['success'] = true;

        foreach($content['data'] as $d)
        {
        	$response_arr['data'][] = [
        		'title' => $d['fields']['address'].' '.$d['fields']['descr'],
        		'uuid' => $d['fields']['code']
        	];
        }
        return json_encode($response_arr);
	}
}