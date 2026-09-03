<div class="accordion-item course-section add_course_section_area">
    <h2 class="accordion-header" id="panelsStayOpen-heading{{ $chapter->id }}">
        <div class="accordion_header_content d-flex flex-wrap justify-content-between">
            <button class="accordion-button course-section-btn collapsed"
                type="button" data-toggle="collapse"
                data-target="#panelsStayOpen-collapse{{ $chapter->id }}"
                aria-expanded="true"
                aria-controls="panelsStayOpen-collapse{{ $chapter->id }}">
                <div class="icon_area d-flex flex-wrap justify-content-between align-items-center w-100">
                    <div class="d-flex flex-wrap align-items-center">
                        <span class="icon-container"><i class="far fa-folder"></i></span>
                        <small class="mb-0 ms-2 bold-text">{{ $chapter->grade?->title }} :&nbsp; </small>
                        <p class="mb-0 ms-2 bold-text">{{ $chapter->title }}</p>
                    </div>
                </div>
            </button>

            <div class="item-action item_action_header d-flex flex-wrap">
                <div class="dropdown action-item">
                    <span class="dropdown-toggle btn btn-small small-more-btn"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-plus"></i>
                    </span>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item add-lesson-btn"
                                data-type="lesson"
                                data-chapterid="{{ $chapter->id }}"
                                href="javascript:;">{{ __('Add Lesson') }}</a></li>
                        <li><a class="dropdown-item add-lesson-btn"
                                data-type="document"
                                data-chapterid="{{ $chapter->id }}"
                                href="javascript:;">{{ __('Add Document') }}</a></li>
                        <li><a class="dropdown-item add-lesson-btn"
                                data-type="activity"
                                data-chapterid="{{ $chapter->id }}"
                                href="javascript:;">{{ __('Add Activity') }}</a></li>
                        <li><a class="dropdown-item add-lesson-btn"
                                data-type="quiz"
                                data-chapterid="{{ $chapter->id }}"
                                href="javascript:;">{{ __('Add Quiz') }}</a></li>
                    </ul>
                </div>
                <a href="javascript:;" class="text-dark action-item edit-chapter-btn"
                    data-chapterid="{{ $chapter->id }}">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="{{ route('admin.course-chapter.destroy', $chapter->id) }}"
                    class="text-danger action-item delete-item">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
        </div>
    </h2>

    <div id="panelsStayOpen-collapse{{ $chapter->id }}"
        class="accordion-collapse collapse"
        aria-labelledby="panelsStayOpen-heading{{ $chapter->id }}">
        <div class="accordion-body">
            @forelse ($chapter->chapterItems as $chapterItem)
                @if ($chapterItem->type == 'lesson')
                    <div class="card course-section-item create_couese_item mb-3"
                        data-chapter-item-id="{{ $chapterItem->id }}"
                        data-chapterid="{{ $chapter->id }}">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="edit_course_icons d-flex flex-wrap align-items-center">
                                <span class="icon-container"><i class="fas fa-video"></i></span>
                                <p class="mb-0 ms-2 bold-text">{{ truncate($chapterItem->lesson->title) }}</p>
                                
                            </div>
                            <div class="item-action">
                                <a href="javascript:;" class="ms-2 text-dark edit-lesson-btn"
                                    data-type="{{ $chapterItem->type }}"
                                    data-courseid="{{ $chapter->course_id }}"
                                    data-chapterid="{{ $chapter->id }}"
                                    data-chapter_item_id="{{ $chapterItem->id }}">
                                    <i class="fas fa-edit"></i></a>
                                <a href="{{ route('admin.course-chapter.lesson.destroy', $chapterItem->id) }}"
                                    class="ms-2 text-danger delete-item">
                                    <i class="fas fa-trash-alt"></i></a>
                                <a href="javascript:;" class="ms-2 dragger"><i class="fas fa-arrows-alt"></i></a>
                            </div>
                        </div>
                    </div>

                @elseif ($chapterItem->type == 'document')
                    <div class="card course-section-item create_couese_item mb-3"
                        data-chapter-item-id="{{ $chapterItem->id }}"
                        data-chapterid="{{ $chapter->id }}">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="edit_course_icons d-flex flex-wrap align-items-center">
                                <span class="icon-container"><i class="fas fa-file-pdf"></i></span>
                                <p class="mb-0 ms-2 bold-text">{{ truncate($chapterItem->lesson?->title) }}</p>
                            </div>
                            <div class="item-action">
                                <a href="javascript:;" class="ms-2 text-dark edit-lesson-btn"
                                    data-type="{{ $chapterItem->type }}"
                                    data-courseid="{{ $chapter->course_id }}"
                                    data-chapterid="{{ $chapter->id }}"
                                    data-chapter_item_id="{{ $chapterItem->id }}">
                                    <i class="fas fa-edit"></i></a>
                                <a href="{{ route('admin.course-chapter.lesson.destroy', $chapterItem->id) }}"
                                    class="ms-2 text-danger delete-item">
                                    <i class="fas fa-trash-alt"></i></a>
                                <a href="javascript:;" class="ms-2 dragger"><i class="fas fa-arrows-alt"></i></a>
                            </div>
                        </div>
                    </div>

                @elseif ($chapterItem->type == 'activity')
                    <div class="card course-section-item create_couese_item mb-3"
                        data-chapter-item-id="{{ $chapterItem->id }}"
                        data-chapterid="{{ $chapter->id }}">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="edit_course_icons d-flex flex-wrap align-items-center">
                                <span class="icon-container"><i class="fas fa-tasks"></i></span>
                                <p class="mb-0 ms-2 bold-text">{{ truncate($chapterItem->lesson?->title) }}</p>
                            </div>
                            <div class="item-action d-flex align-items-center gap-1">
                                {{-- Files preview button --}}
                                @if($chapterItem->lesson && $chapterItem->lesson->activityFiles->count())
                                    <button type="button"
                                        class="btn btn-sm btn-outline-info ms-2 activity-files-btn"
                                        data-item-id="{{ $chapterItem->id }}"
                                        title="{{ __('View Files') }}">
                                        <i class="fas fa-paperclip"></i>
                                        <span class="badge badge-info ms-1">{{ $chapterItem->lesson->activityFiles->count() }}</span>
                                    </button>
                                @endif
                                <a href="javascript:;" class="ms-2 text-dark edit-lesson-btn"
                                    data-type="{{ $chapterItem->type }}"
                                    data-courseid="{{ $chapter->course_id }}"
                                    data-chapterid="{{ $chapter->id }}"
                                    data-chapter_item_id="{{ $chapterItem->id }}">
                                    <i class="fas fa-edit"></i></a>
                                <a href="{{ route('admin.course-chapter.lesson.destroy', $chapterItem->id) }}"
                                    class="ms-2 text-danger delete-item">
                                    <i class="fas fa-trash-alt"></i></a>
                                <a href="javascript:;" class="ms-2 dragger"><i class="fas fa-arrows-alt"></i></a>
                            </div>
                        </div>

                        {{-- Inline file list (hidden, shown in modal) --}}
                        @if($chapterItem->lesson && $chapterItem->lesson->activityFiles->count())
                            <div class="activity-files-data d-none" id="activity-files-{{ $chapterItem->id }}">
                                @foreach($chapterItem->lesson->activityFiles as $file)
                                    <div class="activity-file-entry"
                                        data-file-id="{{ $file->id }}"
                                        data-file-name="{{ $file->file_name }}"
                                        data-file-type="{{ strtolower($file->file_type) }}"
                                        data-file-url="{{ $file->file_path }}"
                                        data-delete-url="{{ route('admin.course-chapter.activity-file.destroy', $file->id) }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                @else
                    {{-- Quiz --}}
                    <div class="accordion card mb-2" id="accordionExample"
                        data-chapter-item-id="{{ $chapterItem->id }}"
                        data-chapterid="{{ $chapter->id }}">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <div class="accordion_header_content d-flex flex-wrap justify-content-between">
                                    <button class="accordion-button course-quiz-btn collapsed"
                                        type="button" data-toggle="collapse"
                                        data-target="#panelsStayOpen-collapse{{ $chapterItem->id }}"
                                        aria-expanded="true"
                                        aria-controls="panelsStayOpen-collapse{{ $chapterItem->id }}">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center w-100">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <span class="icon-container"><i class="fas fa-question"></i></span>
                                                <p class="mb-0 ms-2 bold-text">{{ $chapterItem->quiz->title }}</p>
                                            </div>
                                        </div>
                                    </button>
                                    <div class="item-action course_quiz_item_action d-flex">
                                        <div class="dropdown action-item">
                                            <span class="dropdown-toggle btn btn-small small-more-btn"
                                                data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item add-quiz-question-btn"
                                                        data-quiz-id="{{ $chapterItem->quiz->id }}"
                                                        href="javascript:;">{{ __('Add Question') }}</a></li>
                                            </ul>
                                        </div>
                                        <a href="javascript:;"
                                            data-type="{{ $chapterItem->type }}"
                                            data-courseid="{{ $chapter->course_id }}"
                                            data-chapterid="{{ $chapter->id }}"
                                            data-chapter_item_id="{{ $chapterItem->id }}"
                                            class="text-dark action-item edit-lesson-btn">
                                            <i class="fas fa-edit"></i></a>
                                        <a href="{{ route('admin.course-chapter.lesson.destroy', $chapterItem->id) }}"
                                            class="text-danger action-item delete-item">
                                            <i class="fas fa-trash-alt"></i></a>
                                        <a href="javascript:;" class="ms-2 dragger">
                                            <i class="fas fa-arrows-alt"></i></a>
                                    </div>
                                </div>
                            </h2>
                            <div id="panelsStayOpen-collapse{{ $chapterItem->id }}"
                                class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @forelse ($chapterItem->quiz->questions as $question)
                                        <div class="card course-section-item mb-3">
                                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="edit_course_icons d-flex flex-wrap align-items-center">
                                                    <span class="icon-container">
                                                        <i class="far fa-question-circle"></i>
                                                    </span>
                                                    <p class="mb-0 ms-2 bold-text">{{ $question->title }}</p>
                                                </div>
                                                <div class="item-action">
                                                    <a href="javascript:;" class="ms-2 text-dark edit-question-btn"
                                                        data-question-id="{{ $question->id }}">
                                                        <i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('admin.course-chapter.quiz-question.destroy', $question->id) }}"
                                                        class="ms-2 text-danger delete-item">
                                                        <i class="fas fa-trash-alt"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center">{{ __('No questions found.') }}</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-center">{{ __('No lessons found.') }}</p>
            @endforelse
        </div>
    </div>
</div>
