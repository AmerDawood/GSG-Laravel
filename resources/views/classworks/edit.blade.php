@extends('master')



@section('content')
    <h1>Update Classwork # {{ $classWork->title }}</h1>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-alert  name='success'></x-alert>
<x-alert  name='error'></x-alert>
{{--
    <h1>{{ $classroom->id }}</h1>
    <h1>ClassWork{{ $classWork->id }}</h1> --}}

    <x-errors></x-errors>


        <form action="{{ route('classrooms.classworks.update', ['classroom' => $classroom->id, 'classwork' => $classWork->id, 'type' => $type]) }}" method="POST">

        @csrf
        @method('PUT')


        @include('classworks._form')











        <button style="margin-top: 20px" type="submit" class="btn btn-primary">Update</button>

    </form>

    </div>
@endsection
