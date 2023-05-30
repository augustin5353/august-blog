@extends('admin.base')

@section('content')

<div class="row">
    @forelse ($categories as $category)
        <div class="col-sm-2 pt-5">
            <div class="polaroid">
                    <div class="container">
                        <div class="index-image-container">
                            <img src="{{ $category->getImagePath() }}" alt="{{ $category->designation }}" class="index-image">
                        </div>
                        <p class="article-content-index"> {{ $category->designation }}</p>
                        <div class="d-flex justify-between align-content-between align-items-center">
                                <a href="{{ route('admin.category.edit', ['category' => $category]) }}" class="btn  btn-outline-info btn-sm">Modifier</a>

                                <div>
                                    <form action="{{ route('admin.category.destroy', ['category' => $category]) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('delete')
                                        <button class=" btn btn-outline-danger btn-sm ">Supprimer</button>
                                    </form>
                                </div>
                        </div>
                    </div>
            </div>
        </div>
    @empty
    <div>
        Aucune catégorie
    </div>
    @endforelse
    
</div>



    {{ $categories->links() }}
@endsection
