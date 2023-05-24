@extends('base')

@section('content')
<form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">

    @csrf
    @method('post')

    <x-articles.input name="title" holder="Titre de l'article" :value="$article->title ? $article->title  : '' " />

    <x-articles.input name="content" holder="Contenu" type="textarea" :value="$article->title ? $article->content  : '' " />


    <label for="formFileMultiple" class="form-label" >Multiple files input example</label>
    <input class="form-control @error('image') is-invalid @enderror" type="file" id="formFileMultiple"  name="image" />

    @error('images')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

    <div class="text-end mt-3">
        <x-primary-button class="">Publier</x-primary-button>
    </div>

</form>
@endsection
