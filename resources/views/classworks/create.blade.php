@extends('master')



@section('content')
    <h1>Create Classroom</h1>



    <x-errors></x-errors>

    <form action="{{ route('classrooms.classworks.store',[$classroom->id, 'type'=>$type]) }}" method="POST">
        @csrf


        <h1>{{ $classroom->name }} // {{ $classroom->id }}</h1>

    @include('classworks._form')







        <button style="margin-top: 20px" type="submit" class="btn btn-primary">Create</button>

    </form>

    </div>
@endsection
