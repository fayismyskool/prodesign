<!-- Edit Grade Modal (loaded dynamically) -->
<div class="modal-header d-flex justify-content-between align-items-center">
  <h5 class="modal-title mb-0 fw-bold">{{ __('Edit Grade') }}</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body p-4">
  <form action="{{ route('admin.course-grade.update', $grade->id) }}" class="instructor__profile-form" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="grade_title">{{ __('Title') }} <code>*</code></label>
      <input id="grade_title" name="title" type="text" class="form-control" value="{{ $grade->title }}">
    </div>
    <div class="form-group mt-3">
      <label for="grade_description">{{ __('Description') }}</label>
      <textarea id="grade_description" name="description" rows="3" class="form-control"
        placeholder="{{ __('Enter grade description (optional)') }}">{{ $grade->description }}</textarea>
    </div>
    <div class="text-end mt-3">
      <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>
  </form>
</div>
