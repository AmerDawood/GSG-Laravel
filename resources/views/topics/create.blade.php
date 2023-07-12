<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
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
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>
