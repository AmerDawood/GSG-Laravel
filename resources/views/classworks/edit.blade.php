@extends('master')



@section('content')
    <h1>Update Classwork</h1>

{{--
    <h1>{{ $classroom->id }}</h1>
    <h1>ClassWork{{ $classWork->id }}</h1> --}}

    <x-errors></x-errors>

    <form action="{{ route('classrooms.classworks.edit', ['classroom' => $classroom->id, 'classwork' => $classWork->id, 'type' => $type]) }}" method="GET">


        @csrf
        @method('PUT')


        @include('classworks._form')











        <button style="margin-top: 20px" type="submit" class="btn btn-primary">Update</button>

    </form>

    </div>
@endsection
