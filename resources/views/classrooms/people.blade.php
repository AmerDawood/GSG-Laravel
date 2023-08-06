

@extends('master')



@section('content')
<h1>{{ $classroom->name }}</h1>


<x-alert name="success" class="alert-success"></x-alert>
<x-alert name="error" class="alert-success"></x-alert>


<div class="row">



    <table class="table">
        <thead>
          <tr>
            {{-- <th scope="col">#</th> --}}
            {{-- <th scope="col"></th> --}}
            <th scope="col">Name</th>
            <th scope="col">Role</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>


          </tr>
        </thead>
        <tbody>



          {{-- @foreach ($classroom->usres()->orderByDesc('id')->get() as $user) --}}
          @foreach ($classroom->usres as $user)


          <tr>
            {{-- <th scope="row">{{ $user->id }}</th> --}}
            <td>{{ $user->name }}</td>
            <td>{{ $user->join->role }}</td>
            <td>{{ $user->join->created_at }}</td>
            <td>
                <form action="{{ route('classroom.people.destroy',$classroom->id) }}" method="POST">
                @csrf
                @method('delete')
                <input type="text" hidden name="user_id" value="{{ $user->id }}">


                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>


            <td></td>
          </tr>
          @endforeach

        </tbody>
      </table>




</div>


@endsection
