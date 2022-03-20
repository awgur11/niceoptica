<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Catalog;
use App\Models\Category;
use App\Models\Filter;
use App\Models\Colour;
use App\Models\Size;
use \App\Http\Services\PictureService;
use \App\Http\Services\TreeService;

class CatalogController extends Controller
{ 
    public function index(Request $request)
    {
        $catalogs = Catalog::with([
            'language:id,title,catalog_id',
            'parent.language:id,title,menu,catalog_id',
        ])->withCount('products')->orderBy('position')->get();

        return view('admin.catalogs.catalogs', ['catalogs' => $catalogs]);
    }

    public function index_tree()
    {
        $tree = TreeService::call('Catalog', 'catalogs')->html();

        $type = NULL;

        return view('admin.catalogs.catalogs_tree', [
            'tree' => $tree,
            'type' => $type
        ]);
    }

    public function create()
    {
        $filters = Filter::with(['language', 'fvalues.language'])
            ->orderBy('position')
            ->get();

        return view('admin.catalogs.create', ['filters' => $filters]);
    }

    public function store(Request $request)
    {
        $save_picture = PictureService::call()
            ->addRequest($request)
            ->savePicture()
            ->resize(['fhd', 'one', 'tree', 'five', 'mini']);

        $request = $save_picture->getRequest();

        $all = $request->all();
        
        $all['user_id'] = auth()->id();

        $title = $all['languages'][0]['title'];

        $all['alt_title'] = alt_title($title); 

        $catalog = Catalog::create($all);

        $catalog->update(['position' => $catalog->id]);

        if(isset($all['filters']))
        {
            $catalog->filters()->sync($all['filters']);
        }
        if(isset($all['fvalues']))
        {
            $catalog->fvalues()->sync($all['fvalues']);      
        }

        $catalog->languages()->createMany($all['languages']);
    
        return back()->with('message', 'Saved');
    }

    public function edit($id)
    {
        $catalog = Catalog::find($id);

        $catalog_id = $catalog->id;

        $filters = Filter::with([
            'language:title,filter_id',
            'fvalues.catalogs:id',
            'fvalues.language:title,fvalue_id', 
            'catalogs:id',
        ])
            ->orderBy('position')
            ->get()->map(function($el) use ($catalog_id) {
                if($el->catalogs->where('id', $catalog_id)->first() != null)
                    $el->checked = true;
                else
                    $el->checked = false;

                $el->fvalues->map(function($val) use($catalog_id) {
                    if($val->catalogs->where('id', $catalog_id)->first() != null)
                        $val->checked = true;
                    else
                        $val->checked = false;

                    return $val;

                });

                return $el;
            });



        return view('admin.catalogs.edit', [
            'catalog' => $catalog,
            'filters' => $filters,
        ]);
    }

    public function update(Request $request,$id)
    {
        $catalog = Catalog::find($id);
  
        $save_picture = PictureService::call()
            ->addRequest($request)
            ->savePicture()
            ->resize(['fhd', 'one', 'tree', 'four', 'five', 'mini']);

        $request = $save_picture->getRequest();

        $all = $request->all();

        $title = $all['languages'][0]['title'];

        $all['alt_title'] = alt_title($title); 

        $catalog->update($all);

        if(isset($all['filters']))
        {
            $catalog->filters()->sync($all['filters']);
        }
       if(isset($all['fvalues']))
        {
            $catalog->fvalues()->sync($all['fvalues']);      
        }
        foreach($all['languages'] as $lang)
        {
            if($catalog->languages()->where('language', $lang['language'])->first() != null)
                $catalog->languages()->where('language', $lang['language'])->update($lang);
            else
                $catalog->languages()->create($lang);
        }
        if($save_picture->errors != [])
            return back()->with('my_errors', $save_picture->getErrors());
        
        return back()->with('message','Saved');
    }

    public function destroy($id)
    {
        $catalog = Catalog::with('products:id,catalog_id')->find($id); 

        if($catalog == null)
            return null;

        foreach($catalog->products as $product)
        {
            app()->call('App\Http\Controllers\ProductController@destroy', ['id' => $product->id]);
        }

        delete_picture($catalog->preview_path, $catalog->preview_name);

        $catalog->delete();
    }
    //DELETE STORE
    public function deleteStore()
    {
        $catalogs_ids = Catalog::pluck('id');


   
        foreach($catalogs_ids as $cid)
        {
            $this->destroy($cid);
        } 
    }
}
