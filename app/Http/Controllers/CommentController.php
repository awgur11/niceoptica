<?php 
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;


class CommentController extends Controller 
{
    public function store(\App\Http\Requests\StoreCommentRequest $request)
    {
        Comment::create($request->all());
    }

    public function unchecked()
    { 
        $comments = Comment::query()
            ->with('page')
            ->latest()
            ->paginate(50);

        return view('admin.comments.unchecked', ['comments' => $comments]);    
    }

    public function checked()
    {
        Comment::where('status', 0)->update(['status' => 1]);

        return back();
    }

    public function status($id)
    {
        Comment::where('id',$id)->orWhere('answer',$id)->update(['status' => 1]);
    }

    public function destroy($id)
    {
        Comment::findOrFail($id)->delete(); 
    }
}
