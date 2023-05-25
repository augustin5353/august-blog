@extends('base')

@section('content')
    @forelse ($articles as $article)
        @if ($article->image_path !== null)
            
                <div class="polaroid">
                    <a href="{{ route('article.show', ['slug' => $article->getSlug(), 'article' => $article->id]) }}">
                    <div class=" p-1 ">   
                        <p class="article-title-index">{{ $article->title }}</p>
                    </div>
                    <div class="">
                        <img src="{{ $article->getImagePath() }}" alt="{{ $article->title }}" class="index-image" >
                        <div class="container">
                            <p>{{ substr($article->content, 0, 35) }}...</p>
                        </div>
                    </div>
                </a>
                </div>
            
        @else
            <p>{{ $article->title }}</p>
        @endif
    @empty
    @endforelse
@endsection
