@extends('master')



@section('content')


    <h1>{{ $classroom->description }}</h1>



    {{-- <h4>Description Is : {{ $classroom->classworks->title }}</h4> --}}

    <h1>{{ $classWork->title }}</h1>


    <x-errors></x-errors>

    <x-alert  name='success'></x-alert>
    <x-alert  name='error'></x-alert>


    <h1>Commment</h1>

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
        <div class="row" style="padding: 20px">
            <div class="col-md-2">
                <img src="https://ui-avatars.com/api/?name={{ $comment->user->name }}" alt="">
            </div>
            <div class="col-md-10">
                By {{ $comment->user?->name }} time: {{ $comment->created_at->diffForHumans() }}
            </div>
        </div>

    @empty
        <h4 class="text-center">No Comments Found</h4>
    @endforelse

    </div>

    </div>
@endsection
