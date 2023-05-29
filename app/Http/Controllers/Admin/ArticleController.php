<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::has('comments', 'category', 'user')->paginate(15);

        return view('admin.article.index', [
            'articles' =>$articles,
        ]);
    }
    public function unapprovedArticles()
    {
        $articles = Article::where('approved', false)->paginate(15);

        return view('admin.article.index', [
            'articles' =>$articles,
        ]);
    }
    public function approveArticle(Article $article)
    {
        $article->approved = true;

        $article->save();

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.category.edite');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
