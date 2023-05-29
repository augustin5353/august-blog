<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://unicons.iconscout.com/release/v4.0.0/css/thinline.css">
    @vite(['resources/css/app.css','resources/css/show_article.css','resources/css/dashboard.css',  'resources/js/app.js', ''])

</head>
<?php

$route = request()
    ->route()
    ->getName();
?>

<body>
    <div class="div-commune  p-3   row ">
        <div class="col-3 text-start ">
            <ul class="nav justify-content-start div-commune-content">
                <li class="nav-item">
                    <a class="nav-link   text-white base-comune-link-hover
        @if ($route === 'articles.create') link-cliked @endif"
                        href="{{ route('articles.create') }} ">Créer article</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link   text-white base-comune-link-hover
       @if ($route === 'articles.index') link-cliked @endif"
                        href="{{ route('articles.index') }}">Articles</a>
                </li>

                
            </ul>
        </div>

        <div class="col">
            <ul class="nav"> 
                <li class="nav-item">
                    <a class="nav-link   text-white base-comune-link-hover
       @if ($route === 'article.sport') active-link @endif"
                        href="{{ route('article.sport') }}">Sport</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link   text-white base-comune-link-hover
       @if ($route === 'article.economie') active-link @endif"
                        href="{{ route('article.economie') }}">Economie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link   text-white base-comune-link-hover
       @if ($route === 'article.all.categories') link-cliked @endif"
                        href="{{ route('article.all.categories', ['slug' => 'sport-politique-economie-dev-mobile-autres']) }}">Voir plus</a>
                </li>
            </ul>

        </div>

        <div class="col-4  m-3">
             @guest
                <ul class="nav justify-content-end">
                    <li>
                        <a class="nav-link text-white base-comune-link-hover" href="{{ route('login') }}" class="@if ($route === 'login') active-link @endif">Se connecter</a>
                    </li>
                </ul>
            @endguest
            @auth
            <ul class="nav justify-content-end div-commune-content">
                <li>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        @method('post')

                        <button class=" btn nav-link   text-white   base-comune-link-hover">
                            {{ Auth::user()->name }}</button>
                    </form>
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link   text-white base-comune-link-hover
            @if ($route === 'admin.dashborad') link-clicked-group @endif"
                                href="{{ route('admin.dashborad') }}">Administrer</a>
                        </li>
                    @endif
                </li>
            </ul> 
                @endauth

               
        </div>
    </div>

    <form action="{{ route('search')}}" method="get" enctype="multipart/form-data">

        @csrf
        @method('get')
            
            <div class=" d-flex justify-content-end  align-content-between align-items-center  justify-items-center search-marge">
                <x-articles.input name="query" holder="tags" type="text" value="" label=" " class=" mr-3"/>
                
                <div class=" ">
                    <x-primary-button class=" ">Rechercher</x-primary-button>
                </div>
            </div>
            
    </form>

    <div class="body-marge">
        
        @yield('content')
    </div>

</body>

</html>
