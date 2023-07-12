
@extends('master')



@section('content')


<h1>Topics</h1>

<div class="row">
 <h1>Topic Id is :  {{ $topic->id }} </h1>
 <h1>Topic Name is :  {{ $topic->name }} </h1>
 <h1>Topic Code is :  {{ $topic->classroom_id }} </h1>

</div>


@endsection
