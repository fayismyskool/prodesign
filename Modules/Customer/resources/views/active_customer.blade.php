@extends('admin.master_layout')
@section('title')
    <title>{{ __('Active Users') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Active Users') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.active-customers') }}">{{ __('Manage Users') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Active Users') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    {{-- Search / Filter Bar --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.active-customers') }}" method="GET"
                                    onchange="$(this).trigger('submit')" class="form_padding">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label class="font-weight-bold">{{ __('Filter by Role') }}</label>
                                            <select name="role" id="role" class="form-control">
                                                <option value="school" {{ ($selectedRole ?? 'school') == 'school' ? 'selected' : '' }}>
                                                    {{ __('Schools (Default)') }}
                                                </option>
                                                <option value="all" {{ ($selectedRole ?? '') == 'all' ? 'selected' : '' }}>
                                                    {{ __('All Active Roles') }}
                                                </option>
                                                <option value="teacher" {{ ($selectedRole ?? '') == 'teacher' ? 'selected' : '' }}>
                                                    {{ __('Teachers') }}
                                                </option>
                                                <option value="instructor" {{ ($selectedRole ?? '') == 'instructor' ? 'selected' : '' }}>
                                                    {{ __('Instructors') }}
                                                </option>
                                                <option value="student" {{ ($selectedRole ?? '') == 'student' ? 'selected' : '' }}>
                                                    {{ __('Students') }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label class="font-weight-bold">{{ __('Search Keyword') }}</label>
                                            <input type="text" name="keyword" value="{{ request()->get('keyword') }}"
                                                class="form-control" placeholder="{{ __('Search name, email, phone, school…') }}">
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label class="font-weight-bold">{{ __('Order By') }}</label>
                                            <select name="order_by" id="order_by" class="form-control">
                                                <option value="">{{ __('Order By') }}</option>
                                                <option value="1" {{ request('order_by') == '1' ? 'selected' : '' }}>
                                                    {{ __('ASC') }}
                                                </option>
                                                <option value="0" {{ request('order_by') == '0' ? 'selected' : '' }}>
                                                    {{ __('DESC') }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label class="font-weight-bold">{{ __('Per Page') }}</label>
                                            <select name="par-page" id="par-page" class="form-control">
                                                <option value="">{{ __('Per Page') }}</option>
                                                <option value="10" {{ '10' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('10') }}
                                                </option>
                                                <option value="50" {{ '50' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('50') }}
                                                </option>
                                                <option value="100"
                                                    {{ '100' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('100') }}
                                                </option>
                                                <option value="all"
                                                    {{ 'all' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('All') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>
                                    @if (($selectedRole ?? 'school') == 'school')
                                        {{ __('Active Schools') }}
                                    @elseif (($selectedRole ?? '') == 'teacher')
                                        {{ __('Active Teachers') }}
                                    @elseif (($selectedRole ?? '') == 'instructor')
                                        {{ __('Active Instructors') }}
                                    @elseif (($selectedRole ?? '') == 'student')
                                        {{ __('Active Students') }}
                                    @else
                                        {{ __('All Active Users') }}
                                    @endif
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('SN') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('School / Organization') }}</th>
                                                <th>{{ __('Email & Phone') }}</th>
                                                <th>{{ __('Role') }}</th>
                                                <th>{{ __('Joined at') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($users as $index => $user)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>
                                                        <strong>{{ html_decode($user->name) }}</strong>
                                                        @if($user->contact_person && $user->role == 'school')
                                                            <div class="text-muted small">{{ __('Contact') }}: {{ html_decode($user->contact_person) }}</div>
                                                        @endif
                                                    </td>
                                                    <td>{{ html_decode($user->school_name) ?: '—' }}</td>
                                                    <td>
                                                        <div><i class="fas fa-envelope mr-1 text-muted"></i> {{ html_decode($user->email) }}</div>
                                                        @if($user->phone)
                                                            <div class="text-muted small"><i class="fas fa-phone-alt mr-1 text-muted"></i> {{ html_decode($user->phone) }}</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($user->role == 'school')
                                                            <span class="badge badge-primary">{{ __('School') }}</span>
                                                        @elseif ($user->role == 'teacher')
                                                            <span class="badge badge-info">{{ __('Teacher') }}</span>
                                                        @elseif ($user->role == 'instructor')
                                                            <span class="badge badge-warning">{{ __('Instructor') }}</span>
                                                        @elseif ($user->role == 'student')
                                                            <span class="badge badge-secondary">{{ __('Student') }}</span>
                                                        @else
                                                            <span class="badge badge-dark">{{ ucfirst($user->role) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $user->created_at->format('h:iA, d M Y') }}</td>
                                                    <td>
                                                        @if ($user->status == 'active' && $user->is_banned == 'no')
                                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('Inactive / Banned') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.customer-show', $user->id) }}"
                                                            class="btn btn-success btn-sm" title="{{ __('View Details') }}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        <a onclick="deleteData({{ $user->id }})" href="javascript:;"
                                                            data-toggle="modal" data-target="#deleteModal"
                                                            class="btn btn-danger btn-sm" title="{{ __('Delete') }}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Active Users')" route="" create="no"
                                                    :message="__('No active users found!')" colspan="8"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if (request()->get('par-page') !== 'all')
                                    <div class="float-right">
                                        {{ $users->onEachSide(0)->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <x-admin.delete-modal />
    @push('js')
        <script>
            "use strict";
            function deleteData(id) {
                $("#deleteForm").attr("action", '{{ url('/admin/customer-delete/') }}' + "/" + id)
            }
        </script>
    @endpush
@endsection
