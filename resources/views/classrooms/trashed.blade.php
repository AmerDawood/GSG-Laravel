



@extends('master')



@section('content')
<h1>Trashed Classrooms</h1>



<div class="row">
 @foreach ($classrooms as $classroom)
 <div class="card" style="width: 18rem; margin: 10px;">
     {{-- <img src="uploads/{{ $classroom->cover_image_path }}" class="card-img-top" alt="...">   when image in uploads --}}
     <img src="{{ Storage::url($classroom->cover_image_path) }}" style="height: 200px" class="card-img-top" alt="...">

     <div class="card-body">
         <h5 class="card-title">{{ $classroom->name }}</h5>
         <p class="card-text">{{ $classroom->section }}</p>
         {{-- <a class="btn btn-sm btn-primary" href="{{ route('edit.classroom', ['id' => $classroom->id]) }}"><i class="fas fa-edit"></i></a> --}}
         <form method="POST" action="{{ route('classroom.restore', $classroom->id) }}">
            @csrf
            @method('PUT')

            <button type="submit" class="btn btn-sm btn-success">Restore</button>
        </form>

         <button class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
    <form class="d-inline" action="{{ route('classroom.force-delete', $classroom->id) }}" method="post">
        @csrf
          @method('delete')
            </form>

     </div>
 </div>

 @endforeach
</div>

</div>


@endsection
