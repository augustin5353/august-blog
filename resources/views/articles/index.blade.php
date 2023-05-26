@extends('base')

@section('content')
{{-- Article le plus populaire ces derniers 7 jours --}}

<div class="row mb-5 align-items-center justify-between">
    <div class="col-5">
        <a href="{{ route('article.show', ['article' => $popular_article , 'slug' => $popular_article->getSlug()]) }}">
            <img src="{{$popular_article->getImagePath()}}" alt="{{ substr($popular_article->title, 0, 30) }}" class="popular-article-image w-100 h-100">
        </a>
    </div>
    <div class="col">
        <p class="show-title-article">{{ $popular_article->title }}</p>
        <div class="article-content text-justify">
            <a href="{{ route('article.show', ['article' => $popular_article , 'slug' => $popular_article->getSlug()]) }}" class="popular-article-clique-link">
                <div>
                    @if (strlen($popular_article->content) > 1000)
                        <span class="text-justify">{{ substr($popular_article->content, 0, 1000) }}</span>
                        <span class="hidden-content text-justify">{{ substr($popular_article->content, 1000) }}</span>
                    @else
                        <span class="">{{ $popular_article->content }}</span>
                    @endif
                </div>
            </a>
        </div>

        <button class="read-more-btn text-info font-italic fs-5">Lire plus</button>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const readMoreBtns = document.querySelectorAll('.read-more-btn');
        
                readMoreBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const hiddenContent = this.previousElementSibling.querySelector('.hidden-content');
                        hiddenContent.classList.toggle('show');
                        this.textContent = hiddenContent.classList.contains('show') ? 'Lire moins' : 'Lire plus';
                    });
                });
            });
        </script>
    </div>
</div>



<div class="row">
    @forelse ($articles as $article)
        
        <div class="col-sm-4 pt-5">
            <div class="polaroid">
                <a href="{{ route('article.show', ['slug' => $article->getSlug(), 'article' => $article->id]) }}">
                    <div class="p-1">
                        <p>{{ substr($article->title, 0, 50) }}... </p>
                    </div>
                    <div class="container">
                        <div class="index-image-container">
                            <img src="{{ route('resizeIndexImage', ['article' => $article]) }}" alt="{{ substr($article->title, 0, 30) }}" class="index-image">
                        </div>
                        <p>{{ substr($article->content, 0, 175) }}...</p>
                        <div class="d-flex justify-between align-content-between align-items-center">
                            @can('edit', $article)
                                <a href="{{ route('article.edit', ['article' => $article, 'slug' => $article->getSlug()]) }}" class="update-link">Modifier</a>
                            @endcan
                            @can('delete', $article)
                                <div>
                                    <form action="{{ route('articles.destroy', ['article' => $article]) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('delete')
                                        <x-danger-button class="">Supprimer</x-primary-button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @empty
    @endforelse
</div>

@endsection
