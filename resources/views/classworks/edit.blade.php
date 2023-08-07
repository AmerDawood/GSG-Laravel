@extends('master')



@section('content')
    <h1>Update Classwork</h1>



    <x-errors></x-errors>

    <form action="{{ route('classrooms.classworks.update',[$classroom->id,$classwork->id , 'type'=>$type]) }}" method="POST">
        @csrf
        @method('PUT')

    <div class="row">
        <div class="col-md-8">

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" value="{{ $classwork->name }}" name="title" aria-describedby="emailHelp">
              </div>


              <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" class="form-control" value="{{ $classwork->description }}" name="description" aria-describedby="emailHelp">
              </div>

        </div>
        <div class="col-md-4">


            <div>
                @foreach ($classroom->students as $student)
                <div class="form-check">
                    <input class="form-check-input" name="students[]" type="checkbox" value="{{ $student->id }}" id="std-{{ $student->id }}" @checked(in_array($student->id , $asigned))>
                    <label class="form-check-label" for="std-{{ $student->id }}">
                      {{ $student->name }}
                    </label>
                  </div>

                @endforeach
            </div>


          <select  class="form-select" name="topic_id" id="topic_id">
            <option value="">No Topics</option>


            @foreach ($classroom->topics as  $topic)

            <option   @selected($topic->id == $classwork->topic_id)  value="{{ $topic->id }}">{{ $topic->name }}</option>

            @endforeach
          </select>
        </div>
    </div>







        <button style="margin-top: 20px" type="submit" class="btn btn-primary">Create</button>

    </form>

    </div>
@endsection
