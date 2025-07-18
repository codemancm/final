<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class EscrowController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', 'in_escrow')->paginate(15);
        return view('admin.escrow.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.escrow.show', compact('order'));
    }

    public function release(Order $order)
    {
        // Logic for releasing funds to the vendor will be added later
        return redirect()->route('admin.escrow.index');
    }

    public function refund(Order $order)
    {
        // Logic for refunding the buyer will be added later
        return redirect()->route('admin.escrow.index');
    }
}
