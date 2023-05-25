<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use Nette\Utils\Random;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use App\Http\Requests\ArticleRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PostArticleNotification;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $articles = Article::has('comments', 'category', 'user')->get();

        return view('articles.index', [
            'articles' =>$articles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.edit', [
            'article' => new Article(),
            'categories' => Category::pluck('designation', 'id'),
            'tags' => Tag::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $data = [
            'title' => $request->validated('title'),
            'content' => $request->validated('content'),
        ];

        $article = Article::create($data);

        $article->user()->associate(Auth::id());

        $article->category()->associate($request->validated('category'));
        

        if($request->validated('image') !== null)
        {
            $path = $request->file('image')->store(
                'image/'.$article->id, 'public'
            );
            
            $article->image_path = $path;

            $article->save();
        }
        if($request->validated('tags') !== null)
        {
            $article->tags()->syncWithoutDetaching($request->validated('tags'));
        }

        $users = User::all();

        foreach($users as $user)
        {
            $user->notify(new PostArticleNotification($user, $article));
        }
             
        return to_route('articles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug, Article $article)
    {

        $expertiseSlug = $article->getSlug();


        if ($slug !== $expertiseSlug) {
            return to_route('property.show', [
                'slug' => $expertiseSlug,
                 'article' => $article,
            ]);
        
        }

        return view('articles.show', [
            'article' => $article
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug, Article $article)
    {
        return view('articles.edit', [
            'article' => $article,
            'categories' => Category::pluck('designation', 'id'),
            'tags' => Tag::pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {


        $article->user()->associate(Auth::id());

        $article->category()->associate($request->validated('category'));

        if($request->validated('tags') !== null)
        {
            $article->tags()->syncWithoutDetaching($request->validated('tags'));
        }
        

        if($request->validated('image') !== null)
        {
            $path = $request->file('image')->store(
                'image/'.$article->id, 'public'
            );
            
            $article->image_path = $path;

            $article->save();
        }

        $data = [
            'title' => $request->validated('title'),
            'content' => $request->validated('content'),
        ];

        $article->update($data);

        return to_route('article.show', [
            'article' => $article,
            'slug' => $article->getSlug()
        ])->with('success', 'Article modifier avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if($article->image_path !== null)
        {
            Storage::delete($article->image_path);
        }
        

        $article->delete();

        return back();
    }
}
