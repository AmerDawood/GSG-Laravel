
@extends('master')



@section('content')


<h1>Create Classroom</h1>



    <x-errors></x-errors>



        <form action="{{ route('classrooms.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            @include('classrooms._form',['button_label'=>'Create Classroom'])
          </form>

</div>


@endsection
