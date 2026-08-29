<div class="modal-header">
    <h6 class="modal-title fs-5">{{ __('Update Activity') }}</h6>
</div>

<div class="p-3">
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
            <label>{{ __('Existing Files') }}</label>
            <div id="existing_files_list">
                @foreach($activityFiles as $file)
                <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-1" id="existing_file_{{ $file->id }}">
                    <div class="d-flex align-items-center">
                        @php
                            $ext = strtolower($file->file_type ?? '');
                            $isImage = in_array($ext, ['png','jpg','jpeg','gif','webp']);
                        @endphp
                        @if($isImage)
                            <img src="{{ $file->file_path }}"
                                style="width:40px;height:40px;object-fit:cover;border-radius:4px;" class="me-2">
                        @else
                            <span class="me-2" style="font-size:1.5rem;">
                                @if(in_array($ext, ['pdf']))
                                    <i class="fas fa-file-pdf text-danger"></i>
                                @elseif(in_array($ext, ['doc','docx']))
                                    <i class="fas fa-file-word text-primary"></i>
                                @elseif($ext === 'txt')
                                    <i class="fas fa-file-alt text-secondary"></i>
                                @elseif($ext === 'zip')
                                    <i class="fas fa-file-archive text-warning"></i>
                                @else
                                    <i class="fas fa-file text-muted"></i>
                                @endif
                            </span>
                        @endif
                        <div>
                            <div class="small fw-bold">{{ $file->file_name ?? basename($file->file_path) }}</div>
                            <a href="{{ $file->file_path }}" target="_blank"
                                class="text-muted" style="font-size:0.75rem;">{{ __('View') }}</a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger delete-activity-file-btn"
                        data-file-id="{{ $file->id }}"
                        data-url="{{ route('admin.course-chapter.activity-file.destroy', $file->id) }}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Upload New Files --}}
        <div class="form-group mb-3">
            <label>{{ __('Add More Files') }}</label>
            <div>
                <button type="button" class="btn btn-outline-secondary btn-sm act-edit-add-file-btn">
                    <i class="fas fa-folder-open me-1"></i> {{ __('Choose Files') }}
                </button>
                <small class="text-muted ms-2">{{ __('Click to open file manager and select files') }}</small>
            </div>
            <div id="act_edit_file_list" class="mt-2"></div>
        </div>

        <div class="modal-footer px-0">
            <button type="submit" class="btn btn-primary submit-btn">{{ __('Update') }}</button>
        </div>
    </form>
</div>

<script>
(function () {
    // ---- New file upload handling ----
    var fileList = [];
    var listEl   = document.getElementById('act_edit_file_list');
    var form     = listEl.closest('form');

    document.querySelector('.act-edit-add-file-btn').addEventListener('click', function () {
        var prefix = (typeof base_url !== 'undefined' ? base_url : '') + '/laravel-filemanager';
        window.open(prefix + '?type=file', 'FileManager', 'width=900,height=600');
        window.SetUrl = function (items) {
            items.forEach(function (item) {
                fileList.push({ url: item.url, name: item.name || item.url.split('/').pop() });
            });
            renderList();
        };
    });

    function renderList() {
        listEl.innerHTML = '';
        form.querySelectorAll('input[name="activity_files_paths[]"]').forEach(function (el) { el.remove(); });

        fileList.forEach(function (f, i) {
            var ext  = f.name.split('.').pop().toLowerCase();
            var icon = getIcon(ext);
            var row  = document.createElement('div');
            row.className = 'd-flex align-items-center justify-content-between border rounded p-2 mb-1';
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
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.delete-activity-file-btn');
        if (!btn) return;

        var fileId = btn.dataset.fileId;
        var url    = btn.dataset.url;
        var row    = document.getElementById('existing_file_' + fileId);

        if (!confirm('{{ __("Delete this file?") }}')) return;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.status === 'success') {
                if (row) row.remove();
            } else {
                alert(data.message || 'Error deleting file.');
            }
        })
        .catch(function () { alert('Error deleting file.'); });
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
        };
        return m[ext] || '<i class="fas fa-file text-muted"></i>';
    }
})();
</script>
