<div class="row">
    <div class="col-md-8">





        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" name="title" value="{{ $classWork->title }}" aria-describedby="emailHelp">
          </div>


          <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" class="myeditor" name="description" value="{{ $classWork->description }}" aria-describedby="emailHelp">
          </div>


    </div>
    <div class="col-md-4">

        <div class="form-group" style="padding-bottom: 30px">
            <label for="grade">Published At</label>
            <input type="date" min="0" name="published_at" id="published_at"
                   value="{{ isset($classWork->published_at) ? date('Y-m-d', strtotime($classWork->published_at)) : '' }}"
                   class="form-control">
        </div>



        <div>
            @foreach ($classroom->students as $student)
            <div class="form-check">
                <input class="form-check-input" name="student[]" type="checkbox" value="{{ $student->id }}" id="std-{{ $student->id }}" @checked( !isset($asigned) || in_array($student->id,$assignment ?? []))>
                <label class="form-check-label" for="std-{{ $student->id }}">
                  {{ $student->name }}
                </label>
              </div>

            @endforeach
        </div>








        @if($type == 'assignment')
        <div class="form-group" style="padding-bottom: 30px">
            <label for="grade">Grade</label>
            <input type="number" min="0" name="options[grade]" id="grade" value="{{ $classWork->options['grade'] ?? '' }}" class="form-control">
        </div>

        <div class="form-group" style="padding-bottom: 30px">
            <label for="due">Due Date</label>
            <input type="date" name="options[due]" id="due"  class="form-control" value="{{ $classWork->options['due'] ?? '' }}">
        </div>

        @endif


        <select class="form-select" name="topic_id" id="topic_id">
            <option value="">No Topics</option>

            @foreach ($classroom->topics as $topic)
                <option value="{{ $topic->id }}" @if ($classWork->topic_id == $topic->id) selected @endif>{{ $topic->name }}</option>
            @endforeach
        </select>

    </div>
</div>
