@extends('frontend.school-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title d-flex flex-wrap justify-content-between align-items-center mb-3">
            <h4 class="title mb-0">{{ __('Assign Course') }}: {{ $course->title }}</h4>
            <a href="{{ route('school.courses.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left"></i> {{ __('Back to Courses') }}
            </a>
        </div>

        {{-- Capacity / License Overview Card --}}
        <div class="card mb-4 border-0 shadow-sm" style="background: #f8fafc; border-radius: 10px;">
            <div class="card-body">
                <div class="row align-items-center text-center text-md-start">
                    <div class="col-md-4 mb-2 mb-md-0">
                        <span class="text-muted d-block" style="font-size: 13px;">{{ __('Course License / Limit') }}</span>
                        <strong class="fs-5 text-dark">
                            @if($capacity !== null)
                                <i class="fa fa-users text-primary"></i> {{ $capacity }} {{ __('Seats') }}
                            @else
                                <i class="fa fa-infinity text-success"></i> {{ __('Unlimited Seats') }}
                            @endif
                        </strong>
                    </div>
                    <div class="col-md-4 mb-2 mb-md-0">
                        <span class="text-muted d-block" style="font-size: 13px;">{{ __('Currently Assigned') }}</span>
                        <strong class="fs-5 text-dark">
                            <i class="fa fa-user-check text-info"></i> {{ $assignedCount }} {{ __('Members') }}
                        </strong>
                    </div>
                    <div class="col-md-4">
                        <span class="text-muted d-block" style="font-size: 13px;">{{ __('Available Slots') }}</span>
                        @if($remainingSlots !== null)
                            @if($remainingSlots <= 0)
                                <span class="badge bg-danger fs-6">{{ __('0 Remaining (Full)') }}</span>
                            @else
                                <strong class="fs-5 text-success">
                                    <i class="fa fa-ticket-alt"></i> {{ $remainingSlots }} {{ __('Slots Available') }}
                                </strong>
                            @endif
                        @else
                            <strong class="fs-5 text-success">
                                <i class="fa fa-infinity"></i> {{ __('Unlimited') }}
                            </strong>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($remainingSlots !== null && $remainingSlots <= 0)
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fa fa-exclamation-triangle fs-4 me-3"></i>
                <div>
                    <strong>{{ __('Capacity Limit Reached') }}</strong><br>
                    {{ __('This course has reached its maximum capacity of') }} <strong>{{ $capacity }}</strong> {{ __('seats. To assign new members, please revoke existing assignments or purchase additional licenses.') }}
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('school.courses.store-assignment', $course->id) }}" method="POST" id="assignment-form">
                    @csrf

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="mb-0 fw-bold">{{ __('Select members to assign this course:') }}</p>
                        @if($remainingSlots !== null)
                            <span class="badge bg-light text-dark border" id="selection-counter">
                                {{ __('Selected:') }} <span id="selected-count">0</span> / {{ $remainingSlots }} {{ __('max') }}
                            </span>
                        @endif
                    </div>

                    @if($members->isEmpty())
                        <div class="alert alert-warning">
                            {{ __('No active members in your school. Please add teachers or students first.') }}
                        </div>
                    @else
                        @if($remainingSlots === null || $remainingSlots > 0)
                            <div class="mb-3">
                                <div class="form-check mb-2">
                                    <input type="checkbox" id="select-all" class="form-check-input" {{ $remainingSlots !== null && $remainingSlots <= 0 ? 'disabled' : '' }}>
                                    <label for="select-all" class="form-check-label fw-bold">{{ __('Select All (Up to capacity)') }}</label>
                                </div>
                                <hr>
                            </div>
                        @endif

                        {{-- Teachers --}}
                        @php $teachers = $members->where('role_in_school', 'teacher'); @endphp
                        @if($teachers->isNotEmpty())
                            <h6 class="mb-2 text-primary"><i class="fa fa-chalkboard-teacher"></i> {{ __('Teachers') }}</h6>
                            @foreach($teachers as $member)
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="member_ids[]" value="{{ $member->id }}"
                                           id="member-{{ $member->id }}" class="form-check-input member-checkbox"
                                           {{ in_array($member->user_id, $existingAssignments) ? 'checked disabled' : ($remainingSlots !== null && $remainingSlots <= 0 ? 'disabled' : '') }}>
                                    <label for="member-{{ $member->id }}" class="form-check-label">
                                        {{ $member->user->name }} <span class="text-muted">({{ $member->user->email }})</span>
                                        @if(in_array($member->user_id, $existingAssignments))
                                            <span class="badge bg-success ms-2">{{ __('Already assigned') }}</span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                            <hr>
                        @endif

                        {{-- Students --}}
                        @php $students = $members->where('role_in_school', 'student'); @endphp
                        @if($students->isNotEmpty())
                            <h6 class="mb-2 text-info"><i class="fa fa-user-graduate"></i> {{ __('Students') }}</h6>
                            @foreach($students as $member)
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="member_ids[]" value="{{ $member->id }}"
                                           id="member-{{ $member->id }}" class="form-check-input member-checkbox"
                                           {{ in_array($member->user_id, $existingAssignments) ? 'checked disabled' : ($remainingSlots !== null && $remainingSlots <= 0 ? 'disabled' : '') }}>
                                    <label for="member-{{ $member->id }}" class="form-check-label">
                                        {{ $member->user->name }} <span class="text-muted">({{ $member->user->email }})</span>
                                        @if(in_array($member->user_id, $existingAssignments))
                                            <span class="badge bg-success ms-2">{{ __('Already assigned') }}</span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        @endif

                        <div class="mt-4">
                            @if($remainingSlots === null || $remainingSlots > 0)
                                <button type="submit" class="btn btn-primary" id="submit-btn">{{ __('Assign Course') }}</button>
                            @else
                                <button type="button" class="btn btn-secondary" disabled>{{ __('Capacity Full') }}</button>
                            @endif
                            <a href="{{ route('school.courses.index') }}" class="btn btn-outline-secondary ms-2">{{ __('Cancel') }}</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    (function() {
        const remainingSlots = @json($remainingSlots);
        const checkboxes = document.querySelectorAll('.member-checkbox:not(:disabled)');
        const selectAll = document.getElementById('select-all');
        const selectedCountEl = document.getElementById('selected-count');

        function updateCount() {
            const count = document.querySelectorAll('.member-checkbox:not(:disabled):checked').length;
            if (selectedCountEl) {
                selectedCountEl.textContent = count;
            }
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (remainingSlots !== null) {
                    const checkedCount = document.querySelectorAll('.member-checkbox:not(:disabled):checked').length;
                    if (checkedCount > remainingSlots) {
                        this.checked = false;
                        alert('Cannot select more members. Only ' + remainingSlots + ' available seat(s) remaining for this course.');
                    }
                }
                updateCount();
            });
        });

        selectAll?.addEventListener('change', function() {
            let count = 0;
            checkboxes.forEach(cb => {
                if (this.checked) {
                    if (remainingSlots === null || count < remainingSlots) {
                        cb.checked = true;
                        count++;
                    } else {
                        cb.checked = false;
                    }
                } else {
                    cb.checked = false;
                }
            });
            if (this.checked && remainingSlots !== null && checkboxes.length > remainingSlots) {
                alert('Selected up to the available capacity limit (' + remainingSlots + ' seats).');
            }
            updateCount();
        });

        updateCount();
    })();
</script>
@endpush
@endsection
