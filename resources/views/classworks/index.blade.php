@extends('master')



@section('content')
    <h1>Classworks</h1>
    <x-alert  name='success'></x-alert>
    <x-alert  name='error'></x-alert>
{{--
    @foreach ($classworks as $classwork)
    {{ $classwork->classroom_id }}
    @endforeach --}}



     @can('classworks.create',[$classroom])
     <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            + Create
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item"
                    href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'assignment']) }}">Assignment</a>
            </li>
            <li><a class="dropdown-item"
                    href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'material']) }}">Material</a></li>
            <li><a class="dropdown-item"
                    href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'question']) }}">Questions</a>
            </li>
        </ul>
    </div>

     @endcan
     @php
     $classroomId = null;
     @endphp

    <div class="row">
        @forelse($classworks as $group)
            <h3>{{ $group->first()->topic->name }}</h3>

            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($group as $classwork)
                @php
                // Add classroom_id to the classroomIds array
                $classroomId = $classwork->classroom_id;
                @endphp
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse{{ $classwork->id }}" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                             {{ $classwork->classroom_id }}/   {{ $classwork->title }} / {{ $classwork->topic->name }}
                            </button>
                        </h2>
                        <div id="flush-collapse{{ $classwork->id }}" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body"> {!! $classwork->description !!}</div>
                            <a href="{{ route('classrooms.classworks.edit', [$classwork->classroom->id , $classwork->id]) }}">Edit ClassWork</a>
                            <a href="{{ route('classrooms.classworks.show', [$classwork->classroom->id , $classwork->id]) }}">Show ClassWork</a>
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


 @push('scripts')

 <script>

    // const classroomId = classroomId;
    const classroomId = @json($classroomId);
    console.log(classroomId);
   </script>




   @vite(['resources/js/app.js'])
 @endpush




