@php
    $class ??= null;
    $name ??= '';
    $label ??= '';
@endphp

<div @class(['form-check', 'font-switch', $class])>
    <label class="form-check-label" for="{{ $name }}"> {{ $label }} </label>
    <input type="hidden" name="{{ $name }}" value="0">
    <input @checked(old($name, $value ?? false)) type="checkbox" name="{{ $name }}" id="{{ $name }}" value="1" class="form-check-input 
    @error($name) 
    
    is-invalid
        
    @enderror" role="switch">


    @error($name)
    <div class="invalid-feedback">
        {{ $message }} 
    </div>
    
@enderror


</div>