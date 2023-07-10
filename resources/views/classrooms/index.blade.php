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
       <h1>All Classrooms</h1>

       <div class="row">
        @foreach ($classrooms as $classroom)
        <div class="card" style="width: 18rem; margin: 10px;">
            <img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{ $classroom->name }}</h5>
                <p class="card-text">{{ $classroom->section }}</p>
                <a href="{{ route('show.classroom', ['id' => $classroom->id]) }}" class="btn btn-success btn-sm">Go somewhere</a>
                <a href="{{ route('edit.classroom', ['id' => $classroom->id]) }}" class="btn btn-secondary btn-sm">Edit</a>
                <form id="delete-form" action="{{ route('destroy.classroom', ['id' => $classroom->id]) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

                <a href="#" class="btn btn-danger btn-sm" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this classroom?')) document.getElementById('delete-form').submit();">Delete</a>



            </div>
        </div>

        @endforeach
    </div></div>
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>
