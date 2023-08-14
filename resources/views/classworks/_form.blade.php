<div class="row">
    <div class="col-md-8">

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" name="title" aria-describedby="emailHelp">
          </div>


          <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" class="form-control" name="description" value="{{ $classwork->description }}" aria-describedby="emailHelp">
          </div>

    </div>
    <div class="col-md-4">


        <div>
            @foreach ($classroom->students as $student)
            <div class="form-check">
                <input class="form-check-input" name="students[]" type="checkbox" value="{{ $student->id }}" id="std-{{ $student->id }}" @checked(in_array($student->id,$assignment ?? []))>
                <label class="form-check-label" for="std-{{ $student->id }}">
                  {{ $student->name }}
                </label>
              </div>

            @endforeach
        </div>




        @if($type == 'assignment')
        <div class="form-group" style="padding-bottom: 30px">
            <label for="grade">Grade</label>
            <input type="number" min="0" name="grade" id="grade" class="form-control">
        </div>

        <div class="form-group" style="padding-bottom: 30px">
            <label for="due">Due Date</label>
            <input type="date" name="due" id="due" class="form-control">
        </div>

        @endif


      <select  class="form-select" name="topic_id" id="topic_id">
        <option value="">No Topics</option>


        @foreach ($classroom->topics as  $topic)

        <option value="{{ $topic->id }}">{{ $topic->name }}</option>

        @endforeach
      </select>
    </div>
</div>
