@extends('admin.base')

@section('title')
    Dashboard
@endsection


@section('content')
<?php
      $route = request()->route()->getName();
      ?>
  <div class="container-fluid my-3">

    <div class="row align-items-center align-content-between justify-center">

      {{-- La colonne des menus --}}
      <div class="col-md-3 mt-3">
        <!-- Sidebar -->
          <div class="">
            
            
        </div>
     </div>
   {{-- Fin colonne des menus --}}

    {{-- Stats --}}

      <div class="col-md-9">
          
deuxieme colonne

      </div>
    {{-- Fin Stats --}}

   Sans row

    <div class="row">
     
    </div>
    {{-- Fin des taches les plus proches --}}
  </div>
@endsection