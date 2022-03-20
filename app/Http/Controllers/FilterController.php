<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filter;
use App\Models\Fvalue;
use App\Models\Catalog;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = Filter::orderBy('position')->paginate(30);

        return view('admin.filters.filters', ['filters' => $filters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $parser = null)
    {
        $all = $request->all();

        $title = $all['languages'][0]['title'];

        $all['alt_title'] = alt_title($title);

        $filter = Filter::create($all);

        $filter->languages()->createMany($all['languages']);

        $filter->update(['position' => $filter->id]);

        if($parser == null)
            return back()->with('message', 'Saved');
        else
            return $filter->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $filter = Filter::with('languages')->find($id);

        if($filter != null)
            $filter = $filter->toArray();

        return $filter;
    }
    public function update(Request $request, $id)
    {
        $filter = Filter::with('languages')->find($id);

        $all = $request->all();

        if($filter->language->title != $all['languages'][0]['title'])
        {
            $title = $all['languages'][0]['title'];

            $all['alt_title'] = alt_title($title);
        }
        $filter->update($all);

        foreach($all['languages'] as $lang)
        {
            if($filter->languages->where('language', $lang['language'])->first() != null)
                $filter->languages()->where('language', $lang['language'])->update($lang);
            else
                $filter->languages()->create($lang);
        }
        return back()->with('message', __('Saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filter = Filter::find($id);

        $filter->catalogs()->detach();

        foreach($filter->fvalues as $fvalue)
        {
            $fvalue->products()->detach();
        }
        $fvalues_ids = $filter->fvalues()->pluck('id')->all();

        foreach($fvalues_ids as $fid)
        {
            Fvalue::find($fid)->products()->detach();
            Fvalue::find($fid)->catalogs()->detach();
        }
        $filter->fvalues()->delete();

        $filter->delete();

        return response(null, 204);       
    }

    
}
