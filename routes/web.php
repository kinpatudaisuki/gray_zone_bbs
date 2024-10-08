<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//投稿とコメントはメール認証したユーザーのみ使用可能
Route::middleware(['verified'])->group(function(){

    Route::get('/dashboard', function () {
        return view('post/create');
    })->middleware(['auth', 'verified'])->name('dashboard');

    //自分の投稿一覧
    Route::get('post/mypost', [PostController::class, 'mypost'])->name('post.mypost');

    //自分のコメント一覧
    Route::get('post/mycomment', [PostController::class, 'mycomment'])->name('post.mycomment');

    //投稿の作成と保存
    Route::get('post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('post', [PostController::class, 'store'])
    ->name('post.store');

    //投稿一覧表示
    Route::get('post/index', [PostController::class, 'index'])->name('post.index');

    //投稿個別表示
    Route::get('post/show/{post}', [PostController::class, 'show'])->name('post.show');

    //投稿の編集
    Route::get('post/edit/{post}', [PostController::class, 'edit'])->name('post.edit');

    //投稿の更新
    Route::patch('post/{post}', [PostController::class, 'update'])->name('post.update');

    //投稿の削除
    Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');

    //コメントの作成と保存
    Route::post('post/comment/store', [CommentController::class, 'store'])->name('comment.store');

});

//問い合わせの作成と保存
Route::get('contact/create', [ContactController::class, 'create'])->name('contact.create');
Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
