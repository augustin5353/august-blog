@extends('admin.base')

@section('content')
<form action="{{ route($category->id !== null  ? 'category.update' : 'category.store', ['category' => $category]) }}" method="post" enctype="multipart/form-data">

    @csrf
    @method($category->id === null  ? 'post' : 'put')

    <x-articles.input name="designation"  :value="$category->designation ? $category->designation  : '' " />

    <div class="text-end mt-3">
        <x-primary-button class="">
            @if ($category->id === null)
                Créer
            @else
                Modifier
            @endif
        </x-primary-button>
    </div>
</form>
@endsection
