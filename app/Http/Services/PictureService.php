<?php

namespace App\Http\Services;

use App\Models\Picture;

class PictureService
{
	public $request;

	protected $path;

	protected $name;

	public $errors;

	protected $image;

	protected $file;

	protected $preview;

	protected $preview_link;

	protected $delete_picture;

	protected $ext;
 
	public function __construct()
	{
		$this->errors = [];
	}

	public static function call()
	{
		return new PictureService();
	}

	public function addRequest($request)
	{
		$this->request = $request;

		$this->preview = $request->has('preview') ? $request->file('preview') : NULL;

		$this->preview_link = $request->preview_link;

		$this->delete_picture = $request->delete_picture ?? null;

		$this->path = $request->preview_path ?? NULL;

		$this->name = $request->preview_name ?? NULL;

		$this->id = $request->id ?? NULL;

		return $this;
	}

	public function addLink($link)
	{
		$this->preview_link = $link;

		return $this;
	}

	public function savePicture()
	{
		if($this->preview != NULL)
		{
			if($this->path != NULL && $this->name != NULL)
			    delete_picture($this->path, $this->name);

			$this->ext = strtolower($this->preview->getClientOriginalExtension());


            $this->name = rand(11111111, 99999999).'.'.$this->ext;

		   $this->path = '/'.rand(0, 99).'/'.rand(0, 99).'/'.rand(0, 99).'/';
		   // $this->path = '/test/';
				
		//$this->image->save(storage_path('app/public/images'.$this->path.$this->name));
		   \Storage::disk('public')->put('images'.$this->path.$this->name, file_get_contents($this->preview));
//$this->image->move(storage_path('app/public/images'.$this->path), $this->name);
		return $this;
    
                     
		} 
		elseif($this->preview_link != null)
		{
			if($this->path != NULL && $this->name != NULL)
			    delete_picture($this->path, $this->name);

			$this->ext = strtolower(pathinfo($this->preview_link, PATHINFO_EXTENSION));

			if(!in_array($this->ext, ['jpg', 'png', 'gif', 'webp', 'svg']))
			{
				
				$this->file = file_get_contents($this->preview_link);

				$this->name = rand(11111111, 99999999).'.'.$this->ext;

		        $this->path = '/'.rand(0, 99).'/'.rand(0, 99).'/'.rand(0, 99).'/';
		        //$this->path = '/test/';

		        \Storage::disk('public')->put('files'.$this->path.$this->name, $this->file);

				return $this;
			}

	//		try { 
                $this->image = \Image::make($this->preview_link); 
                $this->name = rand(11111111, 99999999).'.'.$this->ext;

		//   $this->path = '/'.rand(0, 99).'/'.rand(0, 99).'/'.rand(0, 99).'/';
		   $this->path = '/test/';


				
		//$this->image->save(storage_path('app/public/images'.$this->path.$this->name));
		  \Storage::disk('public')->put('images'.$this->path.$this->name, file_get_contents($this->preview_link));
     //       } catch (\Exception $e) {
   //         	$this->errors[] = $e->getMessage();

      //      	return $this;           	
      //      }
		  return $this;
		}
		elseif($this->delete_picture != NULL)
		{
			delete_picture($this->path, $this->name);

			$this->path = NULL;

			$this->name = NULL;

		    return $this;
		}
		else
		{
			return $this;
		}
		
	}

	

	public function resize(array $thumbs, $original = false)
	{
		if($this->errors != [])
			return $this;

		if($this->preview_link == NULL && $this->preview == NULL)
			return $this;

		if(!in_array($this->ext, ['jpg', 'png', 'gif']))
			return $this;

		try {
    		$img = \Image::make(storage_path('app/public/images'.$this->path.$this->name));
    	} catch (Exception $e) {
    		return $this;
    	}

		foreach($thumbs as $prefix)
        {
        	if($prefix == 'fhd')
			   $width = 1920;
			if($prefix == 'one')
			   $width = 1440;
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

            try{
                $img->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path("app/public/images".$this->path.$prefix.'-'.$this->name));
            } catch(\Exception $e) {
            	$this->errors[] = $e->getMessage(); 
            }
        }

        if($original === false)
        	\Storage::disk('public')->delete('images'.$this->path.$this->name);

        return $this;
	}

	public function rotate($deg = -90)
	{
		$picture = Picture::find($this->id);

		$this->name = $picture->preview_name;

		$this->path = $picture->preview_path;

		$images = scandir(storage_path('app/public/images'.$this->path));

        unset($images[0]);
        unset($images[1]); 

        foreach($images as $image)
        {
            if(strpos($image, $this->name) === false)
                continue;

            $img = \Image::make(storage_path('app/public/images'.$this->path.'/'.$image));

            $img->rotate($deg)->save();
        }
        return '/storage/images'.$this->path.'/mini-'.$this->name;
	}

	public function getRequest()
	{
		if($this->name != null && $this->path != null)
		    $this->request->request->add([
			    'preview_name' => $this->name,
			    'preview_path' => $this->path,
			    'extension' => $this->ext,
		    ]);

		return $this->request;
	}

	public function getErrors()
	{
		return implode(', ', $this->errors);
	}

	public function toDB($product_id = 0)
	{
		if($this->path != '')
		{
		    Picture::create([
			    'preview_path' => $this->path,
			    'preview_name' => $this->name,
			    'product_id' => $product_id,
			    'extension' => $this->ext,
			    'user_id' => auth()->id()
		    ]);
	    }
	}

	public function getUrl()
	{
		return '/storage/images'.$this->path.$this->name;
	}
}