@extends('admin.master_layout')
@section('title')
    <title>{{ __('Add Grade') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Course Grade') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active">
                        <a href="{{ route('admin.course-grade.index') }}">{{ __('Course Grade List') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Add Grade') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Add Grade') }}</h4>
                                <a href="{{ route('admin.course-grade.index') }}" class="btn btn-primary">
                                    <i class="fa fa-arrow-left"></i> {{ __('Back') }}
                                </a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.course-grade.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        {{-- Title --}}
                                        <div class="col-md-8 offset-md-2">
                                            <div class="form-group">
                                                <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                                                <input type="text" id="title" name="title"
                                                    value="{{ old('title') }}" placeholder="{{ __('e.g. Grade 1') }}"
                                                    class="form-control @error('title') is-invalid @enderror">
                                                @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        {{-- Description --}}
                                        <div class="col-md-8 offset-md-2">
                                            <div class="form-group">
                                                <label for="description">{{ __('Description') }}</label>
                                                <textarea id="description" name="description" rows="4"
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    placeholder="{{ __('Enter description (optional)') }}">{{ old('description') }}</textarea>
                                                @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        {{-- Status --}}
                                        <div class="col-md-8 offset-md-2">
                                            <div class="form-group">
                                                <label for="status">{{ __('Status') }} <span class="text-danger">*</span></label>
                                                <select id="status" name="status"
                                                    class="form-control @error('status') is-invalid @enderror">
                                                    <option value="active" {{ old('status','active') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                                </select>
                                                @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        {{-- Images via File Manager --}}
                                        <div class="col-md-8 offset-md-2">
                                            <div class="form-group">
                                                <label>{{ __('Images') }}</label>
                                                <div>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm grade-create-add-img-btn">
                                                        <i class="fas fa-folder-open me-1"></i> {{ __('Choose Images') }}
                                                    </button>
                                                    <small class="text-muted ms-2">{{ __('Click to open file manager') }}</small>
                                                </div>
                                                <div id="grade_create_img_list" class="row g-2 mt-2"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-8 offset-md-2 mt-3">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save me-1"></i> {{ __('Save') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
<script>
(function () {
    var imgList  = [];
    var listEl   = document.getElementById('grade_create_img_list');
    var form     = listEl.closest('form');

    document.querySelector('.grade-create-add-img-btn').addEventListener('click', function () {
        var prefix = (typeof base_url !== 'undefined' ? base_url : '') + '/laravel-filemanager';
        window.open(prefix + '?type=image', 'FileManager', 'width=900,height=600');
        window.SetUrl = function (items) {
            items.forEach(function (item) {
                imgList.push({ url: item.url, thumb: item.thumb_url, name: item.name || item.url.split('/').pop() });
            });
            render();
        };
    });

    function render() {
        listEl.innerHTML = '';
        form.querySelectorAll('input[name="grade_image_paths[]"]').forEach(function (el) { el.remove(); });

        imgList.forEach(function (img, i) {
            var col = document.createElement('div');
            col.className = 'col-auto';
            col.innerHTML =
                '<div class="position-relative" style="display:inline-block;">' +
                    '<img src="' + (img.thumb || img.url) + '" style="width:100px;height:100px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6;">' +
                    '<button type="button" class="btn btn-danger btn-sm position-absolute" style="top:2px;right:2px;padding:2px 6px;font-size:11px;" onclick="gradeCreateRemoveImg(' + i + ')">' +
                        '<i class="fas fa-times"></i>' +
                    '</button>' +
                    '<div class="text-center mt-1" style="font-size:11px;max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' + img.name + '</div>' +
                '</div>';
            listEl.appendChild(col);

            var inp   = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'grade_image_paths[]';
            inp.value = img.url;
            form.appendChild(inp);
        });
    }

    window.gradeCreateRemoveImg = function (i) { imgList.splice(i, 1); render(); };
})();
</script>
@endpush
