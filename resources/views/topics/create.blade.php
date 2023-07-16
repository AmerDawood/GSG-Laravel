




@extends('master')



@section('content')

<h1>Create Topic</h1>

        <form action="{{ route('topics.store') }}" method="POST">
            @csrf


            @include('topics._form',['button_lable'=>'Create Topic'])

          </form>

    </div>


@endsection
