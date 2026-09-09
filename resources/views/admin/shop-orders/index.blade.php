@extends('admin.master_layout')
@section('title')
    <title>{{ $title }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    {{-- Search filter --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.shop-orders.index') }}" method="GET" onchange="$(this).trigger('submit')"
                                    class="form_padding">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <input type="text" name="keyword" value="{{ request()->get('keyword') }}"
                                                class="form-control" placeholder="{{ __('Search by Order ID, Name, Phone, Pincode...') }}">
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <select name="order_status" class="form-control">
                                                <option value="">{{ __('Order status') }}</option>
                                                <option value="pending"
                                                    {{ request('order_status') == 'pending' ? 'selected' : '' }}>
                                                    {{ __('Pending') }}
                                                </option>
                                                <option value="processing"
                                                    {{ request('order_status') == 'processing' ? 'selected' : '' }}>
                                                    {{ __('Processing') }}
                                                </option>
                                                <option value="shipped"
                                                    {{ request('order_status') == 'shipped' ? 'selected' : '' }}>
                                                    {{ __('Shipped') }}
                                                </option>
                                                <option value="delivered"
                                                    {{ request('order_status') == 'delivered' ? 'selected' : '' }}>
                                                    {{ __('Delivered') }}
                                                </option>
                                                <option value="cancelled"
                                                    {{ request('order_status') == 'cancelled' ? 'selected' : '' }}>
                                                    {{ __('Cancelled') }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <select name="payment_status" id="status" class="form-control">
                                                <option value="">{{ __('Payment Status') }}</option>
                                                <option value="pending"
                                                    {{ request('payment_status') == 'pending' ? 'selected' : '' }}>
                                                    {{ __('Pending') }}
                                                </option>
                                                <option value="paid"
                                                    {{ request('payment_status') == 'paid' ? 'selected' : '' }}>
                                                    {{ __('Paid') }}
                                                </option>
                                                <option value="failed"
                                                    {{ request('payment_status') == 'failed' ? 'selected' : '' }}>
                                                    {{ __('Failed') }}
                                                </option>
                                                <option value="refunded"
                                                    {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>
                                                    {{ __('Refunded') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group">
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
                                        <div class="col-md-2 form-group">
                                            <select name="par-page" id="par-page" class="form-control">
                                                <option value="">{{ __('Per Page') }}</option>
                                                <option value="10" {{ '10' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('10') }}
                                                </option>
                                                <option value="25" {{ '25' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('25') }}
                                                </option>
                                                <option value="50" {{ '50' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('50') }}
                                                </option>
                                                <option value="100"
                                                    {{ '100' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('100') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>{{ __('SN') }}</th>
                                            <th>{{ __('Customer') }}</th>
                                            <th>{{ __('Order Id') }}</th>
                                            <th>{{ __('Items') }}</th>
                                            <th>{{ __('Paid Amount') }}</th>
                                            <th>{{ __('Gateway') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Payment') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>

                                        @forelse ($orders as $index => $order)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td>
                                                    <span class="font-weight-600 text-dark">{{ $order->customer_name }}</span>
                                                    <br>
                                                    <small class="text-muted">{{ $order->customer_phone }}</small>
                                                </td>
                                                <td>#{{ $order->order_number }}</td>
                                                <td>
                                                    <span class="badge badge-light border">
                                                        {{ $order->items->sum('quantity') }} {{ __('item(s)') }}
                                                    </span>
                                                </td>
                                                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    {{ strtoupper($order->payment_method ?? 'Razorpay') }}
                                                </td>
                                                <td>
                                                    @if ($order->order_status == 'delivered')
                                                        <div class="badge badge-success">{{ __('Delivered') }}</div>
                                                    @elseif($order->order_status == 'shipped')
                                                        <div class="badge badge-info">{{ __('Shipped') }}</div>
                                                    @elseif($order->order_status == 'processing')
                                                        <div class="badge badge-primary">{{ __('Processing') }}</div>
                                                    @elseif($order->order_status == 'cancelled')
                                                        <div class="badge badge-danger">{{ __('Cancelled') }}</div>
                                                    @else
                                                        <div class="badge badge-warning">{{ __('Pending') }}</div>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($order->payment_status == 'paid')
                                                        <div class="badge badge-success">{{ __('Paid') }}</div>
                                                    @elseif ($order->payment_status == 'refunded')
                                                        <div class="badge badge-dark">{{ __('Refunded') }}</div>
                                                    @elseif ($order->payment_status == 'failed')
                                                        <div class="badge badge-danger">{{ __('Failed') }}</div>
                                                    @else
                                                        <div class="badge badge-danger">{{ __('Pending') }}</div>
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{ route('admin.shop-orders.show', $order->id) }}"
                                                        class="btn btn-primary btn-sm" title="{{ __('View Details') }}"><i class="fa fa-eye"></i></a>

                                                    <a target="_blank" href="{{ route('admin.shop-orders.invoice', $order->id) }}"
                                                        class="btn btn-warning btn-sm" title="{{ __('Print Invoice') }}"><i class="fa fa-print"></i></a>

                                                    <a href="javascript:;" data-toggle="modal" data-target="#deleteModal"
                                                        class="btn btn-danger btn-sm" title="{{ __('Delete') }}"
                                                        onclick="deleteData({{ $order->id }})"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <x-empty-table :name="__('Shop Orders')" route="" create="no" :message="__('No shop orders found!')"
                                                colspan="9"></x-empty-table>
                                        @endforelse
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    {{ $orders->links() }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <x-admin.delete-modal />

    <script>
        'use strict'

        function deleteData(id) {
            $("#deleteForm").attr("action", "{{ url('admin/shop-order-delete/') }}" + "/" + id)
        }
    </script>
@endsection
