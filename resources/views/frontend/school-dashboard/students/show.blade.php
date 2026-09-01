@extends('frontend.school-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title d-flex justify-content-between align-items-center mb-4">
            <h4 class="title">{{ __('Student Details & Progress') }}</h4>
            <a href="{{ route('school.students.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left"></i> {{ __('Back to Students') }}
            </a>
        </div>

        {{-- Student Overview Card --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center mb-3 mb-md-0">
                        <div style="width: 70px; height: 70px; border-radius: 50%; background: #0ea5e9; color: white; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; margin: auto;">
                            {{ strtoupper(substr($member->user->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h5 class="mb-1">{{ $member->user->name }}</h5>
                        <p class="text-muted mb-1"><i class="fa fa-envelope"></i> {{ $member->user->email }}</p>
                        @if($member->id_number)
                            <p class="text-muted mb-0"><i class="fa fa-id-card"></i> {{ __('Roll / ID') }}: {{ $member->id_number }}</p>
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

        {{-- Assigned Courses & Learning Progress --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ __('Assigned Courses & Learning Progress') }}</h5>

                @if($assignments->isEmpty())
                    <div class="alert alert-info mb-0">
                        {{ __('No courses assigned to this student yet.') }}
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

        {{-- Quiz Attempts & Scores --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ __('Quiz Attempts & Performance') }}</h5>

                @if($quizResults->isEmpty())
                    <p class="text-muted mb-0">{{ __('No quiz attempts recorded for this student yet.') }}</p>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Quiz / Course') }}</th>
                                    <th>{{ __('Score / Grade') }}</th>
                                    <th>{{ __('Result') }}</th>
                                    <th>{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quizResults as $index => $result)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>
                                            <strong>{{ $result->quiz->title ?? __('Quiz') }}</strong>
                                            <div class="text-muted" style="font-size: 12px;">
                                                {{ $result->quiz?->chapterItem?->chapter?->course?->title ?? '' }}
                                            </div>
                                        </td>
                                        <td>{{ $result->user_grade ?? '-' }}</td>
                                        <td>
                                            @if($result->status === 'pass' || $result->result === 'pass')
                                                <span class="badge bg-success">{{ __('Passed') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('Failed') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $result->created_at->format('M d, Y') }}</td>
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
