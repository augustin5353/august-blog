{{-- Ici nous créeon de champs de formulaire réutilisables
    conncernant la gestion des erreurs, on utilise la directive @error()
    de laravel au niveau des formulaire. Et donc dans le champ on verifie s'il y a une erreur,
    dans ce cas, on ajoute une classe is-error
        
    @enderror --}}

    @php
    $type ??= 'text';
    $class ??= null;
    $name ??= '';
    $value ??= '';
    $label ??= ucfirst($name);
@endphp

<div @class(['form-group', $class])>
    <label for="{{ $name }}"> {{ $label }} </label>
    @if ($type === 'textarea')
    <textarea class="form-control @error($name)
        is-invalid
        @enderror" type="{{ $type }}" 
        id="{{ $name }}" name="{{ $name }}"
        >{{ old($name, $value)}}</textarea>
    @else
    <input class="form-control @error($name)
        is-invalid
        @enderror" type="{{ $type }}" 
        id="{{ $name }}" name="{{ $name }}"
 value="{{ old($name, $value)}}">
    @endif
    

     @error($name)
    <div class="invalid-feedback">
        {{ $message }} 
    </div>
    
@enderror
</div>
