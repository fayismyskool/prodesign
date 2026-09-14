@extends('admin.master_layout')
@section('title')
    <title>{{ __('Add Instructor Request') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.instructor-request.index') }}" class="btn btn-icon"><i
                            class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Add Instructor Request') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.instructor-request.index') }}">{{ __('Instructor Request') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Add New') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Manual Add Instructor / Request') }}</h4>
                                <div>
                                    <a href="{{ route('admin.instructor-request.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.instructor-request.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    {{-- Choose User Source --}}
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="d-block font-weight-bold">{{ __('User Type') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="user_type"
                                                        id="user_type_existing" value="existing"
                                                        {{ old('user_type', 'existing') == 'existing' ? 'checked' : '' }}
                                                        onchange="toggleUserType()">
                                                    <label class="form-check-label" for="user_type_existing">
                                                        <i class="fas fa-user-check text-primary mr-1"></i> {{ __('Select Existing User') }}
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline ml-4">
                                                    <input class="form-check-input" type="radio" name="user_type"
                                                        id="user_type_new" value="new"
                                                        {{ old('user_type') == 'new' ? 'checked' : '' }}
                                                        onchange="toggleUserType()">
                                                    <label class="form-check-label" for="user_type_new">
                                                        <i class="fas fa-user-plus text-success mr-1"></i> {{ __('Create Brand New User') }}
                                                    </label>
                                                </div>
                                                @error('user_type')
                                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    {{-- Existing User Selection --}}
                                    <div id="existing_user_section" class="row">
                                        <div class="form-group col-md-12">
                                            <label>{{ __('Select User') }} <span class="text-danger">*</span></label>
                                            <select name="user_id" id="user_id"
                                                class="form-control select2 @error('user_id') is-invalid @enderror"
                                                style="width: 100%;">
                                                <option value="">{{ __('-- Select User --') }}</option>
                                                @foreach ($users as $u)
                                                    <option value="{{ $u->id }}"
                                                        {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                                        {{ $u->name }} ({{ $u->email }}) [Role: {{ ucfirst($u->role) }}]
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- New User Inputs --}}
                                    <div id="new_user_section" class="row d-none">
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" placeholder="{{ __('Enter full name') }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" placeholder="{{ __('Enter email') }}">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Mobile Number (with country code)') }}</label>
                                            <input type="text" name="phone" id="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}" placeholder="{{ __('e.g. 919876543210') }}">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Password') }} <span class="text-danger">*</span></label>
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="{{ __('Enter initial password') }}">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr>

                                    {{-- Request Details --}}
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Request Status') }} <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="approved" {{ old('status', 'approved') == 'approved' ? 'selected' : '' }}>
                                                    {{ __('Approved (Directly convert/grant Instructor role)') }}
                                                </option>
                                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                                    {{ __('Pending (Under Review)') }}
                                                </option>
                                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>
                                                    {{ __('Rejected') }}
                                                </option>
                                            </select>
                                            <small class="form-text text-muted">
                                                {{ __('If set to Approved, the user role will be updated to instructor immediately.') }}
                                            </small>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Payout Account / Method') }}</label>
                                            @if(!empty($withdrawMethods) && count($withdrawMethods) > 0)
                                                <select name="payout_account" class="form-control">
                                                    <option value="">{{ __('-- Select Payout Method (Optional) --') }}</option>
                                                    @foreach($withdrawMethods as $method)
                                                        <option value="{{ $method->name }}" {{ old('payout_account') == $method->name ? 'selected' : '' }}>
                                                            {{ $method->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" name="payout_account" class="form-control"
                                                    value="{{ old('payout_account') }}"
                                                    placeholder="{{ __('e.g. Bank Transfer, PayPal, UPI') }}">
                                            @endif
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('Payout Details / Information') }}</label>
                                            <textarea name="payout_information" class="form-control" rows="3"
                                                placeholder="{{ __('Bank Account Details, UPI ID, or PayPal Email') }}">{{ old('payout_information') }}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Certificate / Resume / Document') }}</label>
                                            <input type="file" name="certificate" class="form-control">
                                            <small class="form-text text-muted">{{ __('Allowed: pdf, jpg, png, doc, zip (Max 10MB)') }}</small>
                                            @error('certificate')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Identity Scan / ID Proof') }}</label>
                                            <input type="file" name="identity_scan" class="form-control">
                                            <small class="form-text text-muted">{{ __('Allowed: pdf, jpg, png, doc, zip (Max 10MB)') }}</small>
                                            @error('identity_scan')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('Extra Information / Admin Notes') }}</label>
                                            <textarea name="extra_information" class="form-control" rows="3"
                                                placeholder="{{ __('Any extra details, qualifications or notes') }}">{{ old('extra_information') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12 text-center">
                                            <x-admin.save-button :text="__('Save Instructor Request')"></x-admin.save-button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('js')
        <script>
            "use strict";

            function toggleUserType() {
                var userType = $('input[name="user_type"]:checked').val();
                if (userType === 'new') {
                    $('#existing_user_section').addClass('d-none');
                    $('#new_user_section').removeClass('d-none');
                } else {
                    $('#existing_user_section').removeClass('d-none');
                    $('#new_user_section').addClass('d-none');
                }
            }

            $(document).ready(function() {
                toggleUserType();
            });
        </script>
    @endpush
@endsection
