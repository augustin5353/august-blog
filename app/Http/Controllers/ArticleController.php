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
use Illuminate\Support\Carbon;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        

        /* Article le plus populaire ces derniers 7 jours  */
        $popular_article  = Article::withCount('comments')->whereDate('created_at', '>', Carbon::now()->subDays(7))
            ->orderBy('comments_count', 'desc')
            ->first();

        /* tous les articles en generant en meme temps leurs commentaires et auteur et catégorie */
        $articles = Article::has('comments', 'category', 'user')->get();

        return view('articles.index', [
            'popular_article' => $popular_article,
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
        

        if($request->hasFile('image'))
        {

            //get filename with extension
            $filenameWithExtension = $request->file('image')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            //get the extension
            $extension = $request->file('image')->getClientOriginalExtension();

            //filename to store
            $filenameStore = $filename. '_'.time().'.'.$extension;

            //upload file
            $request->file('image')->storeAs('public/article_images/'.$article->id, $filenameStore);

            $article->image_path = 'article_images/'.$article->id.'/'. $filenameStore;

        }

        if($request->validated('tags') !== null)
        {
          //  $article->tags()->syncWithoutDetaching($request->validated('tags'));
        }

        //creation des tags

        $tagsNames = json_decode($request->input('tags'), true);

        $allTags = Tag::all();

        $articleTags = [];


        $tagggs = [];

        foreach($allTags as $tag)
        {
           

        dd($tagggs);
        $article->tags()->toggle($articleTags);

        
        $article->save();

        dd($article->$tags()->get());

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
        //$image = Image::make(substr($article->getImagePath(), 1));

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
        
        if($request->hasFile('image'))
        {
            //supprimer l'ancienne image
            if($article->image_path !== null){
                Storage::delete($article->getImagePath());
            }

            //get filename with extension
            $filenameWithExtension = $request->file('image')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            //get the extension
            $extension = $request->file('image')->getClientOriginalExtension();

            //filename to store
            $filenameStore = $filename. '_'.time().'.'.$extension;

            //upload file
            $request->file('image')->storeAs('public/article_images/'.$article->id, $filenameStore);

            $article->image_path = 'article_images/'.$article->id.'/'. $filenameStore;

           /*  $request->file('image')->storeAs('public/article_images/thumbnail'.$article->id, $filenameStore);

            //resize image here
            $thumbnailpath = public_path('storage/article_images/thumbnail/'.$article->id . $filenameStore);

            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
                
            });

            $img->save($thumbnailpath); */
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

    public function resizeShowImage(Article $article)
    {
        $imagePath = substr($article->getImagePath(), 1); // Obtenez le chemin de l'image depuis la base de données

        $image = Image::make($imagePath);
        
        $image->resize(null, 350, function ($constraint) {
            $constraint->aspectRatio();
        });
        // Redimensionnez l'image selon vos besoins
    
        // Renvoyer la réponse HTTP avec l'image modifiée
        return response($image->encode('jpg'), 200)->header('Content-Type', 'image/jpeg');
    }


    public function resizeIndexImage(Article $article)
    {
        $imagePath = substr($article->getImagePath(), 1); // Obtenez le chemin de l'image depuis la base de données

        $image = Image::make($imagePath);
        
        if($image->width() > 350)
        {
            $image->resize(350, 350, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        else
        {
            $image->resize(350, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        
        
        // Redimensionnez l'image selon vos besoins
    
        // Renvoyer la réponse HTTP avec l'image modifiée
        return response($image->encode('jpg'), 200)->header('Content-Type', 'image/jpeg');
    }
}
