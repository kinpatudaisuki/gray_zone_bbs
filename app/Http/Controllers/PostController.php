<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    //投稿作成
    public function create(){
        return view('post.create');
    }

    //投稿の保存
    public function store(Request $request){

        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
        ]);

        $validated['user_id'] = auth()->id();

        $post = Post::create($validated);

        $request->session()->flash('message', '保存しました');
        return back();
    }

    //投稿一覧画面
    public function index() {
        $posts = Post::all();
        return view('post.index', compact('posts'));
    }
}
