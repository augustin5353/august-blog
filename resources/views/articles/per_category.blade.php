@extends('base')

@section('content')

    <div class=" text-center d-flex justify-content-center align-content-center align-items-center" style="position: relative; width: 25%">
        @if ($articles->first() !== null )
            <p>{{ $articles->first()->category->designation}}</p>
        @endif
        
    </div>
    <div class="row">
    @forelse ($articles as $article)
        <div class="col-sm-6 pt-2">
            @include('articles.article_card')
        </div>
    @empty
    @endforelse
</div>
@endsection