@extends('master')



@section('content')




  <h1>Trashed Topics</h1>


   {{-- @if(session()->has('success')) --}}
   {{-- <div class="alert alert-success" role="alert">
       {{ session('success') }}
     </div>

   @endif --}}


   <x-alert  name='success'></x-alert>
   <x-alert  name='error'></x-alert>


  <div class="row">


   @foreach ($topics as $topic)
   <div class="card" style="width: 18rem; margin: 10px;">
       <div class="card-body">
           <h5 class="card-title">{{ $topic->name }}</h5>
           <p class="card-text">{{ $topic->classroom_id }}</p>
           <form method="POST" action="{{ route('topic.restore', $topic->id) }}">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-sm btn-success">Restore</button>
        </form>
        

         <button class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
    <form class="d-inline" action="{{ route('topic.force-delete', $topic->id) }}" method="post">
        @csrf
          @method('delete')
            </form>
       </div>
   </div>

   @endforeach
</div>


@endsection
