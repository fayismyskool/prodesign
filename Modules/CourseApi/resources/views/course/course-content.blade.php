@extends('admin.master_layout')

@section('custom_meta')
    <meta name="course_id" content="{{ request('id') }}">
@endsection

@section('title')
    <title>{{ __('Course Create') }}</title>
@endsection

@section('admin-content')
    {{-- Step form --}}
    <form action="{{ route('admin.courses.update') }}" class="instructor__profile-form course-form">
        @csrf
        <input type="hidden" name="step" value="3">
        <input type="hidden" name="next_step" value="4">
    </form>

    @include('courseapi::course.partials.add-new-section-modal')

    {{-- ── Activity Files Modal ── --}}
    <div class="modal fade" id="activityFilesModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="fas fa-paperclip me-2"></i>{{ __('Activity Files') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="activityFilesModalBody">
                    {{-- Populated by JS --}}
                </div>
            </div>
        </div>
    </div>

    {{-- ── PDF Preview Modal ── --}}
    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="pdfPreviewTitle"><i class="fas fa-file-pdf me-2 text-danger"></i></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="pdfPreviewFrame" src="" style="width:100%;height:75vh;border:none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">{{ __('Course') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Course Create') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="col-12">
                    @include('course::course.navigation')
                    <div class="card">
                        <div class="card-body">
                            <div class="instructor__profile-form-wrap mt-4">
                                <form action="">
                                    @csrf
                                    <div class="mb-3 d-flex justify-content-between">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#exampleModal">
                                            {{ __('Add new chapter') }}
                                        </button>
                                        <button type="button" class="btn btn-primary sort-chapter-btn">
                                            {{ __('Sort chapter') }}
                                        </button>
                                    </div>

                                    <div class="accordion draggable-list" id="accordion">
                                        @forelse ($chapters as $chapter)
                                            @include('course::course.partials.chapter-accordion-item', ['chapter' => $chapter])
                                        @empty
                                            <p class="text-center p-5">{{ __('No chapters found.') }}</p>
                                        @endforelse
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
    <script src="{{ asset('global/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('global/js/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="{{ asset('backend/js/default/courses.js') }}?v={{$setting?->version}}"></script>
    <script src="{{ asset('backend/js/sweetalert.js') }}"></script>

    <script>
    $(document).on('click', '.activity-files-btn', function () {
        var itemId   = $(this).data('item-id');
        var container = $('#activity-files-' + itemId);
        var entries   = container.find('.activity-file-entry');
        var body      = $('#activityFilesModalBody');

        if (!entries.length) {
            body.html('<p class="text-center text-muted py-3">{{ __("No files uploaded.") }}</p>');
            $('#activityFilesModal').modal('show');
            return;
        }

        var html = '<div class="list-group">';
        entries.each(function () {
            var name       = $(this).data('file-name');
            var type       = $(this).data('file-type');
            var url        = $(this).data('file-url');
            var deleteUrl  = $(this).data('delete-url');
            var fileId     = $(this).data('file-id');
            var icon       = getFileIcon(type);
            var isPdf      = (type === 'pdf');
            var isImage    = ['png','jpg','jpeg','gif','webp','bmp'].includes(type);

            html += '<div class="list-group-item d-flex align-items-center justify-content-between gap-2" id="grade-file-row-' + fileId + '">';
            html += '<div class="d-flex align-items-center gap-3" style="min-width:0;">';

            if (isImage) {
                html += '<img src="' + url + '" style="width:48px;height:48px;object-fit:cover;border-radius:6px;flex-shrink:0;">';
            } else {
                html += '<span style="font-size:1.8rem;flex-shrink:0;">' + icon + '</span>';
            }

            html += '<div style="min-width:0;">';
            html += '<div class="fw-bold text-truncate" style="max-width:320px;" title="' + name + '">' + name + '</div>';
            html += '<small class="text-muted text-uppercase">' + type + '</small>';
            html += '</div></div>';

            html += '<div class="d-flex gap-2 flex-shrink-0">';
            if (isPdf) {
                html += '<button type="button" class="btn btn-sm btn-outline-danger preview-pdf-btn" data-url="' + url + '" data-name="' + name + '">'
                      + '<i class="fas fa-eye me-1"></i>{{ __("Preview") }}</button>';
            }
            html += '<a href="' + url + '" target="_blank" class="btn btn-sm btn-outline-secondary">'
                  + '<i class="fas fa-download me-1"></i>{{ __("Download") }}</a>';
            html += '<button type="button" class="btn btn-sm btn-outline-danger delete-grade-file-btn" data-url="' + deleteUrl + '" data-file-id="' + fileId + '">'
                  + '<i class="fas fa-trash-alt"></i></button>';
            html += '</div>';
            html += '</div>';
        });
        html += '</div>';

        body.html(html);
        $('#activityFilesModal').modal('show');
    });

    // PDF preview
    $(document).on('click', '.preview-pdf-btn', function () {
        var url  = $(this).data('url');
        var name = $(this).data('name');
        $('#pdfPreviewTitle').html('<i class="fas fa-file-pdf me-2 text-danger"></i>' + name);
        $('#pdfPreviewFrame').attr('src', url);
        $('#activityFilesModal').modal('hide');
        $('#pdfPreviewModal').modal('show');
    });

    // Re-open files modal when PDF modal closes
    $('#pdfPreviewModal').on('hidden.bs.modal', function () {
        $('#pdfPreviewFrame').attr('src', '');
    });

    // Delete activity file from modal
    $(document).on('click', '.delete-grade-file-btn', function () {
        var btn     = $(this);
        var url     = btn.data('url');
        var fileId  = btn.data('file-id');

        if (!confirm('{{ __("Delete this file?") }}')) return;

        $.ajax({
            method: 'DELETE',
            url: url,
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                if (res.status === 'success') {
                    $('#grade-file-row-' + fileId).fadeOut(300, function () { $(this).remove(); });
                    // Also remove from hidden data store
                    $('.activity-file-entry[data-file-id="' + fileId + '"]').remove();
                    toastr.success(res.message);
                }
            },
            error: function () { toastr.error('{{ __("Error deleting file.") }}'); }
        });
    });

    function getFileIcon(type) {
        var icons = {
            pdf:  '<i class="fas fa-file-pdf text-danger"></i>',
            doc:  '<i class="fas fa-file-word text-primary"></i>',
            docx: '<i class="fas fa-file-word text-primary"></i>',
            txt:  '<i class="fas fa-file-alt text-secondary"></i>',
            zip:  '<i class="fas fa-file-archive text-warning"></i>',
            xls:  '<i class="fas fa-file-excel text-success"></i>',
            xlsx: '<i class="fas fa-file-excel text-success"></i>',
        };
        return icons[type] || '<i class="fas fa-file text-muted"></i>';
    }
    </script>
@endpush
