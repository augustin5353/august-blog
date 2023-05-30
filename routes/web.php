<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Models\Article;
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
    return to_route('articles.index');
});

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-zA-Z\-]+';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('articles', ArticleController::class)->except('show', 'store', 'edit');
Route::post('articles',[ ArticleController::class, 'store'])->middleware('auth')->name('articles.store');

Route::get('/articles/{slug}-{article}', [App\Http\Controllers\ArticleController::class, 'show'])->name('article.show')->where([
    'article' => $idRegex,
    'slug' => $slugRegex
]);

Route::get('/articles/search', [App\Http\Controllers\ArticleController::class, 'search'])->name('search');
Route::get('/articles/{user}/my_articles', [App\Http\Controllers\ArticleController::class, 'userArticles'])->name('user.articles');
Route::get('/articles/{slug}-{article}/edit', [App\Http\Controllers\ArticleController::class, 'edit'])->name('article.edit')->where([
    'article' => $idRegex,
    'slug' => $slugRegex
])->middleware('auth');

Route::get('articles/{slug}/{category}', [App\Http\Controllers\ArticleController::class, 'returnArticlesCategory'])->name('article.by.category')->where([
    'category' => $idRegex,
    'slug' => $slugRegex
]);

Route::get('article/categories{slug}', [App\Http\Controllers\ArticleController::class, 'getCategories'])->name('article.all.categories')->where([
    'slug' => $slugRegex
]);
Route::get('article/sport', [App\Http\Controllers\ArticleController::class, 'sportArticles'])->name('article.sport');
Route::get('article/economie', [App\Http\Controllers\ArticleController::class, 'economieArticles'])->name('article.economie');
Route::get('article/categories{slug}', [App\Http\Controllers\ArticleController::class, 'getCategories'])->name('article.all.categories')->where([
    'slug' => $slugRegex
]);

Route::resource('comment', CommentController::class)->except('store');
Route::post('/articles/comment/{article}', [App\Http\Controllers\CommentController::class, 'store'])->middleware('auth')->name('comment.store');


Route::prefix('admin')->name('admin.')->group(function() {

    Route::resource('category', CategoryController::class)->except('show')->middleware('auth');
    Route::resource('tag', TagController::class)->except('show')->middleware('auth');

    Route::resource('user', UserController::class)->except('show', 'edit', 'create')->middleware('auth');

    Route::get('articles/unapproved', [\App\Http\Controllers\Admin\ArticleController::class, 'unapprovedArticles'])->middleware('auth')->name('articles.unapproved')->can('unapprovedArticles', Article::class);
    
    Route::get('articles/approved', [\App\Http\Controllers\Admin\ArticleController::class, 'approvedArticles'])->middleware('auth')->name('articles.approved')->can('approvedArticles', Article::class);

    Route::get('articles/{article}/approve', [\App\Http\Controllers\Admin\ArticleController::class, 'approveArticle'])->middleware('auth')->name('article.approve')->can('approveArticle', Article::class);

});





Route::get('/resize-show-image{user}', [ProfileController::class, 'resizeShowImage'])->name('resizeShowImage');
Route::get('/resize-index-image{article}', [ArticleController::class, 'resizeIndexImage'])->name('resizeIndexImage');

require __DIR__.'/auth.php';