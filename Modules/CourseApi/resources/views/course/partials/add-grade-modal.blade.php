<!-- Add Grade Modal -->
<div class="modal fade" id="addGradeModal" tabindex="-1" role="dialog" aria-labelledby="addGradeModalTitle" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="addGradeModalTitle">{{ __('Add New Grade') }}</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.course-grade.store', request('id')) }}" class="instructor__profile-form" method="post">
          @csrf
          <div class="form-group">
            <label for="grade_title">{{ __('Title') }} <code>*</code></label>
            <input id="grade_title" name="title" type="text" class="form-control" placeholder="{{ __('e.g. Grade 1') }}">
          </div>
          <div class="form-group mt-3">
            <label for="grade_description">{{ __('Description') }}</label>
            <textarea id="grade_description" name="description" rows="3" class="form-control"
              placeholder="{{ __('Enter grade description (optional)') }}"></textarea>
          </div>
          <div class="text-end mt-3">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
