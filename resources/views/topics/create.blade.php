<!doctype html>
<html lang="en">
    @include('layouts.head')

  <body>


    <div class="container">

       @include('layouts.header')
       <h1>Create Classroom</h1>

        <form action="{{ route('topics.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Name</label>
              <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="time" class="form-label">Package Time</label>
                <select class="form-select" id="time" name="classroom_id">
                    @foreach ($classroom as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach

                </select>
            </div>




            <button type="submit" class="btn btn-primary">Submit</button>
          </form>

    </div>
    {{-- @include('layouts.footer') --}}

    @include('layouts.scripts')

  </body>
</html>
