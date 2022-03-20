<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Http\Services\PictureService;
use App\Http\Services\ContentService;

class AdminController extends Controller
{
    public function sorting(Request $request)
    {
        $ids = $request->ids;
        
        $model = '\App\Models\\'.$request->model;

        $min_id = collect($ids)->min();

//        dd($min_id);

        foreach($ids as $k => $id)
        {
            $model::where('id', $id)->update([
                'position' => $min_id + $k
            ]);
        }
    }

    public function index()
    {
 /*       $fvalues = \App\Models\Fvalue::select('id', 'alt_title')->where('filter_id', 63)->get()->sortBy('alt_title')->values();

        foreach($fvalues as $k => $f)
        {

            \App\Models\Fvalue::where('id', $f->id)->update([
                'position' => $k]);
        }
        */

        return view('admin.index', [
            'unchecked_comments_count' => \App\Models\Comment::where('status', 0)->count(),
        ]);
    }

    public function transfer_pictures(Request $request)
    {
        $id = $request->id;
        $column = $request->column;
        $class =  '\App\Models\\'.$request->class;

        $obj = $class::with('languages')->find($id);

        foreach ($obj->languages as $lang) {
            $content = $lang->{$column};



            $content = ContentService::factory()->uploadPictures($content)->content;


            $obj->languages()->where('language', $lang->language)->update([
                $column => $content
            ]);
        }

    }

    public function change_cell(Request $request)
    {
        $id = $request->input('id'); //id element
        $key = $request->input('key', NULL);
        $table = $request->input('table'); // table mane where elements ordering
        $column = $request->input('column'); //column
        $value = $request->input('value');

        if($table == 'users' && Auth::id() != $id)
        {

        }
        else
        {
            if($column == 'price')
            {
                $product = Product::select('id', 'discount', 'nacenka', 'price', 'final_price')->find($id);

                $final_price = round((1-$product->discount/100)*(1+$product->nacenka/100)*$value);

                $product->update([
                    'price' => $value,
                    'final_price' => round((1-$product->discount/100)*(1+$product->nacenka/100)*$value),
                ]);
                return $final_price;
            }
            else
            {
                if($key != NULL)
                    \DB::table($table)->where('key', $key)->update([$column => $value]);
                elseif($id != NULL)
                    \DB::table($table)->where('id', $id)->update([$column => $value]);
            }
        }     
    }

    public function change_pivot(Request $request)
    {
        $checked = filter_var($request->checked, FILTER_VALIDATE_BOOLEAN);
        $table = $request->table;

        $col_val_arr = [];



        $i = 1;
        while ($request->{'col'.$i} != null) {
                 
            if($request->{'val'.$i} == 0)
                return NULL;

            if($checked)
                $col_val_arr[$request->{'col'.$i}] = $request->{'val'.$i};
            else
                $col_val_arr[] = [$request->{'col'.$i}, '=', $request->{'val'.$i}];
            $i++;

        }

        if($checked)
            \DB::table($table)->insert($col_val_arr);
        else
            \DB::table($table)->where($col_val_arr)->delete();
    }

    public function password_update(Request $request)
    {
        $error = null;

        if(auth()->id() == $request->user_id)
        {
            $user = User::find($request->user_id);
            if(Hash::check($request->old_password, $request->user()->password))
            {
                if($request->new_password == $request->repeat_password)
                {
                    $user->update(['password' => Hash::make($request->new_password)]);

                    return json_encode([
                        'success' => true,
                        'data' => [
                            'text' => 'Пароль успешно обновлён'
                        ]
                    ]);
                }
                else
                {
                    $error = 'Вы неправельно ввели пароль повторно';
                }
            }
            else
            {
                $error = 'Вы ввели неправельно свой старый пароль';
            }
        }
        else
        {
            $error = 'Вы не Вы';
        }
        if($error != null)
        {
            return json_encode([
                'success' => false,
                'data' => [
                    'text' => $error
                ]
            ]);

        }
    }
}
