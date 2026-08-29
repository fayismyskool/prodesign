<div class="modal-header">
    <h6 class="modal-title fs-5">{{ __('Add Activity') }}</h6>
</div>

<div class="p-3">
    <form action="{{ route('admin.course-chapter.lesson.store') }}" method="POST"
        class="add_lesson_form instructor__profile-form">
        @csrf
        <input type="hidden" name="course_id" value="{{ $courseId }}">
        <input type="hidden" name="chapter_id" value="{{ $chapterId }}">
        <input type="hidden" name="type" value="{{ $type }}">

        {{-- Chapter --}}
        <div class="form-group mb-3">
            <label for="act_chapter">{{ __('Chapter') }} <code>*</code></label>
            <select name="chapter" id="act_chapter" class="chapter form-control">
                <option value="">{{ __('Select') }}</option>
                @foreach ($chapters as $chapter)
                    <option @selected($chapterId == $chapter->id) value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                @endforeach
            </select>
        </div>

        {{-- Title --}}
        <div class="form-group mb-3">
            <label for="act_title">{{ __('Title') }} <code>*</code></label>
            <input id="act_title" name="title" type="text" class="form-control" value="">
        </div>

        {{-- Description --}}
        <div class="form-group mb-3">
            <label for="act_description">{{ __('Description') }}</label>
            <textarea id="act_description" name="description" rows="3" class="form-control"></textarea>
        </div>

        {{-- Material Required --}}
        <div class="form-group mb-3">
            <label for="act_material">{{ __('Material Required') }}</label>
            <textarea id="act_material" name="material_required" rows="3" class="form-control"
                placeholder="{{ __('List materials needed for this activity...') }}"></textarea>
        </div>

        {{-- Age Range & Duration --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="act_age_min">{{ __('Age Min') }}</label>
                    <input id="act_age_min" name="age_min" type="number" min="0" max="255"
                        class="form-control" placeholder="e.g. 5">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="act_age_max">{{ __('Age Max') }}</label>
                    <input id="act_age_max" name="age_max" type="number" min="0" max="255"
                        class="form-control" placeholder="e.g. 12">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="act_duration">{{ __('Duration') }}</label>
                    <input id="act_duration" name="activity_duration" type="text"
                        class="form-control" placeholder="e.g. 30 mins">
                </div>
            </div>
        </div>

        {{-- Files via File Manager --}}
        <div class="form-group mb-3">
            <label>{{ __('Files') }}</label>
            <div>
                <button type="button" class="btn btn-outline-secondary btn-sm act-add-file-btn">
                    <i class="fas fa-folder-open me-1"></i> {{ __('Choose Files') }}
                </button>
                <small class="text-muted ms-2">{{ __('Click to open file manager and select files') }}</small>
            </div>
            <div id="act_create_file_list" class="mt-2"></div>
        </div>

        <div class="modal-footer px-0">
            <button type="submit" class="btn btn-primary submit-btn">{{ __('Create') }}</button>
        </div>
    </form>
</div>

<script>
(function () {
    var fileList = [];
    var listEl  = document.getElementById('act_create_file_list');
    var form    = listEl.closest('form');

    document.querySelector('.act-add-file-btn').addEventListener('click', function () {
        var prefix = (typeof base_url !== 'undefined' ? base_url : '') + '/laravel-filemanager';
        window.open(prefix + '?type=file', 'FileManager', 'width=900,height=600');
        window.SetUrl = function (items) {
            items.forEach(function (item) {
                addFile(item.url, item.name || item.url.split('/').pop());
            });
        };
    });

    function addFile(url, name) {
        var idx = fileList.length;
        fileList.push({ url: url, name: name });
        renderList();
    }

    function renderList() {
        listEl.innerHTML = '';
        // Remove old hidden inputs
        form.querySelectorAll('input[name="activity_files_paths[]"]').forEach(function (el) { el.remove(); });

        fileList.forEach(function (f, i) {
            var ext  = f.name.split('.').pop().toLowerCase();
            var icon = getIcon(ext);

            var row = document.createElement('div');
            row.className = 'd-flex align-items-center justify-content-between border rounded p-2 mb-1';
            row.innerHTML =
                '<div class="d-flex align-items-center gap-2">' +
                    '<span style="font-size:1.4rem;">' + icon + '</span>' +
                    '<span class="small fw-bold text-truncate" style="max-width:260px;" title="' + f.name + '">' + f.name + '</span>' +
                '</div>' +
                '<button type="button" class="btn btn-sm btn-outline-danger" onclick="actCreateRemoveFile(' + i + ')">' +
                    '<i class="fas fa-times"></i>' +
                '</button>';
            listEl.appendChild(row);

            // Hidden input carrying the path
            var inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'activity_files_paths[]';
            inp.value = f.url;
            form.appendChild(inp);
        });
    }

    window.actCreateRemoveFile = function (i) {
        fileList.splice(i, 1);
        renderList();
    };

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
