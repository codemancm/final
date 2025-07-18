@extends('layouts.user')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>User Dashboard</h1>
                <p>Welcome to your dashboard, {{ auth()->user()->username }}.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orders</h5>
                        <p class="card-text">{{ auth()->user()->orders->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Disputes</h5>
                        <p class="card-text">{{ auth()->user()->disputes->count() }}</p>
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
                                    <th>Vendor</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(auth()->user()->orders()->latest()->take(5)->get() as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->vendor->username }}</td>
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