@extends('frontend.layouts.master')
@section('meta_title', 'Order Fail'. ' || ' . $setting->app_name)

@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('Order Failed')" :links="[
        ['url' => route('home'), 'text' => __('Home')],
        ['url' => route('checkout.index'), 'text' => __('Order Failed')],
    ]" />
    <!-- breadcrumb-area-end -->

    <!-- checkout-area -->
    <div class="checkout__area section-py-120">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <img src="{{ asset('uploads/website-images/faild.png') }}" alt="">
                    <h6 class="mt-2">{{ __('Your order has been failed') }}</h6>
                    <p>{{ __('For check more details you can go to your dashboard') }}</p>
                    @php
                        $dashboardUrl = match(userAuth()?->role) {
                            'school'     => route('school.dashboard'),
                            'instructor' => route('instructor.dashboard'),
                            default      => route('student.dashboard'),
                        };
                    @endphp
                    <a href="{{ $dashboardUrl }}" class="btn btn-primary">{{ __('Go to Dashboard') }}</a>
                </div>     
            </div>
        </div>
    </div>
@endsection
@if (session('enrollFailed') && $setting->google_tagmanager_status == 'active' && $marketing_setting?->order_failed)
    @php
        $enrollFailed = session('enrollFailed');
        session()->forget('enrollFailed');
    @endphp
    @push('scripts')
        <script>
            $(function() {
                dataLayer.push({
                    'event': 'enrollFailed',
                    'order_details': @json($enrollFailed)
                });
            });
        </script>
    @endpush
@endif
