
@extends('master')



@section('content')
<h1>Update Classroom # {{ $classroom->id }}</h1>

<form action="{{ route('classrooms.update',$classroom->id) }}" method="POST" enctype="multipart/form-data">
 @csrf
 @method('put')
   @include('classrooms._form',['button_label'=>'Update Classroom'])


       {{-- <img src="{{ asset('storage/'.$classroom->cover_image_path) }}" width="200" alt="..."> --}}


   </form>


@endsection
