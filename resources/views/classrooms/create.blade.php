
@extends('master')



@section('content')


<h1>Create Classroom</h1>

        <form action="{{ route('classromm.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Name</label>
              <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Section</label>
              <input type="text" name="section" class="form-control" id="section">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" id="subject">
              </div>

              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" id="subject">
              </div>

              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Room</label>
                <input type="text" name="room" class="form-control" id="room">
              </div>

              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Image</label>
                <input type="file" name="cover_image" class="form-control" id="cover_image">
              </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>

</div>


@endsection
