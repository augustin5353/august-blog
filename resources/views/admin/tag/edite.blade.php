@extends('base')

@section('content')
<form action="{{ route('tag.store') }}" method="post" enctype="multipart/form-data">

    @csrf
    @method('post')

    <x-articles.input name="name" holder="Nom de la balise" :value="$tag->name ? $tag->name  : '' " />

    <div class="text-end mt-3">
        <x-primary-button class="">Créer la balise</x-primary-button>
    </div>
</form>
@endsection
