<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    //投稿作成
    public function create() {
        return view('post.create');
    }

    //投稿の保存
    public function store(Request $request) {

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
        $posts = Post::with('user')->get();
        return view('post.index', compact('posts'));
    }

    //投稿個別表示
    public function show(Post $post) {
        return view('post.show', compact('post'));
    }

    //投稿の編集
    public function edit(Post $post) {
        return view('post.edit', compact('post'));
    }

    //投稿の更新
    public function update(Request $request, Post $post) {
        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
        ]);

        $validated['user_id'] = auth()->id();

        if($post['user_id'] == auth()->id()){
            $post->update($validated);
            $request->session()->flash('message', '更新しました');
        }
        return back();
    }

    //投稿の削除
    public function destroy(Request $request, Post $post) {
        if($post['user_id'] == auth()->id()){
            $post->delete();
            $request->session()->flash('message', '削除しました');
        }
        return redirect()->route('post.index');
    }
}
