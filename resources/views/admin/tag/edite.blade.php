@extends('admin.base')

@section('content')
<form action="{{ route($tag->id !== null  ? 'admin.tag.update' : 'admin.tag.store', ['tag' => $tag]) }}" method="post" enctype="multipart/form-data">

    @csrf
    @method($tag->id === null  ? 'post' : 'put')

        <x-articles.input name="name"  :value="$tag->name ? $tag->name  : '' " />    

    <div class="text-end mt-3">
        <x-primary-button class="">
            @if ($tag->id === null)
                Créer
            @else
                Modifier
            @endif
        </x-primary-button>
    </div>
</form>
@endsection
