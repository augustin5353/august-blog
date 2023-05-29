@extends('admin.base')

@section('content')
    @forelse ($users as $user)
        <div class="d-flex align-content-center justify-items-center justify-content-between align-items-center mb-3">
            @if ($user->image !== null)
                <div class="avartar" style="height: 45px !important;
    width: 45px !important; "> 
                  <img src="{{ $user->getImagePath() }}" alt="{{ $user->name }}" class="avartar-image" style="border-radius: 50% ; ">
                </div>
            @endif
            <span>{{ $user->name }}</span>
            <span>{{ $user->email }}</span>
            <form action="{{ route('user.destroy', ['user' => $user]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('delete')

                <div class="text-end mt-3">
                    <button class=" btn btn-outline-danger btn-sm">Supprimer</button>
                </div>
            </form>  
        </div>
    @empty
        
    @endforelse
@endsection