<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filter;
use App\Models\Fvalue;
use App\Models\Catalog;
use App\Http\Services\PictureService;

class FvalueController
{
    public function arrange_auto(Request $request)
    {
        $filter_id = $request->filter_id;
        $direction = $request->input('direction', '');

        $fvalues = Fvalue::with('language:fvalue_id,title')->where('filter_id', $filter_id)->get()->{'sortBy'.$direction}('language.title')->values();

    //    dd($fvalues->pluck('alt_title'));

        foreach($fvalues as $k => $v)
        {
           Fvalue::where('id', $v->id)->update(['position' => $k]);
        }
        return $fvalues->map(function($el){
            $el->edit = route('fvalues.edit', ['id' => $el->id]);
            $el->update = route('fvalues.update', ['id' => $el->id]);
            $el->delete = route('fvalues.delete', ['id' => $el->id]);

            return $el;
        })->toJson();

    }
    public function get_by_ajax(Request $request)
    {
        $offset = $request->input('offset', 0);
        $filter_id = $request->filter_id;
        $limit = $request->limit ?? Fvalue::where('filter_id', $filter_id)->count();

        $catalog_id = $request->input('catalog_id', 0);

        if($catalog_id != 0)
        {
            $fvalues_ids_arr = Catalog::findOrFail($catalog_id)->fvalues()->pluck('fvalues.id')->toArray();
        }
        else
            $fvalues_ids_arr = [];

        $fvalues = Fvalue::with('language')->where('filter_id', $filter_id)->orderBy('position')->skip($offset)->limit($limit)->get()->values()->map(function($el) use($fvalues_ids_arr){
            $el->edit = route('fvalues.edit', ['id' => $el->id]);
            $el->update = route('fvalues.update', ['id' => $el->id]);
            $el->delete = route('fvalues.delete', ['id' => $el->id]);

            if(in_array($el->id, $fvalues_ids_arr))
                $el->checked = 'checked';
            else
                $el->checked = '';

            return $el;
        })->toJson();

        return $fvalues;
    }

	public function destroy($id)
    {
        $fvalue = Fvalue::find($id);

        $fvalue->products()->detach();

        $fvalue->catalogs()->detach();

        $fvalue->languages()->delete();

        $fvalue->delete();

        return response(null, 204);       
    }

    public function store(Request $request, $parser = null)
    {
        $save_picture = PictureService::call()
            ->addRequest($request)
            ->savePicture();

        $request = $save_picture->getRequest();

        $all = $request->all();

        $title = $all['languages'][0]['title'];

        $all['alt_title'] = alt_title($title);

        $fvalue = Fvalue::create($all);

        $fvalue->languages()->createMany($all['languages']);

        $fvalue->update(['position' => $fvalue->id]);

        if($parser == null)
            return back()->with('message', 'Saved');
        else
            return $fvalue->id;
    }
    public function store_ajax(Request $request)
    {
        $all = $request->all();

        $catalog_id = $all['catalog_id'];

        unset($all['catalog_id']);

        $all['alt_title'] = alt_title($all['languages'][0]['title']);

        $fvalue = Fvalue::create($all);

        $fvalue->update([
            'position' => $fvalue->id
        ]);

        $fvalue->catalogs()->attach($catalog_id);

        $fvalue->languages()->createMany($all['languages']);

        return Fvalue::with('language')->find($fvalue->id)->toJson(); 
    }

    public function edit($id)
    {
        $fvalue = Fvalue::with('languages')->find($id);

        if($fvalue != null)
            $fvalue = $fvalue->toArray();

         return $fvalue;
    }

    public function update(Request $request, $id)
    {
        $save_picture = PictureService::call()
            ->addRequest($request)
            ->savePicture();

        $request = $save_picture->getRequest();
        
        $all = $request->all();

        $fvalue = Fvalue::with('languages')->find($id);

        $all['alt_title'] = alt_title($all['languages'][0]['title']);

        $fvalue->update($all);

        foreach($all['languages'] as $al)
        {
            if($fvalue->languages()->where('language', $al['language'])->first() != null)
                $fvalue->languages()->where('language', $al['language'])->update($al);
            else
                $fvalue->languages()->create($al);
        }
        return back()->with('message', 'Saved');
    }
}