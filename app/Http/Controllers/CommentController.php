<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
   //コメントの保存
   public function store(Request $request) {

        $inputs=request()->validate([
            'body'=>'required|max:1000',
        ]);

        $comment=new Comment();
        $comment->body=$inputs['body'];
        $comment->user_id=auth()->user()->id;
        $comment->post_id=$request->post_id;

        $comment->save();

        return back();
    }
}
