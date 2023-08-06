



@extends('master')



@section('content')
<h1>All Classrooms</h1>



 <a href="{{ route('classrooms.create') }}"><button class="btn btn-primary">Create Classroom</button></a>



<div class="row">
 @foreach ($classrooms as $classroom)
 <div class="card" style="width: 18rem; margin: 10px;">
     {{-- <img src="uploads/{{ $classroom->cover_image_path }}" class="card-img-top" alt="...">   when image in uploads --}}
     <img src="{{ Storage::url($classroom->cover_image_path) }}" style="height:100px" class="card-img-top" alt="...">
     {{-- <img src="{{ $classroom->cover_image_path}}" style="height:100px" class="card-img-top" alt="..."> --}}



     <div class="card-body">
         <h5 class="card-title">{{ $classroom->name }}</h5>
         <p class="card-text">{{ $classroom->section }}</p>

         <a class="btn btn-sm btn-primary" href="{{ route('classrooms.edit',$classroom->id) }}"><i class="fas fa-edit"></i></a>
         <a class="btn btn-sm btn-success" href="{{ route('classrooms.show',$classroom->id) }}"><i class="fas fa-eye"></i></a>



         <button class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
    <form class="d-inline" action="{{ route('classrooms.destroy',$classroom->id) }}" method="post">
        @csrf
          @method('delete')
            </form>

         <a class="btn btn-sm btn-secondary" href="{{ route('show.topics.classroom',$classroom->id) }}">Show Topics</a>


     </div>
 </div>

 @endforeach
</div>

</div>


@endsection
