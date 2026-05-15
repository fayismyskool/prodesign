<!-- Edit Chapter Modal (loaded dynamically) -->
<div class="modal-header">
  <h6 class="modal-title" id="exampleModalLabel">{{ __('Edit Chapter') }}</h6>
</div>

<div class="">
  <form action="{{ route('admin.course-chapter.update', $chapter->id) }}" class="instructor__profile-form" method="post">
    @csrf
    @method('PUT')

    {{-- Grade --}}
    <div class="form-group">
      <label for="edit_grade_id">{{ __('Grade') }} <code>*</code></label>
      <select id="edit_grade_id" name="grade_id" class="form-control" required>
        <option value="">{{ __('Select Grade') }}</option>
        @foreach(\App\Models\CourseGrade::where('status', 'active')->orderBy('order')->get() as $grade)
          <option value="{{ $grade->id }}" {{ $chapter->grade_id == $grade->id ? 'selected' : '' }}>
            {{ $grade->title }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Title --}}
    <div class="form-group mt-3">
      <label for="title">{{ __('Title') }} <code>*</code></label>
      <input id="title" name="title" type="text" value="{{ $chapter->title }}" class="form-control">
    </div>

    {{-- Description --}}
    <div class="form-group mt-3">
      <label for="description">{{ __('Description') }}</label>
      <textarea id="description" name="description" rows="3" class="form-control"
        placeholder="{{ __('Enter chapter description (optional)') }}">{{ $chapter->description }}</textarea>
    </div>

    <div class="text-end mt-3">
      <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>
  </form>
</div>
