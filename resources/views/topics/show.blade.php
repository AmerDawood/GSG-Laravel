<!doctype html>
<html lang="en">
    @include('layouts.head')

  <body>


    <div class="container">

         @include('layouts.header')
       <h1>Topics</h1>

       <div class="row">
        <h1>Topic Id is :  {{ $topic->id }} </h1>
        <h1>Topic Name is :  {{ $topic->name }} </h1>
        <h1>Topic Code is :  {{ $topic->classroom_id }} </h1>

    </div>
    </div>
    @include('layouts.footer')

    @include('layouts.scripts')

  </body>
</html>


