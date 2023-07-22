@php

    $class = $name == 'error' ? 'danger' : 'success';

@endphp



@if (session()->has($name))
    <div class="alert alert-{{ $class }}" role="alert">
        From Component : {{ session($name) }}
    </div>
@endif
