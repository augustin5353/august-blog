@include('base')
<div class="row">
    @forelse ($articles as $article)
        <div class="col-sm-4 pt-5">
            <div class="polaroid">
                <a href="{{ route('article.show', ['slug' => $article->getSlug(), 'article' => $article->id]) }}">
                    <div class="p-1">
                        <p class="article-title">{{ substr($article->title, 0, 50) }}...</p>
                    </div>
                    <div class="container">
                        <div class="index-image-container">
                            <img src="{{ $article->getImagePath() }}" alt="{{ substr($article->title, 0, 30) }}" class="index-image">
                        </div>
                        <p class="article-content">{{ substr($article->content, 0, 175) }}...</p>
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