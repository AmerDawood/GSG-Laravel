

@extends('master')



@section('content')
<h1>All Classrooms</h1>

<div class="row">
 <h1>Classroom Id is :  {{ $classroom->id }} </h1>
 <h1>Classroom Name is :  {{ $classroom->name }} </h1>
 <h1>Classroom Code is :  {{ $classroom->code }} </h1>

</div>


@endsection
