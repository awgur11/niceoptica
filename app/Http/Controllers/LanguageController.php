<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;

class LanguageController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scan($dir)
    {
        $result = [];
        $dir_arr = scandir($dir);

        unset($dir_arr[0]);
        unset($dir_arr[1]);
        foreach($dir_arr as $dr)
        {
            if(is_file($dir.'/'.$dr))
                $result[] = $dir.'/'.$dr;
            else
            {
                $result = array_merge($result, $this->scan($dir.'/'.$dr));
            }
        }
        return $result;
    }
    public function get_text($file_path)
    {
        $str = file_get_contents($file_path);

        $str_arr = explode('@lang', $str);
        unset($str_arr[0]);

        foreach($str_arr as $k => $v)
        {
            $v = str_replace(['(\'', '("'], '', $v);
            $pos = strpos($v, ')');
            $v = substr($v, 0, $pos);
            $v = str_replace(['\'', '"'], '', $v);
            $str_arr[$k] = $v;
        }


        return $str_arr;
    }
//создание базового языкоового файла json на английском языке
    public function create_en_json()
    {
        $root = base_path();

        $views_arr = $this->scan($root.'\resources\views');

        $words = [];

        foreach($views_arr as $view){
            $words = array_merge($words, $this->get_text($view));
        }
        $final = [];
        $words = array_unique($words);

        foreach($words as $v)
        {
            $final[$v] = $v;
        }
        $final = json_encode($final);
        $final = str_replace(',', ',<br/>', $final);

        echo $final;

    }
    public function index()
    {
        $languages = Language::orderBy('position')->get();

        return view('admin.languages.languages', ['languages' => $languages]);     
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
        $request->validate([
            'title' => 'bail|required|max:255',
            'shot' => 'bail|required|max:3',
            'locale' => 'bail|required|max:2',
        ]);

        $all = $request->all();

        $language = Language::create($all);

        $language->update(['position' => $language->id]);

        return back()->with('message', 'Saved');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'bail|required|max:255',
            'shot' => 'bail|required|max:3',
            'locale' => 'bail|required|max:2',
        ]);

        $language = Language::find($id);

        if($language == null)
            return back()->with('error', 'Some arror arised');

        $all = $request->all();

        $language->update($all);

        return back()->with('message', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $language = Language::find($id);

        if($language != null)
            $language->delete();
    }
}
