@extends('base')

@section('content')
<form action="{{ route('articles.store') }}" method="post">

    @csrf
    @method('post')

    <x-articles.input name="title" holder="Titre de l'article" :value="$article->title ? $article->title  : '' " />

    <x-articles.input name="content" holder="Contenu" :value="$article->title ? $article->content  : '' " />


    <div class="text-end">
        <x-primary-button class="">Publier</x-primary-button>
    </div>

</form>
@endsection
