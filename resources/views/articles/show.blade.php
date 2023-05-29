@extends('base')

@section('content')
    <div class="container justify-between align-content-center align-items-center ">
        <div class=" pb-5 " >
          <span class="show-title-article text-justify">{{ $article->title }}</span>
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
              @forelse ($article->comments as $comment)
            <div class="  d-flex  align-content-center justify-items-center">
              @if ($comment->user->image !== null)
                <div class="avartar">
                  <img src="{{ $comment->user->getImagePath() }}" alt="{{ $comment->user->name }}" class="avartar-image">
                </div>
              @endif
                  <p>{{ $comment->user->name }} </p>
            </div>
            <p>{{ $comment->content}}
              @can('update', $comment)
                  <div class="d-flex justify-start align-content-center align-items-center mt-0">
                <a href="{{ route('comment.edit', ['comment' => $comment])}} " class=" mr-3">Modifier</a>
                <form action="{{ route('comment.destroy',[ 'comment' => $comment]) }}" method="post" enctype="multipart/form-data">
                  @csrf
                  @method('delete')
                  <button class=" btn btn-danger btn-sm">Supprimer</button>
                </form>
              </div>
              @endcan
            </p>
            @empty
                    
            @endforelse
        </div>
    </div>
@endsection