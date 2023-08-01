@extends('master')



@section('content')
    <h1>Create Classroom</h1>



    <x-errors></x-errors>


    <form action="{{ route('classrooms.classworks.store',[$classroom->id, 'type'=>$type]) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" name="title" aria-describedby="emailHelp">
          </div>


          <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" class="form-control" name="description" aria-describedby="emailHelp">
          </div>


          <select  class="form-select" name="topic_id" id="topic_id">
            <option value="">No Topics</option>


            @foreach ($classroom->topics as  $topic)

            <option value="{{ $topic->id }}">{{ $topic->name }}</option>

            @endforeach
          </select>

        <button style="margin-top: 20px" type="submit" class="btn btn-primary">Create</button>

    </form>

    </div>
@endsection
