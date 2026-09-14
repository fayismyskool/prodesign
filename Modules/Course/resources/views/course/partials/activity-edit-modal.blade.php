<div class="modal-header d-flex justify-content-between align-items-center">
    <h5 class="modal-title mb-0 fw-bold">{{ __('Update Activity') }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body p-4">
    <form action="{{ route('admin.course-chapter.lesson.update') }}" method="POST"
        class="update_lesson_form instructor__profile-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="course_id" value="{{ $courseId }}">
        <input type="hidden" name="chapter_item_id" value="{{ $chapterItem->id }}">
        <input type="hidden" name="type" value="{{ $chapterItem->type }}">

        {{-- Chapter --}}
        <div class="form-group mb-3">
            <label for="edit_act_chapter">{{ __('Chapter') }} <code>*</code></label>
            <select name="chapter" id="edit_act_chapter" class="chapter form-control">
                <option value="">{{ __('Select') }}</option>
                @foreach ($chapters as $chapter)
                    <option @selected($chapterItem->chapter_id == $chapter->id) value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                @endforeach
            </select>
        </div>

        {{-- Title --}}
        <div class="form-group mb-3">
            <label for="edit_act_title">{{ __('Title') }} <code>*</code></label>
            <input id="edit_act_title" name="title" type="text" class="form-control"
                value="{{ $chapterItem->lesson->title ?? '' }}">
        </div>

        {{-- Description --}}
        <div class="form-group mb-3">
            <label for="edit_act_description">{{ __('Description') }}</label>
            <textarea id="edit_act_description" name="description" rows="3" class="form-control">{{ $chapterItem->lesson->description ?? '' }}</textarea>
        </div>

        {{-- Material Required --}}
        <div class="form-group mb-3">
            <label for="edit_act_material">{{ __('Material Required') }}</label>
            <textarea id="edit_act_material" name="material_required" rows="3" class="form-control"
                placeholder="{{ __('List materials needed for this activity...') }}">{{ $chapterItem->lesson->material_required ?? '' }}</textarea>
        </div>

        {{-- Age Range & Duration --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="edit_act_age_min">{{ __('Age Min') }}</label>
                    <input id="edit_act_age_min" name="age_min" type="number" min="0" max="255"
                        class="form-control" value="{{ $chapterItem->lesson->age_min ?? '' }}" placeholder="e.g. 5">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="edit_act_age_max">{{ __('Age Max') }}</label>
                    <input id="edit_act_age_max" name="age_max" type="number" min="0" max="255"
                        class="form-control" value="{{ $chapterItem->lesson->age_max ?? '' }}" placeholder="e.g. 12">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="edit_act_duration">{{ __('Duration') }}</label>
                    <input id="edit_act_duration" name="activity_duration" type="text"
                        class="form-control" value="{{ $chapterItem->lesson->activity_duration ?? '' }}" placeholder="e.g. 30 mins">
                </div>
            </div>
        </div>

        {{-- Existing Files --}}
        @if(isset($activityFiles) && $activityFiles->count() > 0)
        <div class="form-group mb-3">
            <label class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold">{{ __('Existing Files') }}</span>
                <span class="badge bg-secondary text-white" style="font-size: 11px;">
                    <i class="fas fa-arrows-alt me-1"></i>{{ __('Drag handle or use ▲▼ to reorder') }}
                </span>
            </label>
            <div id="existing_files_list" class="sortable-files-list">
                @foreach($activityFiles as $file)
                @php
                    $ext = strtolower($file->file_type ?? '');
                    $isImage = in_array($ext, ['png','jpg','jpeg','gif','webp']);
                    $isAudio = in_array($ext, ['mp3','wav','ogg','audio','m4a']);
                    $isPdf   = ($ext === 'pdf');
                    $fileUrl = asset($file->file_path);
                @endphp
                <div class="existing-file-row d-flex align-items-center justify-content-between border rounded p-2 mb-2 bg-white shadow-sm"
                     id="existing_file_{{ $file->id }}"
                     data-file-id="{{ $file->id }}">
                    <input type="hidden" name="ordered_file_ids[]" value="{{ $file->id }}">

                    <div class="d-flex align-items-center gap-2" style="min-width: 0; flex: 1;">
                        {{-- Drag Handle --}}
                        <span class="file-dragger btn btn-sm btn-light border text-muted px-2 py-1"
                              style="cursor: grab;" title="{{ __('Drag to reorder') }}">
                            <i class="fas fa-grip-vertical"></i>
                        </span>

                        {{-- Move Up / Down Buttons --}}
                        <div class="btn-group btn-group-sm me-1" role="group">
                            <button type="button" class="btn btn-outline-secondary px-1 py-0 move-file-up" title="{{ __('Move Up') }}">
                                <i class="fas fa-chevron-up" style="font-size: 10px;"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary px-1 py-0 move-file-down" title="{{ __('Move Down') }}">
                                <i class="fas fa-chevron-down" style="font-size: 10px;"></i>
                            </button>
                        </div>

                        {{-- File Icon / Thumbnail --}}
                        @if($isImage)
                            <img src="{{ $fileUrl }}"
                                style="width:38px;height:38px;object-fit:cover;border-radius:6px;flex-shrink:0;" class="border">
                        @else
                            <span class="flex-shrink-0" style="font-size:1.6rem; line-height: 1;">
                                @if($isPdf)
                                    <i class="fas fa-file-pdf text-danger"></i>
                                @elseif(in_array($ext, ['doc','docx']))
                                    <i class="fas fa-file-word text-primary"></i>
                                @elseif($isAudio)
                                    <i class="fas fa-headphones text-info"></i>
                                @elseif($ext === 'txt')
                                    <i class="fas fa-file-alt text-secondary"></i>
                                @elseif($ext === 'zip')
                                    <i class="fas fa-file-archive text-warning"></i>
                                @else
                                    <i class="fas fa-file text-muted"></i>
                                @endif
                            </span>
                        @endif

                        <div style="min-width: 0; flex: 1;" class="me-2">
                            <div class="small fw-bold text-truncate" title="{{ $file->file_name ?? basename($file->file_path) }}">
                                {{ $file->file_name ?? basename($file->file_path) }}
                            </div>
                            <span class="badge bg-light text-dark border text-uppercase" style="font-size: 9px;">
                                {{ $ext ?: 'file' }}
                            </span>
                        </div>
                    </div>

                    {{-- Actions: View / Preview & Delete --}}
                    <div class="d-flex align-items-center gap-1 flex-shrink-0">
                        <a href="{{ $fileUrl }}" target="_blank"
                            class="btn btn-sm btn-outline-primary px-2 py-1"
                            title="{{ __('View or download file in new window') }}">
                            <i class="fas fa-external-link-alt me-1"></i>{{ __('View / Preview') }}
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-activity-file-btn px-2 py-1"
                            data-file-id="{{ $file->id }}"
                            data-url="{{ route('admin.course-chapter.activity-file.destroy', $file->id) }}"
                            title="{{ __('Delete file') }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Upload New Files --}}
        <div class="form-group mb-3">
            <label class="fw-bold">{{ __('Add More Files') }}</label>
            <div>
                <button type="button" class="btn btn-outline-secondary btn-sm act-edit-add-file-btn">
                    <i class="fas fa-folder-open me-1"></i> {{ __('Choose Files') }}
                </button>
                <small class="text-muted ms-2">{{ __('Click to open file manager and select files') }}</small>
            </div>
            <div id="act_edit_file_list" class="mt-2"></div>
        </div>

        <div class="modal-footer px-0">
            <button type="submit" class="btn btn-primary submit-btn px-4">{{ __('Update') }}</button>
        </div>
    </form>
</div>

<script>
(function () {
    // Make existing files sortable
    function initFileSortable() {
        if (typeof jQuery !== 'undefined' && typeof jQuery.fn.sortable !== 'undefined') {
            $('#existing_files_list').sortable({
                handle: '.file-dragger',
                items: '.existing-file-row',
                cursor: 'move',
                containment: 'parent',
                tolerance: 'pointer',
                opacity: 0.8
            });
        }
    }
    initFileSortable();
    setTimeout(initFileSortable, 200);

    // Up / Down Click Reordering
    $(document).off('click', '.move-file-up').on('click', '.move-file-up', function(e) {
        e.preventDefault();
        var row = $(this).closest('.existing-file-row');
        var prev = row.prev('.existing-file-row');
        if (prev.length) {
            row.insertBefore(prev).hide().fadeIn(150);
        }
    });

    $(document).off('click', '.move-file-down').on('click', '.move-file-down', function(e) {
        e.preventDefault();
        var row = $(this).closest('.existing-file-row');
        var next = row.next('.existing-file-row');
        if (next.length) {
            row.insertAfter(next).hide().fadeIn(150);
        }
    });

    // ---- New file upload handling ----
    var fileList = [];
    var listEl   = document.getElementById('act_edit_file_list');
    var form     = listEl ? listEl.closest('form') : null;

    var addFileBtn = document.querySelector('.act-edit-add-file-btn');
    if (addFileBtn) {
        addFileBtn.addEventListener('click', function () {
            var prefix = (typeof base_url !== 'undefined' ? base_url : '') + '/laravel-filemanager';
            window.open(prefix + '?type=file', 'FileManager', 'width=900,height=600');
            window.SetUrl = function (items) {
                items.forEach(function (item) {
                    fileList.push({ url: item.url, name: item.name || item.url.split('/').pop() });
                });
                renderList();
            };
        });
    }

    function renderList() {
        if (!listEl || !form) return;
        listEl.innerHTML = '';
        form.querySelectorAll('input[name="activity_files_paths[]"]').forEach(function (el) { el.remove(); });

        fileList.forEach(function (f, i) {
            var ext  = f.name.split('.').pop().toLowerCase();
            var icon = getIcon(ext);
            var row  = document.createElement('div');
            row.className = 'd-flex align-items-center justify-content-between border rounded p-2 mb-1 bg-light';
            row.innerHTML =
                '<div class="d-flex align-items-center gap-2">' +
                    '<span style="font-size:1.4rem;">' + icon + '</span>' +
                    '<span class="small fw-bold text-truncate" style="max-width:260px;" title="' + f.name + '">' + f.name + '</span>' +
                '</div>' +
                '<button type="button" class="btn btn-sm btn-outline-danger" onclick="actEditRemoveFile(' + i + ')">' +
                    '<i class="fas fa-times"></i>' +
                '</button>';
            listEl.appendChild(row);

            var inp   = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'activity_files_paths[]';
            inp.value = f.url;
            form.appendChild(inp);
        });
    }

    window.actEditRemoveFile = function (i) { fileList.splice(i, 1); renderList(); };

    // ---- Delete existing files ----
    $(document).off('click', '.delete-activity-file-btn').on('click', '.delete-activity-file-btn', function (e) {
        e.preventDefault();
        var btn = $(this);
        var fileId = btn.data('file-id');
        var url    = btn.data('url');
        var row    = $('#existing_file_' + fileId);

        if (!confirm('{{ __("Delete this file?") }}')) return;

        $.ajax({
            method: 'DELETE',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function (data) {
                if (data.status === 'success') {
                    row.fadeOut(300, function() { $(this).remove(); });
                    toastr.success(data.message || 'File deleted successfully');
                } else {
                    toastr.error(data.message || 'Error deleting file.');
                }
            },
            error: function () {
                toastr.error('Error deleting file.');
            }
        });
    });

    function getIcon(ext) {
        var m = {
            pdf:  '<i class="fas fa-file-pdf text-danger"></i>',
            doc:  '<i class="fas fa-file-word text-primary"></i>',
            docx: '<i class="fas fa-file-word text-primary"></i>',
            txt:  '<i class="fas fa-file-alt text-secondary"></i>',
            zip:  '<i class="fas fa-file-archive text-warning"></i>',
            png:  '<i class="fas fa-file-image text-success"></i>',
            jpg:  '<i class="fas fa-file-image text-success"></i>',
            jpeg: '<i class="fas fa-file-image text-success"></i>',
            mp3:  '<i class="fas fa-headphones text-info"></i>',
            wav:  '<i class="fas fa-headphones text-info"></i>',
            ogg:  '<i class="fas fa-headphones text-info"></i>',
        };
        return m[ext] || '<i class="fas fa-file text-muted"></i>';
    }
})();
</script>
