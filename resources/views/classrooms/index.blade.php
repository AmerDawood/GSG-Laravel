



@extends('master')



@section('content')
<h1>All Classrooms</h1>

<div class="row">
 @foreach ($classrooms as $classroom)
 <div class="card" style="width: 18rem; margin: 10px;">
     {{-- <img src="uploads/{{ $classroom->cover_image_path }}" class="card-img-top" alt="...">   when image in uploads --}}
     <img src="storage/{{ $classroom->cover_image_path }}" class="card-img-top" alt="...">

     <div class="card-body">
         <h5 class="card-title">{{ $classroom->name }}</h5>
         <p class="card-text">{{ $classroom->section }}</p>
         {{-- <a href="{{ route('show.classroom', ['id' => $classroom->id]) }}" class="btn btn-success btn-sm">Go somewhere</a>
         <a href="{{ route('edit.classroom', ['id' => $classroom->id]) }}" class="btn btn-secondary btn-sm">Edit</a>
         <form id="delete-form" action="{{ route('destroy.classroom', ['id' => $classroom->id]) }}" method="POST" style="display: none;">
             @csrf
             @method('DELETE')
         </form>

         <a href="#" class="btn btn-danger btn-sm" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this classroom?')) document.getElementById('delete-form').submit();">Delete</a> --}}

         <a class="btn btn-sm btn-primary" href="{{ route('edit.classroom', ['id' => $classroom->id]) }}"><i class="fas fa-edit"></i></a>
         <a class="btn btn-sm btn-success" href="{{ route('show.classroom', ['id' => $classroom->id]) }}"><i class="fas fa-eye"></i></a>

         <button class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
    <form class="d-inline" action="{{ route('destroy.classroom', ['id' => $classroom->id]) }}" method="post">
        @csrf
          @method('delete')
            </form>

     </div>
 </div>

 @endforeach
</div>

</div>


@endsection
