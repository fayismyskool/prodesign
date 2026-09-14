<div class="modal-header d-flex justify-content-between align-items-center">
    <h5 class="modal-title mb-0 fw-bold">{{ __('Sort Chapters') }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="p-3">
    <form action="{{ route('admin.course-chapter.sorting.store', $courseId) }}" method="POST"
        class="chapter_sorting_form">
        @csrf
        <ul class="list-group chapter_sorting_list">
            @foreach ($chapters as $chapter)
                <li class="list-group-item mb-2 d-flex align-items-center justify-content-between" data-order="{{ $chapter->order }}">
                    <input type="hidden" name="chapter_ids[]" value="{{ $chapter->id }}">
                    <div class="d-flex align-items-center">
                        <span class="icon-container mr-2 text-primary"><i class="fas fa-folder"></i></span>
                        <span class="fw-bold">{{ $chapter->grade ? $chapter->grade->title . ': ' : '' }}{{ truncate($chapter->title, 70) }}</span>
                    </div>
                    <div class="item-action">
                        <a href="javascript:;" class="text-dark dragger" style="cursor: grab; font-size: 1.1rem;"><i class="fas fa-arrows-alt"></i></a>
                    </div>
                </li>
            @endforeach
        </ul>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary save-chapter-sorting-btn">{{ __('Save changes') }}</button>
</div>
