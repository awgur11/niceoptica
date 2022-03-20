<?php

if(!function_exists('delete_picture')) {
	function delete_picture($path, $name = null)
	{
        foreach(['images', 'files', 'videos'] as $base)
        {

		    if(is_dir(storage_path('app/public/'.$base.$path)) && $path != null)
		    {
			    $images = scandir(storage_path('app/public/'.$base.$path));
                unset($images[0]);
                unset($images[1]);

                foreach($images as $image)
                {
                    if($name != null)
                    {
                        if(strpos($image, $name) === false)
                            continue;
                    }
                    \Storage::disk('public')->delete($base.$path.$image);
                } 
		    }
        }
	}
}
if(!function_exists('alt_title')){
	function alt_title($str)
	{
		$rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',' ');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya','-');

        $str = trim($str);

        $alt_title = str_replace($rus, $lat, $str);

        $pattern = '/[^a-zA-Z0-9-_]/';

        $replacement = '';

        $alt_title = preg_replace($pattern, $replacement, $alt_title);

        return strtolower($alt_title);
	}
}