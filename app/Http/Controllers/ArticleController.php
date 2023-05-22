<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ArticleRequest;
use App\Models\Category;
use App\Models\User;
use Nette\Utils\Random;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $articles = Article::all();
        foreach($articles as $article)
        {
            $article->category()->associate(rand(1, 5));

            $article->save();
        }

        $user = User::find(Auth::id());

        $articles = $user->articles()->paginate(15);

        return view('articles.index', [

            'articles' =>$articles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create', [
            'article' => new Article(),
            'categories' => Category::pluck('designation', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        
        $article = Article::create($request->validated());

        $article->user()->associate(Auth::id());

        return view('articles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
