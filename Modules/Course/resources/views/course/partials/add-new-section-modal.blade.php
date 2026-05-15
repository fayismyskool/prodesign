<!-- Add Chapter Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalTitle" aria-hidden="true" data-bs-backdrop='static'>
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalTitle">{{ __('Add New Chapter') }}</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.course-chapter.store', request('id')) }}" class="instructor__profile-form" method="post">
          @csrf

          {{-- Grade (required) --}}
          <div class="form-group">
            <label for="chapter_grade_select">{{ __('Grade') }} <code>*</code></label>
            <select id="chapter_grade_select" name="grade_id" class="form-control" required>
              <option value="">{{ __('Select Grade') }}</option>
              @foreach($grades as $grade)
                <option value="{{ $grade->id }}">{{ $grade->title }}</option>
              @endforeach
            </select>
          </div>

          {{-- Title --}}
          <div class="form-group mt-3">
            <label for="title">{{ __('Title') }} <code>*</code></label>
            <input id="title" name="title" type="text" value="" class="form-control">
          </div>

          {{-- Description --}}
          <div class="form-group mt-3">
            <label for="description">{{ __('Description') }}</label>
            <textarea id="description" name="description" rows="3" class="form-control"
              placeholder="{{ __('Enter chapter description (optional)') }}"></textarea>
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
