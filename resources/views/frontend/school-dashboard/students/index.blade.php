@extends('frontend.school-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <h4 class="title mb-0">{{ __('Students') }}</h4>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#importStudentModal">
                    <i class="fa fa-file-import"></i> {{ __('Import CSV') }}
                </button>
                <a href="{{ route('school.students.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> {{ __('Add Student') }}
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Roll / ID') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $index => $member)
                                <tr>
                                    <td>{{ $students->firstItem() + $index }}</td>
                                    <td>
                                        <a href="{{ route('school.students.show', $member->id) }}" class="fw-bold text-primary">
                                            {{ $member->user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $member->user->email }}</td>
                                    <td>{{ $member->id_number ?? '-' }}</td>
                                    <td>
                                        @if($member->status === 'active')
                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('school.students.show', $member->id) }}" class="btn btn-sm btn-outline-info" title="{{ __('View Progress & Quiz Scores') }}">
                                            <i class="fa fa-chart-line"></i>
                                        </a>
                                        <form action="{{ route('school.students.toggle-status', $member->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-warning" title="{{ $member->status === 'active' ? __('Deactivate') : __('Activate') }}">
                                                <i class="fa fa-{{ $member->status === 'active' ? 'ban' : 'check' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('school.students.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{ __('No students found. Add your first student!') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $students->links() }}
            </div>
        </div>
    </div>
@endsection

@push('modals')
    {{-- Import Student Modal --}}
    <div class="modal fade" id="importStudentModal" tabindex="-1" aria-labelledby="importStudentModalLabel" aria-hidden="true" style="z-index: 99999;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importStudentModalLabel">
                        <i class="fa fa-file-csv text-primary"></i> {{ __('Import Students via CSV') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('school.students.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-light border mb-3" style="font-size: 13px;">
                            <div class="fw-bold mb-1"><i class="fa fa-info-circle text-info"></i> {{ __('CSV Column Format:') }}</div>
                            <code>Name, Email, Roll_Number, Password</code>
                            <div class="text-muted mt-1">{{ __('Password is optional (defaults to 123456). Accounts will be activated immediately.') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="student_csv_file" class="form-label fw-bold">{{ __('Select CSV File') }} <span class="text-danger">*</span></label>
                            <input type="file" name="csv_file" id="student_csv_file" class="form-control" accept=".csv,.txt,text/csv,text/plain" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="text-muted" style="font-size: 12px;">{{ __('Need a format reference?') }}</span>
                            <a href="{{ route('school.students.download-template') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-download"></i> {{ __('Download CSV Template') }}
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-upload"></i> {{ __('Upload & Import') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
