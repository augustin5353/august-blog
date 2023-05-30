@extends('admin.base')

@section('content')
<form action="{{ route($category->id !== null  ? 'admin.category.update' : 'admin.category.store', ['category' => $category]) }}" method="post" enctype="multipart/form-data">

    @csrf
    @method($category->id === null  ? 'post' : 'put')

    <x-articles.input name="designation"  :value="$category->designation ? $category->designation  : '' " />

        <div class="form-group">
            <label for="image_path" class="form-label">Image</label>
            <input class="form-control @error('image_path') is-invalid @enderror" type="file" id="image_path" name="image_path" value="{{ $category->id !== null ? '' : $category->image_path}}" />
            @error('image_path')
            <div class="invalid-feedback mt-1">
                {{ $message }}
            </div>
            @enderror
        </div>



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
