@extends('layouts.vendor')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Vendor Dashboard</h1>
                <p>Welcome to the Vendor Panel. Here you can manage your products in {{ config('app.name') }}.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Products</h5>
                        <p class="card-text">{{ auth()->user()->products->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sales</h5>
                        <p class="card-text">{{ \App\Models\Orders::where('vendor_id', auth()->id())->where('status', 'completed')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Disputes</h5>
                        <p class="card-text">{{ \App\Models\Dispute::whereHas('order', function($query) { $query->where('vendor_id', auth()->id()); })->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Latest Orders</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Buyer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Orders::where('vendor_id', auth()->id())->latest()->take(5)->get() as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->buyer->username }}</td>
                                        <td>{{ $order->total_amount }} XMR</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
