<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use \Dejurin\GoogleTranslateForFree;

class TranslationController extends Controller
{
	public function saveFile(Request $request)
	{
		$locale = $request->to;
		$phrases = $request->phrases;
		$translations = $request->translations;
		$tr_arr = [];

		foreach($phrases as $k => $ph)
		{
			if(!isset($translations[$k]))
				continue;
			
			if($translations[$k] == '' || $ph == '')
				continue;
			$tr_arr[$ph] = $translations[$k];
		}
		
		$file_path = base_path('resources/lang/'.$locale.'.json');

		$tr_json = json_encode($tr_arr, JSON_UNESCAPED_UNICODE);
		$tr_json = str_replace("\",\"", "\",\n\"", $tr_json);

		file_put_contents($file_path, $tr_json);

		return back()->with('message', __('Saved'));
	}
	public function translate_one_phrase(Request $request)
	{
		$from = $request->from;
		$to = $request->to;
		$phrase = $request->phrase;

		$to = $to == 'ua' ? 'uk' : $to;
		$from = $from == 'ua' ? 'uk' : $from;

		try {
		    $tr = new GoogleTranslateForFree();
            $result = $tr->translate($from, $to, $phrase, 3); 

            return $result;
        } catch (\Exception $e){
        	return __('Some error raised while translating');
        }
	}

	public function scanViews(Request $request)
	{
		$locale = $request->locale;
		$language_title = $request->title;

        $views_dir_arr = scandir(resource_path('views'));

        $views_list = array();

        function scan($route)
        {
        	$views_dir_arr = scandir($route);

        	$views_list = [];

        	foreach($views_dir_arr as $dir)
            {
        	    if($dir == '.' || $dir == '..')
        		    continue;

        		if(is_dir($route.'/'.$dir))
        			$views_list = array_merge($views_list, scan($route.'/'.$dir));
        		if(is_file($route.'/'.$dir))
        		    $views_list[] = $route.'/'.$dir;
        	}
        	return $views_list;
        }       

        function preg_lang($file_path)
        {
        	$file_content =  file_get_contents($file_path); 

        	preg_match_all('/@lang\([a-zA-Z0-9, \'\"]*\)/i', $file_content, $matches_lang);
        	preg_match_all('/__\([a-zA-Z0-9, \'\"]*\)/i', $file_content, $matches__);

        	return array_merge($matches_lang[0], $matches__[0]);
        }

        $views_list = scan(resource_path('views'));


        $all_langs = [];

        foreach($views_list as $view)
        {
        	$all_langs = array_merge($all_langs, preg_lang($view));
        }

        $all_langs = array_unique($all_langs);
        $all_langs = array_values($all_langs);

        foreach($all_langs as $k => $v)
        {
        	$all_langs[$k] = str_replace(['@lang(', '\'', '"', ')', '__('], '', $v);

        	if(trim($all_langs[$k]) == '')
        		unset($all_langs[$k]);
        }

        if(file_exists(resource_path('lang/'.$locale.'.json')))
        {
		    $file = file_get_contents(resource_path('lang/'.$locale.'.json'), "r");
		    $file = json_decode($file, true);

		    $file_keys = array_keys($file);

		    $absent_phrases = array_diff($all_langs, $file_keys);
		}
		else
		{
			$absent_phrases = $all_langs;
			$file = [];
		}

		return view('admin.translations.file', [
			'file' => $file,
			'locale' => $locale,
			'absent_phrases' => $absent_phrases,
			'language_title' => $language_title
		]);
    }
}
