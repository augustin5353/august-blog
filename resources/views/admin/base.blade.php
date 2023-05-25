<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
                <div class=" ">
                    <ul class="nav justify-between  admin-ul-padding ">
                        <li>
                            <a href="{{ route('admin.article.index') }}" class="admin-link ">Liste</a>
                        </li>
                        <li>
                            <a href="" class="admin-link ">Attente</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
            <div class="col mt-col-base">
                <div class=" text-center"><p class="p-admin-section">Catégories</p></div>
                <div class="">
                    <ul class="nav  justify-between admin-ul-padding">
                        <li>
                            <a href="" class=" admin-link">Liste</a>
                        </li>
                        <li>
                            <a href="" class="admin-link">Créer</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col mt-col-base">
                <div class=" text-center"><p class="p-admin-section">Tags</p></div>
                <div class="">
                    <ul class="nav  justify-between admin-div-commune-content admin-ul-padding ">
                        <li>
                            <a href="" class=" admin-link">Liste</a>
                        </li>
                        <li>
                            <a href="" class=" admin-link">Créer</a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col mt-col-base">
                <div class=" text-center"><p class="p-admin-section">Utilisateurs</p></div>
                <div class="">
                    <ul class="nav   justify-center admin-div-commune-content admin-ul-padding ">
                        <li>
                            <a href="" class=" admin-link">Liste</a>
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
