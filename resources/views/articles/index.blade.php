@extends('base')

@section('content')



  {{-- Article le plus populaire ces derniers 7 jours --}}
<div class="row mb-5  justify-between align-content-between align-items-center">
    <div class="col-8">
        <p class="show-title-article">{{ $popular_article->title }}</p>
        <a href="{{ route('article.show', ['article' => $popular_article , 'slug' => $popular_article->getSlug()]) }}">
            <img src="{{$popular_article->getImagePath()}}" alt="{{ substr($popular_article->title, 0, 30) }}" class="popular-article-image w-100 ">
        </a>
        <div>
            <div class="article-content text-justify">
                <a href="{{ route('article.show', ['article' => $popular_article , 'slug' => $popular_article->getSlug()]) }}" class="popular-article-clique-link">
                    <div>
                        @if (strlen($popular_article->content) > 250)
                            <span class=" article-content-total">{{ substr($popular_article->content, 0, 250) }}</span>
                            <span class="hidden-content article-content-total">{{ substr($popular_article->content, 250) }}</span>
                            
                        @else
                            <span class="article-content-total">{{ $popular_article->content }}</span>
                        @endif
                    </div>
                </a>
                <button class="read-more-btn text-info font-italic fs-5">Lire plus</button>
            </div>

        

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
    {{-- Carousel des articles plus po --}}
    
    <div class="col">
       <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" data-bs-interval="3000">

                @forelse ($sport_articles as $key => $article)
                
                   <a href="{{ route('article.show', ['article' => $article, 'slug' => $article->getSlug()])}}">
                     <div class="carousel-item @if ($key === 0) active @endif">
                        <div class="p-1">
                            <p class="article-title">{{ substr($article->title, 0, 75) }}...</p>
                        </div>
                        <img src="{{ $article->getImagePath() }}" class="d-block w-100 " alt="{{ substr($article->title, 0, 20) }}">
                    </div>
                   </a>

                @empty
                                
                @endforelse
                
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

{{-- Slide un article par categorie --}}



<div class="row">
    @forelse ($articles as $article)
        <div class="col-sm-6 pt-2">
            @include('articles.article_card')
        </div>
    @empty
    @endforelse
</div>

@endsection
