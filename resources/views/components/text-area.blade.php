
@props([



 'value', 'name'
])



<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <textarea>
          name="{{ $name }}"
        class="form-control @error("$name") is-invalid @enderror"

           </textarea>
    <x-feedback name='{{ $name }}'></x-feedback>
</div>
