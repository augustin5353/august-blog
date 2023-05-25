<x-mail::message>
# Un nouveau commentaire pour votre article 

<p>{{ $comment->user->name }} a comment votre article titré: {{ $article->title }}</p>

<p>Commentaire: {{ $comment->content }}</p>
<p><a href="{{ route('article.show', ['article' => $article, 'slug' => $article->getSlug()]) }}">Voir plus</a></p>

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
