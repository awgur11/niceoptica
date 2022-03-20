<?php

namespace App\Http\Services;

use App\Http\Services\PictureService;

class ContentService
{
	public $content;

    public function __construct()
    {

    }

    public static function factory()
    {
    	return new ContentService;
    }

    public function uploadPictures($content)
    {
    	preg_match_all('/http:\/\/[a-zA-Z0-9:\.\-% \/]*/i', $content, $src_arr);


    	$src_new_arr = [];

        foreach($src_arr[0] as $k => $src)
        {
            try {
                    $src_new_arr[] = PictureService::call()->addLink($src)->savePicture()->getUrl();
            } catch (\Exception $e)
            {
                unset($src_arr[0][$k]);
            }
        }

        $this->content = str_replace($src_arr[0], $src_new_arr, $content);

        return $this;
    }

}