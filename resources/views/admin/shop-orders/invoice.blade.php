@php
    $setting = $setting ?? Cache::get('setting');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Invoice') }} - #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            background: #f8f9fa;
            padding: 20px;
        }
        .invoice-box {
            max-width: 850px;
            margin: auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .header-table, .info-table, .items-table, .calc-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
        }
        .logo-img {
            max-height: 52px;
            max-width: 220px;
            object-fit: contain;
            margin-bottom: 8px;
            display: block;
        }
        .logo-text {
            font-size: 26px;
            font-weight: 800;
            color: #2b4eff;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .company-address {
            font-size: 13px;
            color: #555;
            line-height: 1.5;
            max-width: 340px;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h1 {
            font-size: 28px;
            color: #222;
            margin-bottom: 5px;
        }
        .order-number {
            font-size: 15px;
            font-weight: 600;
            color: #2b4eff;
        }
        .divider {
            height: 2px;
            background: #e9ecef;
            margin: 20px 0;
        }
        .info-table td {
            width: 50%;
            vertical-align: top;
            padding: 10px 0;
        }
        .section-label {
            font-size: 12px;
            font-weight: 700;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .customer-name {
            font-size: 16px;
            font-weight: 700;
            color: #222;
            margin-bottom: 4px;
        }
        .customer-detail {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }
        .items-table {
            margin-top: 25px;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            overflow: hidden;
        }
        .items-table th {
            background: #f4f6f9;
            color: #444;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        .items-table td {
            padding: 14px;
            font-size: 14px;
            border-bottom: 1px solid #f0f0f0;
        }
        .items-table tr:last-child td {
            border-bottom: none;
        }
        .calc-wrapper {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
        }
        .calc-table {
            width: 320px;
        }
        .calc-table td {
            padding: 6px 10px;
            font-size: 14px;
        }
        .calc-table .total-row td {
            font-size: 18px;
            font-weight: 800;
            color: #2b4eff;
            border-top: 2px solid #222;
            padding-top: 12px;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-paid {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .badge-pending {
            background: #fff8e1;
            color: #f57f17;
        }
        .btn-print {
            background: #2b4eff;
            color: #fff;
            border: none;
            padding: 10px 24px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(43,78,255,0.3);
        }
        .footer-note {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #888;
            border-top: 1px dashed #ddd;
            padding-top: 20px;
        }
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .invoice-box {
                box-shadow: none;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="invoice-box">
        <div class="no-print" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
            <button onclick="window.history.back()" style="background:#e9ecef; border:none; padding:8px 16px; border-radius:4px; cursor:pointer; font-weight:600;">&larr; Back</button>
            <button onclick="window.print()" class="btn-print">Print / Download Invoice</button>
        </div>

        <table class="header-table">
            <tr>
                <td>
                    @if(!empty($setting?->logo))
                        <img src="{{ asset($setting->logo) }}" alt="{{ $setting?->app_name ?? config('app.name') }}" class="logo-img">
                    @else
                        <div class="logo-text">{{ $setting?->app_name ?? config('app.name', 'SkillBox') }}</div>
                    @endif
                    <div class="company-address">
                        @if(!empty($setting?->site_address))
                            <div>{{ $setting->site_address }}</div>
                        @endif
                        @if(!empty($setting?->site_email))
                            <div><strong>Email:</strong> {{ $setting->site_email }}</div>
                        @endif
                        @if(!empty($setting?->site_phone))
                            <div><strong>Phone:</strong> {{ $setting->site_phone }}</div>
                        @endif
                    </div>
                </td>
                <td class="invoice-title">
                    <h1>INVOICE</h1>
                    <div class="order-number">#{{ $order->order_number }}</div>
                    <div style="font-size: 13px; color: #777; margin-top: 4px;">Date: {{ $order->created_at->format('d M Y') }}</div>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="info-table">
            <tr>
                <td>
                    <div class="section-label">Delivered To:</div>
                    <div class="customer-name">{{ $order->customer_name }}</div>
                    <div class="customer-detail">
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->state }} - <strong>{{ $order->pincode }}</strong><br>
                        {{ $order->country ?? 'India' }}<br>
                        <strong>Phone:</strong> {{ $order->customer_phone }}<br>
                        @if($order->customer_email)
                            <strong>Email:</strong> {{ $order->customer_email }}
                        @endif
                    </div>
                </td>
                <td style="text-align: right;">
                    <div class="section-label">Order Details:</div>
                    <div class="customer-detail">
                        <strong>Payment Status:</strong> 
                        <span class="badge {{ $order->payment_status == 'paid' ? 'badge-paid' : 'badge-pending' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span><br>
                        <strong>Payment Method:</strong> {{ strtoupper($order->payment_method ?? 'Razorpay') }}<br>
                        @if($order->payment_id)
                            <strong>Payment ID:</strong> {{ $order->payment_id }}<br>
                        @endif
                        <strong>Order Status:</strong> {{ ucfirst($order->order_status) }}<br>
                        @if($order->courier_partner)
                            <strong>Courier:</strong> {{ $order->courier_partner }}<br>
                        @endif
                        @if($order->tracking_number)
                            <strong>AWB / Tracking:</strong> {{ $order->tracking_number }}<br>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>Product Description</th>
                    <th style="text-align: right; width: 120px;">Unit Price</th>
                    <th style="text-align: center; width: 80px;">Qty</th>
                    <th style="text-align: right; width: 130px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $item->product_title }}</strong>
                            @if($item->product_id)
                                <div style="font-size: 12px; color: #888;">Item ID: #{{ $item->product_id }}</div>
                            @endif
                        </td>
                        <td style="text-align: right;">₹{{ number_format($item->unit_price, 2) }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right; font-weight: 600;">₹{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="calc-wrapper">
            <table class="calc-table">
                <tr>
                    <td style="color: #666;">Subtotal:</td>
                    <td style="text-align: right; font-weight: 600;">₹{{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td style="color: #666;">Shipping & Delivery:</td>
                    <td style="text-align: right; font-weight: 600; color: #2e7d32;">
                        {{ $order->shipping_cost > 0 ? '₹' . number_format($order->shipping_cost, 2) : 'FREE' }}
                    </td>
                </tr>
                @if($order->discount > 0)
                <tr>
                    <td style="color: #666;">Discount:</td>
                    <td style="text-align: right; font-weight: 600; color: #d32f2f;">-₹{{ number_format($order->discount, 2) }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td>Total:</td>
                    <td style="text-align: right;">₹{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer-note">
            <p>Thank you for choosing {{ $setting?->app_name ?? 'SkillBox' }}! If you have questions about your order, please contact our support{{ !empty($setting?->site_email) ? ' at ' . $setting->site_email : '' }}.</p>
        </div>
    </div>

</body>
</html>
