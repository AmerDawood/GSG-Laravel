<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


    <h1>{{ $classroom->name }}</h1>

    {{-- <input hidden type="text" name="classroom_id"  value="1" id="">
    <input hidden type="text" name="role" value="student"  id="">
    <input hidden type="text" name="user_id" value="1"  id=""> --}}






    <form class="d-inline" action="{{ route('classroom..join.store',$classroom->id) }}" method="post">
        @csrf
    <button class="btn btn-sm btn-danger btn-delete">Join Now</button>

            </form>




</body>
</html>
