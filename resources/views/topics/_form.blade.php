<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label  @error('name') is-invalid @enderror">Name</label>
    <input type="text" name="name" value="{{ old('room',$topic->name) }}" class="form-control" id="name" aria-describedby="emailHelp">
    @error('name')
    <small class="invalid-feedback">{{ $message }}</small>
    @enderror
  </div>

  <div class="mb-3">
      <label for="time" class="form-label  @error('classroom_id') is-invalid @enderror">Package Time</label>
      <select class="form-select" id="time"  name="classroom_id">
          @foreach ($classroom as $item)
          <option value="{{ $item->id }}">{{ $item->name }}</option>
          @endforeach

      </select>
      @error('classroom_id')
      <small class="invalid-feedback">{{ $message }}</small>
      @enderror
  </div>




  <button type="submit" class="btn btn-primary">{{ $button_lable }}</button>
