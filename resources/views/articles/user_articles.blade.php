@extends('base')

@section('content')
  <div class="row">
    <span class="  text-end mr-5 text-user-articles">Vos articles</span>
    @forelse ($articles as $article)
        <div class="col-sm-4 pt-2">
            @include('articles.article_card')
        </div>
    @empty
    @endforelse
  </div>

@endsection