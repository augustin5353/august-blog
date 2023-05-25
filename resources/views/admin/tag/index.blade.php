@extends('base')

@section('content')
    @forelse ($articles as $article)
        @if ($article->image_path !== null)
            
                <div class="polaroid">
                    <a href="{{ route('article.show', ['slug' => $article->getSlug(), 'article' => $article->id]) }}">
                    <div class=" p-1 ">   
                        <p class="">{{ $article->title }}</p>
                    </div>
                    <div class="">
                        <img src="{{ $article->getImagePath() }}" alt="{{ $article->title }}" class="index-image" >
                        <div class="container">
                            <p>{{ substr($article->content, 0, 35) }}...</p>
                            
                                <div class=" d-flex justify-between  align-content-between align-items-center">
                                    @can('edit', $article)
                                    <a href="{{ route('article.edit', ['article' =>$article, 'slug' =>$article->getSlug()]) }}" class="update-link">Modifier</a>
                                    @endcan

                                    @can('delete', $article)
                                    <div>
                                        <form action="{{ route('articles.destroy', ['article' => $article])}}" method="post" enctype="multipart/form-data">

                                            @csrf
                                            @method('delete')
                                                
                                            <x-danger-button class="">Supprimer</x-primary-button>
                                        </form>
                                    </div>
                                    @endcan
                                </div>
                                
                               
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
