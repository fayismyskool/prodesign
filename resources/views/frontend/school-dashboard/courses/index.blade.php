@extends('frontend.school-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Purchased Courses') }}</h4>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>{{ __('Course') }}</th>
                                <th style="width: 200px;">{{ __('License / Capacity') }}</th>
                                <th style="width: 250px;" class="text-end">{{ __('Actions') }}</th>
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
                                        <strong class="text-dark">{{ $course->title }}</strong>
                                    </td>
                                    <td>
                                        @if($cap !== null)
                                            @if($isFull)
                                                <span class="badge bg-danger text-white px-2 py-1 rounded">{{ $assigned }} / {{ $cap }} {{ __('Seats (Full)') }}</span>
                                            @else
                                                <span class="badge bg-primary text-white px-2 py-1 rounded">{{ $assigned }} / {{ $cap }} {{ __('Seats') }}</span>
                                                <small class="text-muted d-block mt-1" style="font-size: 11px;">{{ $cap - $assigned }} {{ __('remaining') }}</small>
                                            @endif
                                        @else
                                            <span class="badge bg-success text-white px-2 py-1 rounded">{{ $assigned }} / {{ __('Unlimited') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end actions-cell">
                                        <div class="d-inline-flex gap-2">
                                            <a href="{{ route('school.courses.assign', $course->id) }}" class="btn btn-sm btn-primary {{ $isFull ? 'disabled' : '' }}" title="{{ $isFull ? __('Capacity full') : __('Assign Members') }}">
                                                <i class="fa fa-user-plus"></i>
                                                <span>{{ __('Assign') }}</span>
                                            </a>
                                            <a href="{{ route('school.courses.assignments', $course->id) }}" class="btn btn-sm btn-outline-secondary" title="{{ __('View Current Assignments') }}">
                                                <i class="fa fa-eye"></i>
                                                <span>{{ __('View') }}</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <p class="text-muted mb-2">{{ __('No courses purchased yet.') }}</p>
                                        <a href="{{ route('courses') }}" class="btn btn-sm btn-primary">{{ __('Browse courses') }}</a>
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
