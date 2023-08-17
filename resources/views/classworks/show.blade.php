@extends('master')



@section('content')


    <h1>{{ $classroom->description }}</h1>



    {{-- <h4>Description Is : {{ $classroom->classworks->title }}</h4> --}}

    <h1>Classwork Title : {{ $classWork->title }}</h1>
    <h1>Classwork Description : {{ $classWork->description }}</h1>



    <x-errors></x-errors>

    <x-alert  name='success'></x-alert>
    <x-alert  name='error'></x-alert>


    <h1>Commments</h1>


    <div class="row">
     <div class="col-md-8">

    <form action="{{ route('comment.store') }}" method="POST">
        @csrf
    <div class="row">
        <div class="col-md-8">

            <input type="hidden" name="id" value="{{ $classWork->id }}">
            <input type="hidden" name="type" value="classwork">


            <div class="mb-3">
                <label class="form-label">Comment</label>
                <input type="text" class="form-control" name="content" aria-describedby="emailHelp">
              </div>
        </div>
    </div>
        <button style="margin-top: 20px" type="submit" class="btn btn-primary">Create</button>

    </form>

    <div class="mt-4">

        @forelse ($classWork->comments as $comment)

        <div class="row border border-secondery" style="padding: 20px">
            <div class="col-md-2">
                <img src="https://ui-avatars.com/api/?name={{ $comment->user->name }}" alt="">
            </div>
            <div class="col-md-10">
                By {{ $comment->user?->name }} time: {{ $comment->created_at->diffForHumans() }}
                <br>
                <p>{{ $comment->content}}</p>
            </div>

        </div>

    @empty
        <h4 class="text-center">No Comments Found</h4>
    @endforelse

    </div>

    </div>



    <div class="col-md-4">



        @if ($submissions->count())
        <ul>
            @foreach ($submissions as  $item)

            <li><a href="{{ route('submmistions.file',$item->content) }}"></a>File {{ $loop->itetration }}</li>

            @endforeach
        </ul>

        @else
        <div class="borders rounded p-3 bg-light">
            <h4>Upload Files</h4>
            <form action="{{ route('submmistions.store',$classWork->id) }}" method="POST" enctype="application/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Uplode Files</label>
                <input type="file" class="form-control" multiple name="files[]" accept="image/*,application/pdf" placeholder="Select Your Files" aria-describedby="emailHelp">
              </div>


              <button type="submit" class="btn btn-primary">Submit</button>

            </form>
          </div>

        @endif




    </div>
     </div>
    </div>

@endsection
