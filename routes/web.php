<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store'])->name('users.store');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::resource('pages', PageController::class)->middleware(['auth']);

Route::get('/post', function () {
    return view('post');
});

Route::post('/post', [PostController::class, 'store'])->name('post.store');


Route::get('/plantilla', function () {
    return view('homeplantilla');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/eloquent', function () {
    // $posts = Post::all();
    $posts = Post::where('id', '>=', '20')
        ->orderBy('id', 'desc')
        ->take(3)
        ->get();

    foreach ($posts as $post) {
        echo "$post->id $post->title <br />";
    }
});


Route::get('/eloquent/post', function () {
    $posts = Post::get();

    foreach ($posts as $post) {
        echo "
        $post->id
        Usuario: <strong>{$post->user->name}</strong>
        Titulo: $post->get_title <br />";
    }
});

Route::get('/eloquent/user', function () {
    $users = User::get();

    foreach ($users as $user) {
        echo "
        $user->id
        Nombre: <strong>{$user->get_name}</strong>
        Cantidad de post: {$user->posts->count()} <br />";
    }
});

Route::get('collections', function () {
    $users = User::all();

    // dd($users);
    // dd($users->contains(5));
    // dd($users->except([1, 2, 3]));
    // dd($users->only([4]));
    // dd($users->find(4));
    dd($users->load('posts'));
});


Route::get('serialization', function () {
    $users = User::all();

    // dd($users->toArray());
    $user = $users->find(1);
    // dd($user);
    dd($user->toJson());
});

