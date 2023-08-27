@php

    $class = $name == 'error' ? 'danger' : 'success';

@endphp



@if (session()->has($name))
    <div class="alert alert-{{ $class }}" role="alert">
         {{ session($name) }}
    </div>
@endif
