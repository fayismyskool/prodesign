@extends('frontend.school-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title d-flex justify-content-between align-items-center mb-4">
            <h4 class="title">{{ __('Teacher Details & Progress') }}</h4>
            <a href="{{ route('school.teachers.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left"></i> {{ __('Back to Teachers') }}
            </a>
        </div>

        {{-- Teacher Overview Card --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center mb-3 mb-md-0">
                        <div style="width: 70px; height: 70px; border-radius: 50%; background: #4f46e5; color: white; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; margin: auto;">
                            {{ strtoupper(substr($member->user->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h5 class="mb-1">{{ $member->user->name }}</h5>
                        <p class="text-muted mb-1"><i class="fa fa-envelope"></i> {{ $member->user->email }}</p>
                        @if($member->id_number)
                            <p class="text-muted mb-0"><i class="fa fa-id-card"></i> {{ __('Employee ID') }}: {{ $member->id_number }}</p>
                        @endif
                    </div>
                    <div class="col-md-5 text-md-end">
                        <p class="mb-1">
                            <strong>{{ __('Status') }}:</strong>
                            @if($member->status === 'active')
                                <span class="badge bg-success">{{ __('Active') }}</span>
                            @else
                                <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                            @endif
                        </p>
                        <p class="text-muted mb-0"><strong>{{ __('Joined') }}:</strong> {{ $member->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Assigned Courses & Progress --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ __('Assigned Courses & Learning Progress') }}</h5>

                @if($assignments->isEmpty())
                    <div class="alert alert-info mb-0">
                        {{ __('No courses assigned to this teacher yet.') }}
                        <a href="{{ route('school.courses.index') }}">{{ __('Assign Courses') }}</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __('Course') }}</th>
                                    <th>{{ __('Assigned On') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th style="min-width: 200px;">{{ __('Progress') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignments as $assignment)
                                    <tr>
                                        <td>
                                            <strong>{{ $assignment->course->title ?? __('Course Deleted') }}</strong>
                                        </td>
                                        <td>{{ $assignment->assigned_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($assignment->status === 'active')
                                                <span class="badge bg-success">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('Revoked') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between mb-1" style="font-size: 13px;">
                                                <span class="fw-bold">{{ $assignment->progress_percent ?? 0 }}%</span>
                                                <span class="text-muted">{{ $assignment->watched_lectures ?? 0 }}/{{ $assignment->total_lectures ?? 0 }} {{ __('lessons') }}</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width: {{ $assignment->progress_percent ?? 0 }}%"
                                                     aria-valuenow="{{ $assignment->progress_percent ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
