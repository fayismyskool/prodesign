@extends('frontend.layouts.master')
@section('meta_title', 'Register'. ' || ' . $setting->app_name)

@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('Register')" :links="[['url' => route('home'), 'text' => __('Home')], ['url' => route('register'), 'text' => __('Register')]]" />
    <!-- breadcrumb-area-end -->

    <!-- singUp-area -->
    <section class="singUp-area section-py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="singUp-wrap">
                        <h2 class="title">{{ __('Create Your Account') }}</h2>
                        <p>{{ __('Hey there! Ready to join the party? We just need a few details from you to get') }}<br>{{ __('started Lets do this!') }}
                        </p>
                        @if($setting->google_login_status == 'active')
                        <div class="account__social">
                            <a href="{{ route('auth.social', 'google') }}" class="account__social-btn">
                                <img src="{{ asset('frontend/img/icons/google.svg') }}" alt="img">
                                {{ __('Continue with google') }}
                            </a>
                        </div>
                        <div class="account__divider">
                            <span>{{ __('or') }}</span>
                        </div>
                        @endif
                        <form method="POST" action="{{ route('register') }}" class="account__form">
                            @csrf

                            {{-- Account Type Selector --}}
                            <div class="form-grp">
                                <label>{{ __('Account Type') }}</label>
                                <div class="d-flex gap-3 mt-2">
                                    <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                                        <input type="radio" name="account_type" value="student" id="type-student" checked>
                                        <span>{{ __('Student') }}</span>
                                    </label>
                                    <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                                        <input type="radio" name="account_type" value="school" id="type-school"
                                            {{ old('account_type') === 'school' ? 'checked' : '' }}>
                                        <span>{{ __('School / Institution') }}</span>
                                    </label>
                                </div>
                                <x-frontend.validation-error name="account_type" />
                            </div>

                            {{-- School-specific fields (hidden by default) --}}
                            <div id="school-fields" style="display: {{ old('account_type') === 'school' ? 'block' : 'none' }};">
                                <div class="form-grp">
                                    <label for="school_name">{{ __('School / Institution Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="school_name" name="school_name" value="{{ old('school_name') }}"
                                           placeholder="{{ __('e.g. Springfield Academy') }}">
                                    <x-frontend.validation-error name="school_name" />
                                </div>
                                <div class="row gutter-20">
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <label for="registration_number">{{ __('Registration Number') }}</label>
                                            <input type="text" id="registration_number" name="registration_number"
                                                   value="{{ old('registration_number') }}" placeholder="{{ __('Optional') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <label for="contact_person">{{ __('Contact Person') }}</label>
                                            <input type="text" id="contact_person" name="contact_person"
                                                   value="{{ old('contact_person') }}" placeholder="{{ __('Principal / Admin name') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row gutter-20">
                                <div class="col-md-12">
                                    <div class="form-grp">
                                        <label for="fast-name">{{ __('Full Name') }}</label>
                                        <input type="text" id="fast-name" placeholder="{{ __('full name') }}"
                                            name="name">
                                        <x-frontend.validation-error name="name" />
                                    </div>
                                </div>
                            </div>
                            
<!--                            <div class="form-grp">
                                <label for="mobile">{{ __('Mobile Number') }}</label>
                                <input type="tel" id="mobile" placeholder="{{ __('mobile') }}" name="mobile"
                                       pattern="^\+?[1-9]\d{1,14}$" required>
                                <small class="form-text text-muted">
                                    {{ __('Please enter a valid mobile number (e.g., +1234567890).') }}
                                </small>
                                <x-frontend.validation-error name="mobile" />
                            </div>-->
                            
                            <div class="form-grp">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" id="email" placeholder="{{ __('email') }}" name="email">
                                <x-frontend.validation-error name="email" />
                            </div>
                            <div class="form-grp">
                                <label for="password">{{ __('Password') }}</label>
                                <input type="password" id="password" placeholder="{{ __('password') }}" name="password">
                                <x-frontend.validation-error name="password" />
                            </div>
                            <div class="form-grp">
                                <label for="confirm-password">{{ __('Confirm Password') }}</label>
                                <input type="password" id="confirm-password" placeholder="{{ __('Confirm Password') }}"
                                    name="password_confirmation">
                                <x-frontend.validation-error name="password_confirmation" />
                            </div>

                            <!-- g-recaptcha -->
                            @if (Cache::get('setting')->recaptcha_status === 'active')
                                <div class="form-grp mt-3">
                                    <div class="g-recaptcha"
                                        data-sitekey="{{ Cache::get('setting')->recaptcha_site_key }}"></div>
                                    <x-frontend.validation-error name="g-recaptcha-response" />
                                </div>
                            @endif

                            <button type="submit" class="btn btn-two arrow-btn">{{ __('Sign Up') }}<img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img"
                                    class="injectable"></button>
                        </form>
                        <div class="account__switch">
                            <p>{{ __('Already have an account?') }}<a href="{{ route('login') }}">{{ __('Login') }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- singUp-area-end -->

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const schoolFields = document.getElementById('school-fields');
        const radios = document.querySelectorAll('input[name="account_type"]');
        radios.forEach(function(radio) {
            radio.addEventListener('change', function() {
                schoolFields.style.display = this.value === 'school' ? 'block' : 'none';
            });
        });
    });
</script>
@endpush
@endsection
