@extends('base')




@section('content')

<div class="row   justify-between align-content-center align-items-center">
    <div class="col-7">
      <div class="container justify-between align-content-center align-items-center ">
        <div class=" pb-5 " >
          <span class="show-title-article">{{ $article->title }}</span>
        </div>

        <div class="">
          <img src="{{ $article->getImagePath() }}" alt="{{ substr($article->title, 0, 20)}}" class="show-article-image">
        </div>

        <div class=" pt-5">
          <p class="article-content-total text-justify">{{ $article->content }}</p>
        </div>

        <div class=" d-flex justify-between  align-content-between align-items-center">
        <p><span class="article-author">Autheur:</span><span class="article-author-name">{{ $article->user->name }}</span></p>

          <p><span class="show-day">{{ $article->getDate() }}</span></p>
        </div>
        

        <div>
            <form action="{{ route('comment.store', ['article' => $article]) }}" method="post" enctype="multipart/form-data">

              @csrf
              @method('post')
            
              <div class="row justify-between align-content-between align-items-center">
                <x-articles.input name="content" holder="commentaire" type="textarea" value="" label=" " class=" col-9"/>
            
                <div class="text-end col-3">
                    <x-primary-button class=" ">Commenter</x-primary-button>
                </div>
              </div>
            
            </form>
        </div>

        <div class="mt-5">
              @forelse ($comments as $comment)
                <div class="  d-flex  align-content-center justify-items-center">
                  @if ($comment->user->image !== null)
                    <div class="avartar mr-2">
                      <img src="{{ $comment->user->getImagePath() }}" alt="{{ $comment->user->name }}" class="avartar-image">
                    </div>
                  @endif
                      <p class="article-author-name">{{ $comment->user->name }} </p>
                </div>
                <p class="comment-content">{{ $comment->content}}
                  @can('update', $comment)
                  <div class="d-flex justify-start align-content-center align-items-center mt-0">
                    <a href="{{ route('comment.edit', ['comment' => $comment])}} " class=" mr-3 ">Modifier</a>
                    <form action="{{ route('comment.destroy',[ 'comment' => $comment]) }}" method="post" enctype="multipart/form-data">
                      @csrf
                      @method('delete')
                      <button class=" btn  btn-danger btn-sm">Supprimer</button>
                    </form>
                  </div>
                  @endcan
                </p>
                @empty
                    
            @endforelse

            <div>{{ $comments->links() }}</div>
        </div>
    </div>
    </div>

    <div class="col mb-5">
      @forelse ($popular_articles as $article)
        <a href="{{ route('article.show', ['article' => $article, 'slug' => $article->getSlug()]) }}">
          <div class="d-flex   align-items-start popular-article-div">
            <img src="{{ $article->getImagePath() }}" alt="{{ $article->title }}" class="image-size">
            <div class="d-flex flex-column  position-relative mr-3 mt-2">
              @if ($article->category !== null)
                <p class="popular-articles-category">{{ $article->category->designation }}</p>
              @endif
              
              <p class="title  popular-article-title">{!! substr($article->title, 0, 55) !!}...</p>
            </div>
          </div>
        </a>
      @empty
          
      @endforelse
      
    </div>
  </div>

  <div class="row">
    <p class="read-more-text ml-4">Lire aussi</p>
    @forelse ($articles_same_category as $article)
        <div class="col-sm-4 ">
            <div class="polaroid">
                <a href="{{ route('article.show', ['slug' => $article->getSlug(), 'article' => $article->id]) }}">
                    <div class="container">
                        <div class="index-image-container">
                            <img src="{{ $article->getImagePath() }}" alt="{{ substr($article->title, 0, 30) }}" class="index-image">
                        </div>
                        <p class="article-content-index"> {{ substr($article->content, 0, 100) }}...</p>
                        <span class="text-end">{{$article->getDate()}}</span>
                        
                    </div>
                </a>
            </div>
        </div>
    @empty
    <div>
        Aucun article non Approuvé
    </div>
    @endforelse
    
</div>
    
@endsection

