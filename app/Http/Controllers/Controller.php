<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use \App\Services\PictureService;
use App\Models\Item;
use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function alt_title($str)
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
    public function saving_picture($image, $ext, $data)
    {
        $data['original'] = $data['original'] ?? false;
        $data['watermark'] = $data['watermark'] ?? false;
        $data['thumbs'] = $data['thumbs'] ?? [1920, 1280, 585, 282, 100];

        $response = array(
            'success' => null,
            'error' => null,
            'path' => null,
            'name' => null
        );
        //$path = '/'.rand(0,100).'/'.rand(0,100).'/'.rand(0,100).'/';
        $path = '/test/';
        $name = rand(10000000, 99999999).'.'.$ext;

        if(!in_array(strtolower($ext), ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp', 'mp4']))
        {
            $response['success'] = false;
            
            $response['error'] = 'Формат файла не поддерживается';
            
            return $response;
        }
        else
        {
            $image->save(storage_path('app/public/images'.$path.$name));

            $response = [
                'success' => true,
                'path' => $path,
                'name' => $name,
                'ext' => strtolower($ext)
            ];

            if(strtolower($ext) == 'mp4' ||
                strtolower($ext) == 'svg')
            {
                return $response;
            } 
            if($data['thumbs'] != null)
            {
                $resize_response = $this->img_resize($path, $name, $data);
                $response = $resize_response == NULL ? $response : $resize_response;
            }
            return $response;
        }

    }
    public function save_picture($image, $data = [])
    {
        $ext = $image->getClientOriginalExtension();

        $image = \Image::make($image);
 
        return $this->saving_picture($image, $ext, $data);      
    }

    public function save_picture_link($link, $data = [])
    {
        $ext = pathinfo($link, PATHINFO_EXTENSION);

        try { 
            $image = \Image::make($link); 
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'error' => __('Error raised while downloading'),
            ];
            return $response;
        }
        return $this->saving_picture($image, $ext, $data);       
    }

    public function img_resize($path, $name, $data) 
    {
        try {
            $img_obj = \Image::make(storage_path('app/public/images'.$path.$name));
        } catch (\Exception $e){
            $response = [
                'success' => false,
                'error' => __('file reading error'),
            ];   
        } 

        foreach($data['thumbs'] as $thumb)
        {
            try{
                $img_obj->resize($thumb, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path("app/public/images".$path.$thumb.'-'.$name));
            } catch(\Exception $e) {
                $response = [
                    'success' => false,
                    'error' => __('error raised while resizing'),
                ];
            }
        }
        if($data['original'] == false)
        {
            \Storage::disk('public')->delete('images'.$path.$name);
        }   
        return $response = $response ?? NULL;
    }
    //DELETE FILE FROM STORAGE
    public function picture_del($path, $name = null)
    {
        if(is_file(storage_path('app/public/images'.$path)))
        {
            \Storage::disk('public')->delete('images'.$path);

            return response('success', 200);
        }
        else
            return NULL;

        $images = scandir(storage_path('app/public/images'.$path));
        unset($images[0]);
        unset($images[1]); 

        foreach($images as $image)
        {
            if($name != null)
            {
                if(strpos($image, $name) === false)
                    continue;
            }
            \Storage::disk('public')->delete('images'.$path.$image);
        }   
    }

    public function create_tree($model, $table, $parent_id = 0)
    {   
        $full_model =  '\App\Models\\'.$model;
        $full_model = new $full_model;
        $items =  $full_model::with('language:id,title,page_id')
            ->where('parent_id', $parent_id)
            ->orderBy('position')
            ->get();

        if($items->count() == 0)
            return '';;

        $tree = '<ul class="select-parent sortable-list" data-id="'.$parent_id.'">';

        foreach($items as $k => $item)
        {
            $tree .= '<li class="page-string item-position '.($k == 0 ? ' item-position-first' : '').'" data-column="position" data-table="'.$table.'" data-position="'.$item->position.'" id="item-'.$item->id.'" data-id="'.$item->id.'">
                <div class="item-block d-flex align-items-center">
                    <div class="item-position"  data-table="'.$table.'" data-id="'.$item->id.'" data-column="parent_id"  title="Вы можете перемещать данную строку"><i class="fas fa-arrows-alt"></i>
                    </div> 
                    <div class="item-title ml-1" data-table="'.$table.'" data-value="'.($item->position-1).'"  data-parent_id="'.$item->parent_id.'">'.$item->language->title.'
                    </div> 
                    <div class="item-parent d-flex" data-table="'.$table.'" data-value="'.($item->id).'" data-column="parent_id">
                        <a href="'.route($table.'.edit', ['id' => $item->id]).'" class="btn btn-outline-primary btn-sm mr-1"><i class="fas fa-pencil-alt"></i>
                        </a>
                        <div class="btn btn-outline-danger delete-item btn-sm" data-url="'.route($table.'.delete', ['id' => $item->id]).'" data-id="'. $item->id.'"><i class="far fa-trash-alt"></i> 
                        </div> 
                    </div>

                </div>';

            $tree .= $this->create_tree($model, $table, $item->id);

            $tree .= '</li>';
        }  
        $tree .= '</ul>';

        return $tree;
    }
    public function make_request($body)
  {
    $body = json_encode($body);

    $client = new \GuzzleHttp\Client([
      'headers' => [ 'Content-Type' => 'application/json' ]
    ]);

    $error = null;

    try{
      $response = $client->request('POST', 'https://api.novaposhta.ua/v2.0/json/ ', ['body' => $body]);
    } catch (RequestException $e) {
        $error .= 'Ошибка при выполнении запрса';//Psr7\str($e->getRequest());
        if ($e->hasResponse()) {
          $error .= 'Ошибка при получении ответа';//Psr7\str($e->getResponse());
        }
      }

    if($error == null)
    {
      $data = json_decode($response->getBody()->getContents());

      if($data->success == true)
      {
        $response = [
          'success' => true,
           'data' => $data->data
        ];
      }
      else{
        $response = [
          'success' => false,
          'data' => implode(', ', $data->errors)
        ];
      }
    }
    else
      $response = [
        'success' => false,
        'errors' => $error
      ];
      
    return $response;
  }
    // проверяем, не были ли удалены товары пока они находились в корзине
    public function corrent_cart_content($request)
    {
        $cart = $request->cookie('cart');

        $was_corrected = false;

        if($cart != null)
        {
            $cart_arr = json_decode($cart, true);

            foreach($cart_arr as $k => $ca)
            {
                $product = \App\Models\Product::find($ca['id']);

                if($product == null)
                {
                    unset($cart_arr[$k]);
                    $was_corrected = false;
                }
            }
            if($was_corrected)
            {
                \Cookie::queue('cart', json_encode(array_values($cart_arr)));

                return response();
            }

            return array_values($cart_arr);
        }
        return [];
    }
    /*Members discount*/
    public function loyalty_data($user_id = 0)
    {
  /*      if(session('loyalty_data') != null)
        {
            return session('loyalty_data');
        }
*/
        $loyalties = Item::with('language')->where('type', 'loyalty')->get();

        $response = [
            'orders_count' => 0,
            'orders_sum' => 0,
            'loyalty_percent' => $loyalties->sortBy('nol1')->first()->nol1,
            'loyalties' => Item::with('language')->where('type', 'loyalty')->get(),
        ];

        if($user_id == 0)
        {
            return $response;
        }

        if(!auth()->check())
        {
            $response['orders_count'] = 0;

            $response['orders_sum'] = 0;
        }
        else
        {
            $user = User::with('orders')->find(auth()->id());

            $response['orders_count'] = $user->orders->count();

            $response['orders_sum'] = $user->orders->sum('sum');
        }

        $temp = $loyalties->where('nol2', $response['orders_count'])->sortBy('nol1')->first();

        if($temp == null)
        {
            $temp = $loyalties->where('nol3', '<=', $response['orders_sum'])->sortByDesc('nol1')->first();

            if($temp == null)
            {
                $temp = $loyalties->where('nol2', '=>',$response['orders_count'])->sortByDesc('nol1')->first();
            }
        }

        if($temp == null)
            $response['loyalty_percent'] = 3;
        else
            $response['loyalty_percent'] = $temp->nol1;


        session(['loyalty_data' => $response]);

        return $response;
    }
}
 