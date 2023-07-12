<!doctype html>
<html lang="en">
    @include('layouts.head')

  <body>


    <div class="container">

       @include('layouts.header')
       <h1>Update Topic #{{ $topic->id }}</h1>

       <form action="{{ route('topics.update',$topic->id) }}" method="POST">
        @csrf
        @method('put')
            <div class="mb-3">
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
            {{-- <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Class Room</label>
              <input type="text" value="{{ $topic->classroom_id }}" name="classroom_id" class="form-control" id="section">
            </div> --}}


            <button type="submit" class="btn btn-primary">Update</button>
          </form>

    </div>
    {{-- @include('layouts.footer') --}}

    @include('layouts.scripts')

  </body>
</html>
