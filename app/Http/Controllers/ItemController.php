<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use \App\Http\Services\PictureService;

class ItemController extends Controller
{
    public function index($type)
    {
        $items = Item::where('type', $type)->orderBy('position')->paginate(50);

        return view('admin.'.$type.'.items', ['items' => $items, 'type' => $type]);
    }
  //#ff8300
    public function create($type)
    {
        return view('admin.'.$type.'.create', ['type' => $type]);
    }
   
    public function store(Request $request, $type)
    {
        $save_picture = PictureService::call()
            ->addRequest($request)
            ->savePicture()
            ->resize(['one', 'five', 'four', 'mini']);

        $request = $save_picture->getRequest();

        $all = $request->all();

        $all['type'] = $type;

        $all['user_id'] = auth()->id();

        $item = Item::create($all);

        $item->update(['position' => $item->id]);

        if(isset($all['languages']))
        {
            $item->languages()->createMany($all['languages']);
        }
        return back()->with('message', 'Сохранено');
    }
  
    public function edit($id, Request $request)
    {
        $item = Item::with('languages')->find($id);

        if($request->has('ajax'))
           return $item->toJson();
        else
            return view('admin.items.edit', [
                'item' => $item,
                'type' => $item->type
            ]);
    }
  
    public function update($id, Request $request)
    {
        $item = Item::find($id);
         
        $save_picture = PictureService::call()
            ->addRequest($request)
            ->savePicture()
            ->resize(['one', 'five', 'four', 'mini']);

        $request = $save_picture->getRequest();  
 
        if($request->preview_path != null && $request->delete_picture != null)
        {
            delete_picture($item->preview_path, $item->preview_name);

            $item->preview_path = null;

            $item->preview_name = null;
        }

        $all = $request->all();

        $all['public'] = $all['public'] ?? 0;

        $item->update($all);

        if(isset($all['languages']))
        {
            foreach($all['languages'] as $al)
            {
                if($item->languages()->where('language', $al['language'])->first() != null)
                    $item->languages()->where('language', $al['language'])->update($al);
                else
                    $item->languages()->create($al);
            }
        }
        return back()->with('message','Saved');
    }

    public function destroy($id)
    {
        $item = Item::find($id); 

        delete_picture($item->preview_path, $item->preview_name);
      
        $item->languages()->delete();

        $item->delete();
    }
}
