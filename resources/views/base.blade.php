<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://unicons.iconscout.com/release/v4.0.0/css/thinline.css">
    @vite(['resources/css/app.css','resources/css/show_article.css', 'resources/js/app.js'])

</head>
<?php

$route = request()
    ->route()
    ->getName();
?>

<body>
    <div class="div-commune  p-3  bg-primary text-white row ">

        <div class="col-9">
            <ul class="nav justify-content-start div-commune-content">
                <li class="nav-item">
                    <a class="nav-link   text-white base-comune-link-hover
        @if ($route == 'home') link-clicked @endif"
                        href="{{ route('articles.create') }} ">Créer article</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link   text-white base-comune-link-hover
       @if (str_contains($route, 'group')) link-clicked-group @endif"
                        href="{{ route('articles.index') }}">Articles</a>
                </li>

                @auth

                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link   text-white base-comune-link-hover
            @if (str_contains($route, 'group')) link-clicked-group @endif"
                                href="{{ route('admin.dashborad') }}">Administrer</a>
                        </li>
                    @endif

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        @method('post')

                        <button class=" btn nav-link   text-white  btn-primary base-comune-link-hover">
                            {{ Auth::user()->name }}</button>
                    </form>


                @endauth

                @guest
                    <a class="nav-link text-white base-comune-link-hover" href="{{ route('login') }}">Se connecter</a>
                @endguest
            </ul>
        </div>


    </div>
    @auth
        <form action="{{ route('logout') }}" method="post" class="text-end">
            @csrf
            @method('delete')
            <button class="btn  btn-secondary">Se deconnecter</button>
        </form>
    @endauth


    <div class="body-marge">
        @yield('content')
    </div>

</body>

</html>
