@extends('admin.base')

@section('content')
    <div class="row">
    @forelse ($tags as $tag)
        <div class="col-sm-3 pt-2">
                <div class="polaroid">
                    <div class=" card">
                        <div class=" card-body">
                            <p class="article-title">{{ $tag->name }}</p>
                        </div>

                        <div class="  d-flex  align-content-center justify-items-center justify-content-between m-3">
                            <a href="{{ route('tag.edit', ['tag' => $tag->id])}}" class="btn btn-outline-info  btn-sm">Editer</a>
                            <form action="{{ route('tag.destroy', ['tag' => $tag]) }}" method="post" enctype="multipart/form-data">

                                @csrf
                                @method('delete')

                                <div class="text-end mt-3">
                                    <button class=" btn btn-outline-danger btn-sm">Supprimer</button>
                                </div>
                            </form>           
                        </div>
                    </div>
                </div>
        </div>
    @empty
    @endforelse
    <div>{{$tags->links()}}</div>
</div>
@endsection
