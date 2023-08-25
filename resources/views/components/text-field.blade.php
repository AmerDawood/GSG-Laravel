
@props([ 'type' , 'value', 'name'])

<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input type="{{ $type }}" value="{{ old($name,$value)}}"
          name="{{ $name }}"
        class="form-control @error("$name") is-invalid @enderror"/>
        
    <x-feedback name='{{ $name }}'></x-feedback>
</div>
