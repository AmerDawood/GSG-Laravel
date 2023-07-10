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

        <form action="{{ route('classromm.store') }}" method="POST">
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
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>
