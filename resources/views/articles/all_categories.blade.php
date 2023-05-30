@extends('base')

@section('content')



<div class="row">
    @forelse ($categories as $category)
        <div class="col-sm-4 pt-2">
            <div class="polaroid position-relative">
                <a href="{{ route('article.by.category', ['slug' => 'articles-'. Str::slug($category->designation), 'category' => $category])}}">
                    <div class="container">
                        <div class="index-image-container">
                            <img src="{{ $category->getImagePath() }}" alt="{{ $category->designation }}" class="index-image">
                        </div>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <h3 class="category-designation-on-image">{{  $category->designation }}</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @empty
    @endforelse
</div>
@endsection