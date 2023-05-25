@extends('base')

@section('content')
<form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">

    @csrf
    @method('post')

    <x-articles.input name="designation" holder="Nom de la catégorie" :value="$category->name ? $category->name  : '' " />

    <div class="text-end mt-3">
        <x-primary-button class="">Créer la catégorie</x-primary-button>
    </div>
</form>
@endsection
