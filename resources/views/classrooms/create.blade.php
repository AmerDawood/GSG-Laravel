
@extends('master')



@section('content')


<h1>Create Classroom</h1>


         {{-- @if($errors->any())
         <div class="alert alert-danger">

            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
         </div>

         @endif --}}

        <form action="{{ route('classromm.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('classrooms._form',['button_label'=>'Create Classroom'])
          </form>

</div>


@endsection
