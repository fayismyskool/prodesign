@extends('frontend.school-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Add Student') }}</h4>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('school.students.store') }}" method="POST" class="account__form">
                    @csrf
                    <div class="row gutter-20">
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label for="name">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('Student full name') }}" required>
                                <x-frontend.validation-error name="name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label for="email">{{ __('Email') }} <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('student@example.com') }}" required>
                                <x-frontend.validation-error name="email" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label for="password">{{ __('Password') }} <small class="text-muted">({{ __('Default: 123456') }})</small></label>
                                <input type="text" id="password" name="password" value="{{ old('password') }}" placeholder="{{ __('Enter password (min 4 chars) or leave blank for 123456') }}">
                                <x-frontend.validation-error name="password" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label for="id_number">{{ __('Roll Number / ID') }}</label>
                                <input type="text" id="id_number" name="id_number" value="{{ old('id_number') }}" placeholder="{{ __('Optional') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">{{ __('Add Student') }}</button>
                        <a href="{{ route('school.students.index') }}" class="btn btn-outline-secondary ms-2">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
