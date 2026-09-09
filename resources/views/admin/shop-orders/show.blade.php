@extends('admin.master_layout')
@section('title')
    <title>{{ $title ?? __('Shop Order Details') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Shop Order Details') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.shop-orders.index') }}">{{ __('Shop Orders') }}</a></div>
                    <div class="breadcrumb-item">#{{ $order->order_number }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="invoice-title d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <h2 class="mb-1 text-primary">{{ __('Shop Order') }} #{{ $order->order_number }}</h2>
                                        <div class="text-muted small">{{ __('Placed on') }}: <strong>{{ $order->created_at->format('d M Y, h:i A') }}</strong></div>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $orderBadgeClass = match($order->order_status) {
                                                'delivered' => 'badge-success',
                                                'shipped' => 'badge-info',
                                                'processing' => 'badge-primary',
                                                'cancelled' => 'badge-danger',
                                                default => 'badge-warning',
                                            };
                                            $paymentBadgeClass = match($order->payment_status) {
                                                'paid' => 'badge-success',
                                                'failed' => 'badge-danger',
                                                'refunded' => 'badge-dark',
                                                default => 'badge-warning',
                                            };
                                        @endphp
                                        <span class="badge {{ $orderBadgeClass }} p-2 mr-2 text-uppercase font-weight-bold">{{ ucfirst($order->order_status) }}</span>
                                        <span class="badge {{ $paymentBadgeClass }} p-2 text-uppercase font-weight-bold">{{ __('Payment') }}: {{ ucfirst($order->payment_status) }}</span>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card card-primary shadow-none border">
                                            <div class="card-header py-2" style="background:#f8f9fa;">
                                                <h6 class="mb-0 text-dark"><i class="fas fa-user mr-2 text-primary"></i>{{ __('Customer Details') }}</h6>
                                            </div>
                                            <div class="card-body py-3">
                                                <p class="mb-1"><strong>{{ __('Name') }}:</strong> {{ $order->customer_name }}</p>
                                                <p class="mb-1"><strong>{{ __('Phone') }}:</strong> <a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a></p>
                                                <p class="mb-1"><strong>{{ __('Email') }}:</strong> {{ $order->customer_email ?? '-' }}</p>
                                                @if($order->user)
                                                    <p class="mb-0 text-muted small"><i class="fas fa-link mr-1"></i>{{ __('Registered Account') }}: {{ $order->user->name }} (ID #{{ $order->user->id }})</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card card-primary shadow-none border">
                                            <div class="card-header py-2" style="background:#f8f9fa;">
                                                <h6 class="mb-0 text-dark"><i class="fas fa-map-marker-alt mr-2 text-danger"></i>{{ __('Shipping / Delivery Address') }}</h6>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="mb-1"><span class="badge badge-light border">{{ $order->address_type ?? 'Home' }}</span></div>
                                                <p class="mb-1 font-weight-500">{{ $order->address }}</p>
                                                <p class="mb-0 text-muted">
                                                    {{ $order->city }}, {{ $order->state }} - <strong>{{ $order->pincode }}</strong><br>
                                                    {{ $order->country ?? 'India' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card card-primary shadow-none border">
                                            <div class="card-header py-2" style="background:#f8f9fa;">
                                                <h6 class="mb-0 text-dark"><i class="fas fa-credit-card mr-2 text-success"></i>{{ __('Payment & Courier Info') }}</h6>
                                            </div>
                                            <div class="card-body py-3">
                                                <p class="mb-1"><strong>{{ __('Method') }}:</strong> {{ strtoupper($order->payment_method ?? 'Razorpay') }}</p>
                                                <p class="mb-1"><strong>{{ __('Payment ID') }}:</strong> <code class="small">{{ $order->payment_id ?? 'N/A' }}</code></p>
                                                <p class="mb-1"><strong>{{ __('Courier') }}:</strong> {{ $order->courier_partner ?? 'Not Assigned' }}</p>
                                                <p class="mb-0"><strong>{{ __('Tracking #') }}:</strong> {{ $order->tracking_number ?? 'Not Available' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title mb-3 font-weight-bold">{{ __('Ordered SkillBox Items') }}</div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-md border">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 50px;">#</th>
                                                <th style="width: 90px;">{{ __('Image') }}</th>
                                                <th>{{ __('Product Title') }}</th>
                                                <th class="text-right" style="width: 140px;">{{ __('Unit Price') }}</th>
                                                <th class="text-center" style="width: 100px;">{{ __('Quantity') }}</th>
                                                <th class="text-right" style="width: 160px;">{{ __('Total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                                    <td class="align-middle">
                                                        @if($item->product_image)
                                                            <img src="{{ $item->product_image }}" alt="{{ $item->product_title }}" style="width: 60px; height: 60px; object-fit: contain; background: #fff; border: 1px solid #e9ecef; border-radius: 8px; padding: 4px;">
                                                        @else
                                                            <div style="width: 60px; height: 60px; background: #f0f3f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #adb5bd;">
                                                                <i class="fas fa-box fa-2x"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle font-weight-bold text-dark">
                                                        {{ $item->product_title }}
                                                        @if($item->product_id)
                                                            <div class="text-muted small font-weight-normal">SKU/ID: #{{ $item->product_id }}</div>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-right font-weight-600">₹{{ number_format($item->unit_price, 2) }}</td>
                                                    <td class="align-middle text-center"><span class="badge badge-secondary px-3 py-2" style="font-size: 14px;">{{ $item->quantity }}</span></td>
                                                    <td class="align-middle text-right font-weight-bold text-dark">₹{{ number_format($item->total_price, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-6">
                                        <div class="card shadow-none border">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0 text-dark"><i class="fas fa-edit mr-2 text-primary"></i>{{ __('Update Order & Tracking Status') }}</h6>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{ route('admin.shop-orders.update-status', $order->id) }}" method="POST">
                                                    @csrf
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label class="font-weight-600">{{ __('Order Status') }} <span class="text-danger">*</span></label>
                                                            <select name="order_status" class="form-control" required>
                                                                <option value="pending" @selected($order->order_status == 'pending')>{{ __('Pending') }}</option>
                                                                <option value="processing" @selected($order->order_status == 'processing')>{{ __('Processing') }}</option>
                                                                <option value="shipped" @selected($order->order_status == 'shipped')>{{ __('Shipped') }}</option>
                                                                <option value="delivered" @selected($order->order_status == 'delivered')>{{ __('Delivered') }}</option>
                                                                <option value="cancelled" @selected($order->order_status == 'cancelled')>{{ __('Cancelled') }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="font-weight-600">{{ __('Payment Status') }} <span class="text-danger">*</span></label>
                                                            <select name="payment_status" class="form-control" required>
                                                                <option value="pending" @selected($order->payment_status == 'pending')>{{ __('Pending') }}</option>
                                                                <option value="paid" @selected($order->payment_status == 'paid')>{{ __('Paid') }}</option>
                                                                <option value="failed" @selected($order->payment_status == 'failed')>{{ __('Failed') }}</option>
                                                                <option value="refunded" @selected($order->payment_status == 'refunded')>{{ __('Refunded') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label class="font-weight-600">{{ __('Courier Partner') }}</label>
                                                            <input type="text" name="courier_partner" class="form-control" placeholder="e.g. DTDC, BlueDart, Delhivery" value="{{ old('courier_partner', $order->courier_partner) }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="font-weight-600">{{ __('Tracking / AWB Number') }}</label>
                                                            <input type="text" name="tracking_number" class="form-control" placeholder="e.g. TRK987654321" value="{{ old('tracking_number', $order->tracking_number) }}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="font-weight-600">{{ __('Admin Notes / Remarks') }}</label>
                                                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Internal dispatch notes or customer update details...">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary font-weight-600 px-4"><i class="fas fa-save mr-1"></i> {{ __('Save & Update Order') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="card shadow-none border">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0 text-dark"><i class="fas fa-calculator mr-2 text-success"></i>{{ __('Order Calculation') }}</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <span class="text-muted">{{ __('Subtotal') }}</span>
                                                    <span class="font-weight-bold">₹{{ number_format($order->subtotal, 2) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <span class="text-muted">{{ __('Shipping & Delivery') }}</span>
                                                    <span class="text-success font-weight-bold">{{ $order->shipping_cost > 0 ? '₹' . number_format($order->shipping_cost, 2) : __('Free Delivery') }}</span>
                                                </div>
                                                @if($order->discount > 0)
                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <span class="text-muted">{{ __('Discount') }}</span>
                                                    <span class="text-danger font-weight-bold">-₹{{ number_format($order->discount, 2) }}</span>
                                                </div>
                                                @endif
                                                <div class="d-flex justify-content-between py-3">
                                                    <span class="h5 mb-0 text-dark font-weight-bold">{{ __('Grand Total') }}</span>
                                                    <span class="h4 mb-0 text-primary font-weight-bold">₹{{ number_format($order->total_amount, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.shop-orders.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left mr-1"></i> {{ __('Back to Shop Orders') }}</a>
                        <div>
                            <a target="_blank" href="{{ route('admin.shop-orders.invoice', $order->id) }}" class="btn btn-warning btn-icon icon-left print-btn mr-2"><i class="fas fa-print"></i> {{ __('Print Invoice') }}</a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteShopOrder"><i class="fas fa-trash mr-1"></i> {{ __('Delete') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteShopOrder">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.shop-orders.destroy', $order->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Delete Shop Order') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger mb-0">{{ __('Are you sure you want to delete Shop Order') }} <strong>#{{ $order->order_number }}</strong>? {{ __('This action cannot be undone.') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger font-weight-bold">{{ __('Yes, Delete Order') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
