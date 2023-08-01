



@extends('master')



@section('content')
<h1>Classworks</h1>


<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
     + Create
    </button>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="{{ route('classrooms.classworks.create',[$classroom->id , 'type'=>'assignment']) }}">Assignment</a></li>
      <li><a class="dropdown-item" href="{{ route('classrooms.classworks.create',[$classroom->id, 'type'=>'material']) }}">Material</a></li>
      <li><a class="dropdown-item" href="{{ route('classrooms.classworks.create',[$classroom->id, 'type'=>'question']) }}">Questions</a></li>
    </ul>
  </div>


<div class="row">
    @forelse($classworks as $group)
    <h3>{{ $group->first()->topic->name }}</h3>


    <div class="accordion accordion-flush" id="accordionFlushExample">
    @foreach($group as $classwork)

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $classwork->id }}" aria-expanded="false" aria-controls="flush-collapseOne">
              {{ $classwork->title }} / {{ $classwork->topic->name }}
            </button>
          </h2>
          <div id="flush-collapse{{ $classwork->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body"> {{ $classwork->description }}</div>
          </div>
        </div>

    @endforeach


      </div>
      @empty

      <p class="text-center fs3"> No Classworks Found</p>


      @endforelse


</div>

</div>


@endsection