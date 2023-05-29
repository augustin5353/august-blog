@extends('base')

@section('content')
<div class="row">
    @forelse ($categories as $category)
        <div class="col-sm-6 pt-2">
            <div class="polaroid">
                <a href="{{ route('article.by.category', ['slug' => 'articles-'. Str::slug($category->designation), 'category' => $category])}}">
                    <div class=" card">
                        <div class=" card-body">
                            <p>{{ $category->designation }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @empty
    @endforelse
</div>
    
@endsection