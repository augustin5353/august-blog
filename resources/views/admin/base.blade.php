<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/dashboard.js'])

</head>
<?php

$route = request()
    ->route()
    ->getName();
?>

<body>
    <div class="admin-div-commune    text-white  ">


        <div class="row ">

            <div class="col mt-col-base">
                <div class=" text-center "><p class="p-admin-section">Articles</p></div>
                <div class="text-center ">
                    <ul class=" justify-between  admin-ul-padding ">
                        <li class="mb-3">
                            <a href="{{ route('admin.article.index') }}" class="admin-link ">Liste</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.articles.unapproved')}}" class="admin-link @if($route === 'admin.articles.unapproved' || $route === 'admin.dashborad')  @endif">Attente</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
            <div class="col mt-col-base">
                <div class=" text-center"><p class="p-admin-section">Catégories</p></div>
                <div class="text-center ">
                    <ul class="  justify-between admin-ul-padding">
                        <li class="mb-3">
                            <a href="{{ route('category.index') }}" class=" admin-link @if($route === 'category.index') active-link @endif">Liste</a>
                        </li>
                        <li>
                            <a href="{{ route('category.create')}}" class="admin-link @if($route === 'category.edit' || $route === 'category.create') active-link @endif">Créer</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col mt-col-base">
                <div class=" text-center"><p class="p-admin-section">Tags</p></div>
                <div class="text-center ">
                    <ul class="  justify-between admin-div-commune-content admin-ul-padding ">
                        <li class=" mb-3">
                            <a href="{{ route('tag.index' )}}" class=" admin-link @if($route === 'tag.index') active-link @endif">Liste</a>
                        </li>
                        <li>
                            <a href="{{ route('tag.create')}}" class=" admin-link @if($route === 'tag.create' || $route === 'tag.edit') active-link @endif">Créer</a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col mt-col-base">
                <div class=" text-center"><p class="p-admin-section">Utilisateurs</p></div>
                <div class=" text-center gap-3 ">
                    <ul class="   justify-center admin-div-commune-content admin-ul-padding ">
                        <li class="mb-3">
                            <a href="{{ route('user.index')}}" class=" admin-link @if($route === 'user.index') active-link @endif">Liste</a>
                        </li>

                    </ul>
                </div>
            </div>
            
        </div>
    </div>


    <div class="body-marge">
        @yield('content')
    </div>

</body>

</html>
