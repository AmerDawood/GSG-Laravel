








@extends('master')



@section('content')


<h1>Update Topic #{{ $topic->id }}</h1>

<form action="{{ route('topics.update',$topic->id) }}" method="POST">
 @csrf
 @method('put')
     {{-- <div class="mb-3">
       <label for="exampleInputEmail1" class="form-label">Name</label>
       <input type="text" value="{{ $topic->name }}" name="name" class="form-control" id="name" aria-describedby="emailHelp">
     </div>


     <div class="mb-3">
         <label for="time" class="form-label">Package Time</label>
         <select class="form-select" id="time" name="classroom_id">
             @foreach ($classroom as $item)
             <option value="{{ $item->id }}">{{ $item->name }}</option>
             @endforeach

         </select>
     </div>



     <button type="submit" class="btn btn-primary">Update</button> --}}


     @include('topics._form',['button_lable'=>'Update Topic'])

   </form>


@endsection
