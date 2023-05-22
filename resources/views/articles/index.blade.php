@extends('base')

@section('content')
@forelse ($articles as $article)
        <p>{{ $article->title }}</p>
@empty
    
@endforelse
@endsection