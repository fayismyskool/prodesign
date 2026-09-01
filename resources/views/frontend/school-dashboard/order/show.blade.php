@extends('frontend.school-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title d-flex justify-content-between align-items-center mb-3">
            <h4 class="title">{{ __('Order Details') }}</h4>
            <a href="{{ route('school.orders.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left"></i> {{ __('Back to Orders') }}
            </a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row">
                                <div class="col-lg-12 info-wrapper">
                                    <div class="row w-100">
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="invoice-title">
                                                <h2>{{ __('Invoice') }}</h2>
                                                <div class="invoice-number">{{ __('Order ') }} #{{ $order->invoice_id }}</div>
                                                <address>
                                                    <strong>{{ __('Order Date') }}:</strong><br>
                                                    {{ formatDate($order->created_at) }}<br><br>
                                                </address>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <address>
                                                <strong>{{ __('Billed To') }}:</strong><br>
                                                {{ $order->user->school_name ?? $order->user->name }}<br>
                                                @if($order->user->contact_person)
                                                    {{ __('Attn:') }} {{ $order->user->contact_person }}<br>
                                                @endif
                                                {{ __('Phone:') }} {{ $order->user->phone }}<br>
                                                {{ __('Email:') }} {{ $order->user->email }}<br>
                                                {{ __('Address:') }} {{ $order->user->address }}<br>
                                            </address>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <address>
                                                <strong>{{ __('Payment Method') }}:</strong><br>
                                                {{ $order->payment_method }}<br>
                                            </address>
                                            <address>
                                                <strong>{{ __('Payment Status') }}:</strong><br>
                                                {{ ucfirst($order->payment_status) }}<br><br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="section-title fw-bold mb-2">{{ __('Order Summary') }}</div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-md">
                                            <thead>
                                                <tr>
                                                    <th data-width="40">#</th>
                                                    <th>{{ __('Course') }}</th>
                                                    <th>{{ __('Instructor') }}</th>
                                                    <th class="text-center">{{ __('Price') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderItems as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><strong>{{ $item->course->title }}</strong></td>
                                                        <td>
                                                            {{ $item->course->instructor->name }}
                                                            <br>
                                                            <small class="text-muted">{{ $item->course->instructor->email }}</small>
                                                        </td>
                                                        <td class="text-center">{{ $item->price * $order->conversion_rate }} {{ $order->payable_currency }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-4"></div>
                                        @php
                                            $subTotal = 0;
                                            $discount = 0;
                                            $gatewayCharge = 0;
                                            foreach ($order->orderItems as $item) {
                                                $subTotal += $item->price;
                                            }
                                            if ($order->coupon_discount_amount > 0) {
                                                $discount = $order->coupon_discount_amount;
                                            }
                                            if ($order->gateway_charge > 0) {
                                                $gatewayCharge = ($order->gateway_charge / max(($subTotal - $discount), 1)) * 100;
                                            }
                                            $total = ($subTotal - $discount + $order->gateway_charge) * $order->conversion_rate;
                                        @endphp

                                        <div class="col-lg-8 text-end">
                                            <div class="invoice-detail-item mb-1">
                                                <span class="invoice-detail-name">{{ __('Subtotal') }}: </span>
                                                <span class="invoice-detail-value">{{ number_format($subTotal * $order->conversion_rate, 2) }} {{ $order->payable_currency }}</span>
                                            </div>

                                            @if($discount > 0)
                                                <div class="invoice-detail-item mb-1 text-success">
                                                    <span class="invoice-detail-name">{{ __('Discount') }}: </span>
                                                    <span class="invoice-detail-value">-{{ number_format($discount * $order->conversion_rate, 2) }} {{ $order->payable_currency }}</span>
                                                </div>
                                            @endif

                                            @if($order->gateway_charge > 0)
                                                <div class="invoice-detail-item mb-1">
                                                    <span class="invoice-detail-name">{{ __('Gateway Charge') }} ({{ number_format($gatewayCharge) }}%): </span>
                                                    <span class="invoice-detail-value">{{ number_format($order->gateway_charge * $order->conversion_rate, 2) }} {{ $order->payable_currency }}</span>
                                                </div>
                                            @endif

                                            <hr class="mt-2 mb-2">
                                            <div class="invoice-detail-item fs-5 fw-bold">
                                                <span class="invoice-detail-name">{{ __('Total') }}: </span>
                                                <span class="invoice-detail-value">{{ number_format($total, 2) }} {{ $order->payable_currency }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('school.courses.index') }}" class="btn btn-primary">
                                <i class="fa fa-book"></i> {{ __('Assign Purchased Courses') }}
                            </a>
                            <a target="_blank" href="{{ route('school.orders.print-invoice', $order->id) }}" class="btn btn-warning print-btn">
                                <i class="fa fa-print"></i> {{ __('Print Invoice') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
