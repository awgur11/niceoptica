<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Page;
use App\Models\Picture;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \App\Http\Requests\UpdatePageRequest;
use \App\Http\Requests\StorePageRequest;
use \App\Http\Services\PictureService;
use \App\Http\Services\TreeService;
   

class PageController extends Controller
{
    public function index($type, Request $request)
    {

        $pages = Page::with('language:page_id,title,language')
            ->where('type', $type)
            ->select('id', 'preview_path', 'preview_name', 'position', 'public', 'category_id', 'created_at', 'type', 'menu')
            ->orderBy('position')
            ->paginate(20);

        return view('admin.'.$type.'.pages', [
            'pages' => $pages, 
            'type' => $type,
        ]);
    } 
    public function index_tree($type)
    {
        $tree = TreeService::call('Page', 'pages', 'pages')->html();

        return view('admin.'.$type.'.pages_tree', [
            'tree' => $tree,
            'type' => $type
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    { 
        $pictures = Picture::with('languages')
            ->wherePage_id(0)
            ->whereProduct_id(0)
            ->whereAdvert_id(0)
            ->whereUser_id(auth()->id())
            ->orderBy('position')
            ->get();

        $categories = Item::where('type', 'categories')->orderBy('position')->get();

        return view('admin.'.$type.'.create', [
            'type' => $type,
            'pictures' => $pictures,
            'categories' => $categories
        ]);
    } 
    public function store(StorePageRequest $request, $type)
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

        $all['type'] = $type;

        $page = Page::create($all);

        Picture::where('page_id', 0)
            ->where('product_id', 0)
            ->where('advert_id', 0)
            ->where('user_id', auth()->id())
            ->update([
                'page_id' => $page->id
            ]);

        $page->languages()->createMany($all['languages']);

        $page->update(['position' => $page->id]);

        if($save_picture->errors != [])
            return back()->with('my_errors', $save_picture->getErrors());

        return back()->with('message', 'Saved');
    }
    public function edit($id)
    {
        $page = Page::with(['languages', 'pictures'])->find($id);

        $categories = Item::where('type', 'categories')->orderBy('position')->get();

        return view('admin.'.$page->type.'.edit', [
           'page' => $page,
           'categories' => $categories
        ]);
    }
    public function update(UpdatePageRequest $request, $id)
    {
        $page = Page::find($id);

        Picture::where('page_id', 0)
            ->where('product_id', 0)
            ->where('advert_id', 0)
            ->where('user_id', auth()->id())
            ->update([
                'page_id' => $page->id
            ]);

        if($page == null)
            return back()->with('error', __('The page does not exist or has been deleted'));

        $save_picture = PictureService::call()
            ->addRequest($request)
            ->savePicture()
            ->resize(['fhd', 'one', 'tree', 'five', 'mini']);

        $request = $save_picture->getRequest();

        $all = $request->all();

        if($page->language->title != $all['languages'][0]['title'])
            $all['alt_title'] = alt_title($all['languages'][0]['title']);

        //Delete picture without adding new one
        $page->update($all);

        foreach($all['languages'] as $lang)
        {
            if($page->languages()->where('language', $lang['language'])->first() != null)
                $page->languages()->where('language', $lang['language'])->update($lang);
            else
                $page->languages()->create($lang);
        }
        if($save_picture->errors != [])
            return back()->with('my_errors', $save_picture->getErrors());

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
        $page = Page::find($id); 

        delete_picture($page->preview_path, $page->preview_name);

        $page->delete();

        return ''; 
    }
}
