@extends('base')

@section('content')
<form action="{{ route($article->id === null ? 'articles.store' : 'articles.update', ['article' => $article]) }}" method="post" enctype="multipart/form-data">

    @csrf
    @method($article->id === null ? 'post' : 'put')

    <x-articles.input name="title" holder="Titre de l'article" :value="$article->title ? $article->title  : '' " />

    <x-articles.input name="content" holder="Contenu" type="textarea" :value="$article->title ? $article->content  : '' " />


        <div class="form-group mt-3 ">
            <label for="category"> Catégorie </label>
            <select name="category" id="category" class="@error('category') is-invalid @enderror form-control">
                @foreach ($categories as $k => $v)
                <option @selected($article->category_id === $k)  value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
             @error('category')
            <div class="invalid-feedback">
                {{ $message }} 
            </div>
            
            @enderror
        </div>
        
        <div class="form-group">
            <label for="image" class="form-label">Image</label>
            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" value="{{ $article->id !== null ? '' : $article->image_path}}" />
            @error('image')
            <div class="invalid-feedback mt-1">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group mt-4">
            <label for="tagInput">Ajouter des tags :</label>
            <input type="text" id="tagInput" placeholder="Saisissez un tag" class="form-control"/>
            <ul id="tagList" class="list-group"></ul>
            <input type="hidden" id="tagsArray" name="tags" value=""/>
        </div>
        
        <script>
          const tagInput = document.getElementById('tagInput');
          const tagList = document.getElementById('tagList');
          const tagsArray = []; // Tableau pour stocker les tags
        
          tagInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
              event.preventDefault(); // Empêche l'envoi du formulaire par défaut
        
              const tag = event.target.value.trim();
        
              if (tag !== '') {
                // Ajouter le tag au tableau des tags
                tagsArray.push(tag);
        
                // Ajouter le tag à la liste
                const li = document.createElement('li');
                li.textContent = tag;
                tagList.appendChild(li);
        
                // Réinitialiser le champ de texte
                event.target.value = '';
              }
            }
          });
        
          // Mettre à jour la valeur du champ de formulaire "tagsArray"
          const tagsArrayInput = document.getElementById('tagsArray');
        
          tagInput.addEventListener('blur', function() {
            tagsArrayInput.value = JSON.stringify(tagsArray);
          });
        </script>
        

    <div class="text-end mt-3">
        <x-primary-button class="">@if ($article->id === null)
            Créer
            @else 

            Modifer
            @endif
        </x-primary-button>
    </div>
    
   

</form>
@endsection
