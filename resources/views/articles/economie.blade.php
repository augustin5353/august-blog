@extends('base')

@section('content')

<div class="row">
    @forelse ($articles as $article)
        <div class="col-sm-6 pt-2">
            @include('articles.article_card')
        </div>
    @empty
    @endforelse
</div>
    
@endsection