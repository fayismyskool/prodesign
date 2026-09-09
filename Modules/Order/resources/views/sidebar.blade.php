@php
    $pendingOrderCount = \Modules\Order\app\Models\Order::where('payment_status', 'pending')->count();
    $pendingShopOrderCount = \App\Models\ShopOrder::where('order_status', 'pending')->orWhere('payment_status', 'pending')->count();
    $totalPendingCount = $pendingOrderCount + $pendingShopOrderCount;
@endphp
<li
    class="nav-item dropdown {{ isRoute(['admin.orders', 'admin.order', 'admin.pending-payment', 'admin.rejected-payment', 'admin.pending-orders', 'admin.shop-orders.index', 'admin.shop-orders.pending', 'admin.shop-orders.show'], 'active') }}">
    <a href="#" class="nav-link has-dropdown"
        data-toggle="dropdown"><i class="fas fa-shopping-bag"></i>
        <span class="{{ $totalPendingCount > 0 ? 'beep parent' : '' }}">{{ __('Manage Order') }} </span>

    </a>
    <ul class="dropdown-menu">
        <li class="{{ isRoute('admin.orders', 'active') }} {{ isRoute('admin.order', 'active') }}"><a class="nav-link"
                href="{{ route('admin.orders') }}">{{ __('Order History') }}</a></li>

        <li class="{{ isRoute('admin.pending-orders', 'active') }}"><a class="nav-link"
                href="{{ route('admin.pending-orders') }}">{{ __('Pending Payment') }}
                @if ($pendingOrderCount > 0)
                    <small class="badge badge-danger ml-2">{{ $pendingOrderCount }}</small>
                @endif
            </a>
        </li>

        <li class="{{ isRoute('admin.shop-orders.index', 'active') }} {{ isRoute('admin.shop-orders.show', 'active') }}"><a class="nav-link"
                href="{{ route('admin.shop-orders.index') }}">{{ __('Shop Orders') }}</a></li>

        <li class="{{ isRoute('admin.shop-orders.pending', 'active') }}"><a class="nav-link"
                href="{{ route('admin.shop-orders.pending') }}">{{ __('Pending Shop Orders') }}
                @if ($pendingShopOrderCount > 0)
                    <small class="badge badge-danger ml-2">{{ $pendingShopOrderCount }}</small>
                @endif
            </a>
        </li>

    </ul>
</li>
