@extends('frontend.school-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title d-flex justify-content-between align-items-center">
            <h4 class="title">{{ __('Assignments for') }}: {{ $course->title }}</h4>
            <a href="{{ route('school.courses.assign', $course->id) }}" class="btn btn-sm btn-primary">
                <i class="fa fa-user-plus"></i> {{ __('Assign More') }}
            </a>
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
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Course Progress') }}</th>
                                <th>{{ __('Assigned On') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignments as $index => $assignment)
                                <tr>
                                    <td>{{ $assignments->firstItem() + $index }}</td>
                                    <td>{{ $assignment->user->name }}</td>
                                    <td>{{ $assignment->user->email }}</td>
                                    <td><span class="badge bg-{{ $assignment->role_in_school === 'teacher' ? 'primary' : 'info' }}">{{ ucfirst($assignment->role_in_school) }}</span></td>
                                    <td>
                                        <div style="min-width: 140px;">
                                            <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                                <span>{{ $assignment->progress_percent ?? 0 }}%</span>
                                                <span class="text-muted">{{ $assignment->watched_lectures ?? 0 }}/{{ $assignment->total_lectures ?? 0 }} lessons</span>
                                            </div>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width: {{ $assignment->progress_percent ?? 0 }}%"
                                                     aria-valuenow="{{ $assignment->progress_percent ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
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
                                        @if($assignment->status === 'active')
                                            <form action="{{ route('school.courses.revoke-assignment', $assignment->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('{{ __('This will revoke course access for this member. Continue?') }}')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa fa-times"></i> {{ __('Revoke') }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('No assignments yet.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $assignments->links() }}
            </div>
        </div>
    </div>
@endsection
