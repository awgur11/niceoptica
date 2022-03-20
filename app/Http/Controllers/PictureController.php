<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Picture;
use App\Http\Services\PictureService;


class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
    }
    //SAVING PICTURE BY AJAX AND RETURNING PITURE'S URI
    public function upload_picture_ajax(Request $request)
    {
 
        $save_picture = PictureService::call()
            ->addRequest($request)
            ->savePicture()
            ->resize(['fhd', 'one', 'two', 'tree', 'four', 'five', 'mini']);


        $request = $save_picture->getRequest();
 
        $all = $request->all();

        $all['user_id'] = auth()->id();
 
        $picture = Picture::create($all);

        return $picture->toJson(); 
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
    public function store(Request $request)
    {
        //
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
        $picture = Picture::with('languages')->find($id);

        if($picture  != null)
            $picture  = $picture->toArray();

        return $picture;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        $all = $request->all();
     
        $picture = Picture::find($all['id']);

        $picture->update($all);

        if(isset($all['languages']))
        {
            foreach($all['languages'] as $al)
            {
                if($picture->languages()->where('language', $al['language'])->first() != null)
                    $picture->languages()->where('language', $al['language'])->update($al);
                else
                    $picture->languages()->create($al);
            }
        }
        return $all;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rotate(Request $request)
    { 
        return PictureService::call()->addRequest($request)->rotate();
    }
    public function destroy($id)
    {
        $picture = Picture::find($id);

        delete_picture($picture->preview_path, $picture->preview_name);

        $picture->delete();
    }

    public function attach_colour($id, $colour_id)
    {
        $picture = Picture::find($id);

        if($picture != null)
            $picture->update(['colour_id' => $colour_id]);
    }
}
