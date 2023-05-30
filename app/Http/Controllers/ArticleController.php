<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use Nette\Utils\Random;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use App\Http\Requests\ArticleRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PostArticleNotification;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\Translation\Util\ArrayConverter;

class ArticleController extends Controller
{
  
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $firstArticlesByCategory = [];
        

        foreach(Category::all() as $category)
        {
            if($category->articles()->first() !== null)
            {
               $firstArticlesByCategory[] =  $category->articles()->first();
            }    
        }

        /* Article le plus populaire ces derniers 7 jours  */
        $popular_article  = Article::withCount('comments')->whereDate('created_at', '>', Carbon::now()->subDays(7))
            ->orderBy('comments_count', 'desc')
            ->first();

        /* tous les articles en generant en meme temps leurs commentaires et auteur et catégorie */
        $articles = Article::has('comments', 'category', 'user')->paginate(15);

        $sport_articles  = Article::withCount('comments')->whereDate('created_at', '>', Carbon::now()->subDays(7))
            ->orderBy('comments_count', 'desc')->where('id', '!=', $popular_article->id)->limit(4)->get();

        

        return view('articles.index', [
            'popular_article' => $popular_article,
            'articles' =>$articles,
            'sport_articles' => $sport_articles,
            'firstArticlesByCategory' => $firstArticlesByCategory
        ]);
    }

    public function sportArticles()
    {
        $articles = Article::whereHas('category', function ($queryBuilder) {
            $queryBuilder->where('designation', "Sport");
        })->get();

        return view('articles.sport', [
            'articles' => $articles
        ]);
    }
    public function economieArticles()
    {
        $articles = Article::whereHas('category', function ($queryBuilder) {
            $queryBuilder->where('designation', "Economie");
        })->get();

        return view('articles.economie', [
            'articles' => $articles
        ]);
    }

    public function userArticles()
    {
        $articles = Article::where('user_id', Auth::id());

        return view('articles.user_articles', [
            'articles' => $articles->paginate(12)
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

        $tags = json_decode($request->input('tags'), true);

        $tagIds = [];

        $data = [
            'title' => $request->validated('title'),
            'content' => $request->validated('content'),
        ];

        $article = Article::create($data);

        $article->user()->associate(Auth::id());

        $article->category()->associate($request->validated('category'));


        if($request->validated('tags') !== null)
        {
            foreach ($tags as $tag)
                {
                    // Vérifier si le tag existe déjà dans la base de données
                    $existingTag = Tag::where('name', $tag)->first();
            
                    if ($existingTag) {
                        // Si le tag existe, ajouter son ID au tableau des IDs
                        $tagIds[] = $existingTag->id;
                    } else {
                        // Si le tag n'existe pas, créer un nouveau tag
                        $newTag = new Tag();
                        $newTag->name = $tag;
                        $newTag->save();
            
                        // Ajouter l'ID du nouveau tag au tableau des IDs
                        $tagIds[] = $newTag->id;
                    }
                }

            $article->tags()->sync($tagIds);
        }
        
    
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

            $article->save();

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
        //$image = Image::make(substr($article->getImagePath(), 1));

        $expertiseSlug = $article->getSlug();

        $popular_articles  = Article::withCount('comments')->whereDate('created_at', '>', Carbon::now()->subDays(7))
            ->orderBy('comments_count', 'desc')
            ->where('id', '!=', $article->id)
            ->limit(5)
            ->get();

        $comments = $article->comments()->paginate(3);

        $articles_same_category = Article::where('category_id', $article->category->id)
            ->limit(12)
            ->get();


        if ($slug !== $expertiseSlug) {
            return to_route('property.show', [
                'slug' => $expertiseSlug,
                 'article' => $article,
                 'popular_articles' => $popular_articles,
                 'comments' => $comments,
                 'articles_same_category' =>$articles_same_category
            ]);
        
        }

        return view('articles.show', [
            'article' => $article,
            'popular_articles' => $popular_articles,
            'comments' => $comments,
            'articles_same_category' => $articles_same_category
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


        $tags = json_decode($request->input('tags'), true);

        $tagIds = [];

        $article->category()->associate($request->validated('category'));


        if($request->validated('tags') !== null)
        {
            foreach ($tags as $tag)
                {
                    // Vérifier si le tag existe déjà dans la base de données
                    $existingTag = Tag::where('name', $tag)->first();
            
                    if ($existingTag) {
                        // Si le tag existe, ajouter son ID au tableau des IDs
                        $tagIds[] = $existingTag->id;
                    } else {
                        // Si le tag n'existe pas, créer un nouveau tag
                        $newTag = new Tag();
                        $newTag->name = $tag;
                        $newTag->save();
            
                        // Ajouter l'ID du nouveau tag au tableau des IDs
                        $tagIds[] = $newTag->id;
                    }
                }

            $article->tags()->toggle($tagIds);
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

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Effectuez la recherche d'articles en fonction du terme de recherche
        $query = $request->input('query');

        $articles = Article::whereHas('tags', function($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'LIKE', "%$query%");
        })->get();
                
        return view('articles.search_results', [
            'articles' => $articles
        ]);
    }

    public function returnArticlesCategory(string $slug, Category $category)
    {

        $articles = Article::whereHas('category', function ( $query) use ($category) {
            $query->where('id', $category->id);
        })->get();
        
        return view('articles.per_category', [
            'articles' => $articles
        ]);
    }

    public function getCategories()
    {
        $categories = Category::all();
        $popular_articles = Article::withCount('comments')->whereDate('created_at', '>', Carbon::now()->subDays(7))
            ->orderBy('comments_count', 'desc')->get();

        return view('articles.all_categories', [
            'categories' => $categories,
            'popular_articles' => $popular_articles
        ]);
    }

}