<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Order\app\Models\Order;

class SchoolOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::where('buyer_id', userAuth()->id)->orderBy('id', 'desc')->paginate(20);
        return view('frontend.school-dashboard.order.index', compact('orders'));
    }

    public function show(string $id): View
    {
        $order = Order::where('id', $id)->where('buyer_id', userAuth()->id)->firstOrFail();
        return view('frontend.school-dashboard.order.show', compact('order'));
    }

    public function printInvoice(Request $request, string $id): View
    {
        $order = Order::where('id', $id)->where('buyer_id', userAuth()->id)->firstOrFail();
        return view('frontend.school-dashboard.order.invoice', compact('order'));
    }
}
