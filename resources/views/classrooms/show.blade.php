

@extends('master')



@section('content')
<h1>All Classrooms</h1>

<div class="row">
 <h1>Classroom Id is :  {{ $classroom->id }} </h1>
 <h1>Classroom Name is :  {{ $classroom->name }} </h1>
 <h1>Classroom Code is :  {{ $classroom->code }} </h1>



    <p> <a href="{{ route('classrooms.classworks.index',$classroom->id) }}" class="btn btn-outline-dark">Classworks  </a></p>



 <p>Invetaion Link : <a href="{{$invetation_link }}"> {{ $invetation_link }}</a></p>
</div>


@endsection
