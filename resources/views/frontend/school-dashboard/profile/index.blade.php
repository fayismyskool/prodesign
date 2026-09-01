@extends('frontend.school-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Profile Settings') }}</h4>
        </div>

        {{-- Profile Info --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ __('School Information') }}</h5>
                <form action="{{ route('school.profile.update') }}" method="POST" enctype="multipart/form-data" class="account__form">
                    @csrf @method('PUT')
                    <div class="row gutter-20">
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label for="name">{{ __('Account Name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', userAuth()->name) }}" required>
                                <x-frontend.validation-error name="name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label for="school_name">{{ __('School / Institution Name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="school_name" name="school_name" value="{{ old('school_name', userAuth()->school_name) }}" required>
                                <x-frontend.validation-error name="school_name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label for="contact_person">{{ __('Contact Person') }}</label>
                                <input type="text" id="contact_person" name="contact_person" value="{{ old('contact_person', userAuth()->contact_person) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label for="registration_number">{{ __('Registration Number') }}</label>
                                <input type="text" id="registration_number" name="registration_number" value="{{ old('registration_number', userAuth()->registration_number) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', userAuth()->phone) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label for="address">{{ __('Address') }}</label>
                                <input type="text" id="address" name="address" value="{{ old('address', userAuth()->address) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label for="image">{{ __('Logo / Profile Image') }}</label>
                                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">{{ __('Update Profile') }}</button>
                </form>
            </div>
        </div>

        {{-- Password Change --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ __('Change Password') }}</h5>
                <form action="{{ route('school.profile.update-password') }}" method="POST" class="account__form">
                    @csrf @method('PUT')
                    <div class="row gutter-20">
                        <div class="col-md-4">
                            <div class="form-grp">
                                <label for="current_password">{{ __('Current Password') }} <span class="text-danger">*</span></label>
                                <input type="password" id="current_password" name="current_password" required>
                                <x-frontend.validation-error name="current_password" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-grp">
                                <label for="new_password">{{ __('New Password') }} <span class="text-danger">*</span></label>
                                <input type="password" id="new_password" name="password" required>
                                <x-frontend.validation-error name="password" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-grp">
                                <label for="password_confirmation">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">{{ __('Update Password') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
