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

        //ログインしてなかったらログイン画面に遷移
        if(!auth()->user()){
            return redirect()->route('login');
        }

        $inputs = request()->validate([
            'title'=>'required|max:255',
            'body'=>'required|max:1000',
        ]);

        $post = new Post();
        $post->title = $inputs['title'];
        $post->body = $inputs['body'];
        $post->user_id = auth()->user()->id;

        if (request('image')){
            $originalName = request()->file('image')->getClientOriginalName();
             //画像名に日時追加して上書きされないようにする
            $imageName = date('Ymd_His').'_'.$originalName;
            request()->file('image')->move('storage/images', $imageName);
            $post->image = $imageName;
        }

        $post->save();
        return redirect()->route('post.create')->with('message', '投稿を作成しました');
    }

    //投稿一覧画面
    public function index() {
        $posts = Post::latest()->paginate(10);
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
            //コメントも削除
            $post->comments()->delete();
            $post->delete();
            $request->session()->flash('message', '削除しました');
        }
        return redirect()->route('post.index');
    }

    //自分の投稿一覧
    public function mypost() {
        $user = auth()->user();
        $user_id = $user->id;
        $posts = Post::where('user_id', $user_id)->latest()->paginate(10);
        return view('post.mypost', compact('posts', 'user'));
    }
}
