@extends('base')

@section('content')
    <div>
      <div class=" pb-5">
        <span>{{ $article->title }}</span>
      </div>
      <div class="">
        <img src="{{ $article->getImagePath() }}" alt="{{ substr($article->title, 0, 20)}}" class="show-article-image" style="width: 70%">
      </div>
      <div class=" pt-5">
        <p>{{ $article->content }}</p>
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
      <div>
        @forelse ($article->comments as $comment)
            <p>{{ $comment->content }}</p>
        @empty
            
        @endforelse
      </div>
    </div>
@endsection