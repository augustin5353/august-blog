<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
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

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('articles', ArticleController::class)->except('show', 'store');
Route::post('articles',[ ArticleController::class, 'store'])->middleware('auth')->name('articles.store');

Route::get('/articles/{slug}-{article}', [App\Http\Controllers\ArticleController::class, 'show'])->name('article.show')->where([
    'article' => $idRegex,
    'slug' => $slugRegex
]);

Route::resource('comment', CommentController::class)->except('store');
Route::post('/articles/comment/{article}', [App\Http\Controllers\CommentController::class, 'store'])->middleware('auth')->name('comment.store');

Route::resource('admin/category', CategoryController::class)->except('show')->middleware('auth');
Route::resource('admin/tag', TagController::class)->except('show')->middleware('auth');
require __DIR__.'/auth.php';
