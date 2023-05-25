@extends('base')

@section('content')
<form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">

    @csrf
    @method('post')

    <x-articles.input name="title" holder="Titre de l'article" :value="$article->title ? $article->title  : '' " />

    <x-articles.input name="content" holder="Contenu" type="textarea" :value="$article->title ? $article->content  : '' " />


        <div class="form-group mt-3 ">
            <label for="category"> Catégorie </label>
            <select name="category" id="category" class="@error('category') is-invalid @enderror form-control">
                @foreach ($categories as $k => $v)
                <option @selected($article->category_id === $k)  value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
             @error('category')
            <div class="invalid-feedback">
                {{ $message }} 
            </div>
            
            @enderror
        </div>
        <div class="form-group mt-3 ">
            <label for="tag"> Ajouter de balises </label>
            <select name="tags[]" id="tag" class="@error('tag') is-invalid @enderror form-control" multiple>
                @foreach ($tags as $k => $v)
                <option  @selected($article->tags->contains($k)) value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
             @error('tags')
            <div class="invalid-feedback">
                {{ $message }} 
            </div>
            
            @enderror
        </div>


    <div class=" form-group">
        <label for="formFileMultiple" class="form-label" >Image</label>
        <input class="form-control @error('image') is-invalid @enderror" type="file" id="formFileMultiple"  name="image" />
    </div>
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
