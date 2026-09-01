@extends('frontend.school-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Purchased Courses') }}</h4>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Course') }}</th>
                                <th>{{ __('License / Capacity') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $index => $course)
                                @php
                                    $assigned = $assignmentCounts[$course->id] ?? 0;
                                    $cap = $course->capacity > 0 ? (int)$course->capacity : null;
                                    $isFull = $cap !== null && $assigned >= $cap;
                                @endphp
                                <tr>
                                    <td>{{ $courses->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $course->title }}</strong>
                                    </td>
                                    <td>
                                        @if($cap !== null)
                                            @if($isFull)
                                                <span class="badge bg-danger">{{ $assigned }} / {{ $cap }} {{ __('Seats (Full)') }}</span>
                                            @else
                                                <span class="badge bg-primary">{{ $assigned }} / {{ $cap }} {{ __('Seats') }}</span>
                                                <small class="text-muted d-block" style="font-size: 11px;">{{ $cap - $assigned }} {{ __('remaining') }}</small>
                                            @endif
                                        @else
                                            <span class="badge bg-success">{{ $assigned }} / {{ __('Unlimited') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('school.courses.assign', $course->id) }}" class="btn btn-sm btn-primary {{ $isFull ? 'disabled' : '' }}" title="{{ $isFull ? __('Capacity full') : __('Assign Members') }}">
                                            <i class="fa fa-user-plus"></i> {{ __('Assign') }}
                                        </a>
                                        <a href="{{ route('school.courses.assignments', $course->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fa fa-eye"></i> {{ __('View Assignments') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        {{ __('No courses purchased yet.') }}
                                        <a href="{{ route('courses') }}">{{ __('Browse courses') }}</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $courses->links() }}
            </div>
        </div>
    </div>
@endsection
