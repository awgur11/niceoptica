<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\Option_languages;
use \App\Http\Services\PictureService;

 
class OptionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($page)
	{
		return view('admin.option.'.$page);
	}
	public function edit($key)
	{
		$option = Option::with('languages')->where('key', $key)->first();

		if($option != null)
		    return json_encode($option);
		else
			return null;
	}
	public function update(Request $request)
	{
		$option = Option::where('key', $request->key)->first();

		if($request->type == 'array')
		{
			$request->value = serialize($request->value);
		}

		if($option == null)
		{
		    $option = Option::create([
			    'key' => $request->key,
			    'type' => $request->type,
			    'place' => $request->input('place', 1),
			    'value' => $request->value,
		    ]);

		    if($request->languages != null)
        	    $option->languages()->createMany($request->languages);
        }
        else
        {
        	$option->update([
        		'value' => $request->value
        	]);

        	if($request->languages != null)
             	foreach($request->languages as $lang)
            	{
            		if($option->languages()->where('language', $lang['language'])->first() != null)
        	    		$option->languages()->where('language', $lang['language'])->update($lang);
        		    else
        			    $option->languages()->create($lang);
        	    }
        }
        print_r($request->all());
    }
    //SAVING PICTURE BY AJAX AND RETURNING PITURE'S URI
    public function update_preview(Request $request)
    {   
        $errors = []; 

    	if(!$request->hasFile('preview'))
    	{
    		$errors[] = __('Some error raised while file uploading');
    		
    		return json_encode([
    			'success' => false,
    			'errors' => implode(', ', $errors)
    		]);
    	}

    	$extension = strtolower($request->file('preview')->getClientOriginalExtension());

    	$file = $request->file('preview');
    	$key = $request->key;
    	$thumbs = $request->input('thumbs', 'fhd, one, two, tree, four, five, six, mini');
    	$file_type = $request->input('file_type', 'image');
    	$allowed_ext = $request->allowed_ext ?? null;
    	$preview_name = rand(11111111, 99999999).'.'.$extension;
	 	$preview_path = '/test/';//'/'.rand(0, 99).'/'.rand(0, 99).'/'.rand(0, 99).'/';
	 	$original = $request->input('original', false);
 
    	if($allowed_ext == null)
    	{
    		if($file_type == 'image')
	 			$allowed_ext = 'jpg, jpeg, png, gif, webp';
	 		elseif($file_type == 'video')
	 			$allowed_ext = 'mp4, webm';
	 		elseif($file_type == 'file')
	 			$allowed_ext = 'doc, docx, xls, xlsx, pdf';
    	}

    	if($file_type == 'image')
		{
			try { 
                \Storage::disk('public')->put('images'.$preview_path.$preview_name, \Image::make($file)->stream());
            } catch (\Exception $e) {

            	$errors[] = $e->getMessage();

            	return json_encode([
    			    'success' => false,
    			    'errors' => implode(', ', $errors)
    		    ]);
            }

            if(strpos($thumbs, 'five') === false)
            	$thumbs .= ', five';

            foreach(explode(',', $thumbs) as $prefix)
            {
            	$prefix = trim($prefix);

        	    if($prefix == 'fhd')
			        $width = 1920;
			    if($prefix == 'one')
			        $width = 1140;
			    if($prefix == 'two')
			        $width = 560;
			    if($prefix == 'tree')
			        $width = 370;
			    if($prefix == 'four')
			        $width = 275;
			    if($prefix == 'five')
			        $width = 218;
			    if($prefix == 'six')
			        $width = 180;
			    if($prefix == 'mini')
			        $width = 80;

			    if(is_numeric($prefix))
				    $width = $prefix;

                try{
                    \Image::make(storage_path('app/public/images'.$preview_path.$preview_name))->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save(storage_path("app/public/images".$preview_path.$prefix.'-'.$preview_name));
                } catch(\Exception $e) {
            	    return json_encode([
    			        'success' => false,
    			        'errors' => $e->getMessage(),
    		        ]);
                }
            }

            if($original === false)
        	    \Storage::disk('public')->delete('images'.$preview_path.$preview_name);

	    }
	    elseif($file_type == 'file')
	    {
			\Storage::disk('public')->put('files'.$preview_path.$preview_name, file_get_contents($file));

	    }
	    elseif($file_type == 'video')
	    {
			\Storage::disk('public')->put('videos'.$preview_path.$preview_name, file_get_contents($file));
	    }

	    $option = Option::where('key', $key)->first();

	    if($file_type != 'image')
	    	$thumbs = '';

        if($option == null)
        	Option::create([
        		'key' => $key,
        		'preview_path' => $preview_path,
        		'preview_name' => $preview_name,
        		'type' => $file_type,
        		'thumbs' => $thumbs,
        		'extension' => $extension
        	]);
        else
        {
        	delete_picture($option->preview_path, $option->preview_name);

        	$option->update([
        		'preview_path' => $preview_path,
        		'preview_name' => $preview_name,
        		'type' => $file_type,
        		'thumbs' => $thumbs,
        		'extension' => $extension
        	]);
        }
        $prefix = $file_type == 'image' ? 'five-' : '';

        return json_encode([
            'success' => true,
            'response' => asset("storage/".$file_type."s".$preview_path.$prefix.$preview_name),
        ]);
    }

    public function delete_preview(Request $request)
    {
    	$key = $request->key;

    	$option = Option::where('key', $key)->first();

    	if($option->type == 'file')
    		\Storage::disk('public')->delete('files'.$option->preview_path.$option->preview_name);
    	elseif($option->type == 'video')
    		\Storage::disk('public')->delete('videos'.$option->preview_path.$option->preview_name);
    	else
        	delete_picture($option->preview_path, $option->preview_name);

    	$option->delete();
    }
}
