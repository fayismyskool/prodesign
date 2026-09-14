@if (Module::isEnabled('CourseApi') && Route::has('admin.coursesapi.index'))
    @php
        $pendingCourseCount = \App\Models\Course::where('is_approved', 'pending')
            ->whereNotNull('api_course_id')
            ->where('api_course_id', '!=', 0)
            ->where('api_course_id', '!=', '')
            ->count();
    @endphp
    <li
        class="nav-item dropdown {{ isRoute(['admin.coursesapi.*', 'admin.courseapi-category.*', 'admin.courseapi-filter.*', 'admin.courseapi-language.*', 'admin.courseapi-level.*', 'admin.courseapi-grade.*', 'admin.courseapi-review.*', 'admin.courseapi-delete-request.*', 'admin.courseapi-sub-category.*'], 'active') }}">
        <a href="javascript:void()" class="nav-link has-dropdown"><i
                class="fas fa-graduation-cap"></i><span class="{{ $pendingCourseCount > 0 ? 'beep parent' : '' }}">{{ __('Manage API Courses') }}</span></a>

        <ul class="dropdown-menu">
            <li class="{{ isRoute('admin.coursesapi.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.coursesapi.index') }}">
                    {{ __('Courses') }}
                    @if ($pendingCourseCount > 0)
                    <small class="badge badge-danger ml-2">{{ $pendingCourseCount }}</small>
                    @endif
                </a>
            </li>
            <li class="{{ isRoute('admin.courseapi-category.*', 'active') }} {{ isRoute('admin.courseapi-sub-category.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.courseapi-category.index') }}">
                    {{ __('Categories') }}
                </a>
            </li>

            <li class="{{ isRoute('admin.courseapi-language.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.courseapi-language.index') }}">
                    {{ __('languages') }}
                </a>
            </li>

            <li class="{{ isRoute('admin.courseapi-level.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.courseapi-level.index') }}">
                    {{ __('levels') }}
                </a>
            </li>

            <li class="{{ isRoute('admin.courseapi-grade.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.courseapi-grade.index') }}">
                    {{ __('Grades') }}
                </a>
            </li>

            <li class="{{ isRoute('admin.courseapi-review.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.courseapi-review.index') }}">
                    {{ __('Course Reviews') }}
                </a>
            </li>
            <li class="{{ isRoute('admin.courseapi-delete-request.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.courseapi-delete-request.index') }}">
                    {{ __('Course Delete Requests') }}
                </a>
            </li>
        </ul>
    </li>
@endif
