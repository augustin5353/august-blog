<x-mail::message>
# Un nouvel article a été publié

<p><h4>Article: </h4> <span>{{ $article->title }}</span></p><br><br>
<p><a href="{{ route('article.show', ['article' => $article, 'slug' => $article->getSlug()]) }}">Lire l'article</a></p>


<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
