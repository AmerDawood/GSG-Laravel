<!doctype html>
<html lang="en">
@include('layouts.head')
  <body>


    <div class="container">

         @include('layouts.header')
       <h1>All Topics</h1>

       <div class="row">
        @foreach ($topics as $topic)
        <div class="card" style="width: 18rem; margin: 10px;">
            <div class="card-body">
                <h5 class="card-title">{{ $topic->name }}</h5>
                <p class="card-text">{{ $topic->classroom_id }}</p>
                <a class="btn btn-sm btn-primary" href="{{ route('topics.edit', $topic->id) }}"><i class="fas fa-edit"></i></a>
                <a class="btn btn-sm btn-success" href="{{ route('topics.show', $topic->id) }}"><i class="fas fa-eye"></i></a>

                <button class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
           <form class="d-inline" action="{{ route('topics.destroy',$topic->id) }}" method="post">
               @csrf
                 @method('delete')
                   </form>


            </div>
        </div>

        @endforeach
    </div></div>
    {{-- @include('layouts.footer') --}}

     @include('layouts.scripts')
  </body>
</html>
