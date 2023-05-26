@extends('base')

@section('content')
    <div class="container justify-between align-content-center align-items-center ">
        <div class=" pb-5 " >
          <span class="index-article-title show-title-article text-justify">{{ $article->title }}</span>
        </div>

        <div class="">
          <img src="{{ $article->getImagePath() }}" alt="{{ substr($article->title, 0, 20)}}" class="show-article-image" >
        </div>

        <div class=" pt-5">
          <p class="article-content text-justify">{{ $article->content }}</p>
        </div>

        <span>
          @forelse ($article->tags as $tag)
              {{ $tag->name }}
          @empty
              
          @endforelse
        </span>

        <div class=" d-flex justify-between  align-content-between align-items-center">
          <p><span class="article-author">Autheur:</span><span class="article-author-name">{{ $article->user->name }}</span></p>

          <p><span class="show-day">{{ $article->getDate() }}</span></p>
        </div>
        

        <div>
            <form action="{{ route('comment.store', ['article' => $article]) }}" method="post" enctype="multipart/form-data">

              @csrf
              @method('post')
            
              <div class="row justify-between align-content-between align-items-center">
                <x-articles.input name="content" holder="commentaire" type="textarea" value="" label="Commenter" class=" col-9"/>
            
                <div class="text-end col-3">
                    <x-primary-button class=" ">Commenter</x-primary-button>
                </div>
              </div>
            
            </form>
        </div>

        <div class=" mb-5">
            @forelse ($article->comments as $comment)
                <p>{{ $comment->content }}</p>
            @empty
                
            @endforelse
        </div>
    </div>
@endsection