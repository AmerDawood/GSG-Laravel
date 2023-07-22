{{-- <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input type="text" value="{{ old('name', $classroom->name) }}"
        class="form-control @error('name') is-invalid @enderror " placeholder="Name" name="name" />



    <x-feedback name='name'></x-feedback>
</div> --}}


<x-text-field name='name' type='text' value='{{ $classroom->name }}' ></x-text-field>



<div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Section</label>
    <input type="text" value="{{ old('section', $classroom->section) }}" name="section"
        class="form-control @error('section') is-invalid @enderror " placeholder="Sectio Name" id="section">

    {{-- @error('section')
    <small class="invalid-feedback">{{ $message }}</small>
    @enderror --}}
    <x-feedback name='section'></x-feedback>
</div>

<div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Subject</label>
    <input type="text" value="{{ old('subject', $classroom->subject) }}" name="subject"
        class="form-control @error('subject') is-invalid @enderror" placeholder="Subject Name" id="subject">
    {{-- @error('subject')
      <small class="invalid-feedback">{{ $message }}</small>
      @enderror --}}

    <x-feedback name='subject'></x-feedback>
</div>

<div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Room</label>
    <input type="text" value="{{ old('room', $classroom->room) }}" name="room"
        class="form-control  @error('room') is-invalid @enderror" placeholder="Room" id="room">
    {{-- @error('room')
      <small class="invalid-feedback">{{ $message }}</small>
      @enderror --}}

    <x-feedback name='room'></x-feedback>
</div>


@if ($classroom->cover_image_path)
    <img src="{{ Storage::url($classroom->cover_image_path) }}" width="200" alt="...">
@endif
<div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Image</label>
    <input type="file" name="cover_image" class="form-control  @error('cover_image') is-invalid @enderror"
        id="cover_image">
    {{-- @error('cover_image')
      <small class="invalid-feedback">{{ $message }}</small>
      @enderror --}}
    <x-feedback name='cover_image'></x-feedback>
</div>

<button type="submit" class="btn btn-primary">{{ $button_label }}</button>
