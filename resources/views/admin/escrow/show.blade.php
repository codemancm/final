@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Order Details') }}</div>

                    <div class="card-body">
                        <p><strong>{{ __('Order ID') }}:</strong> {{ $order->id }}</p>
                        <p><strong>{{ __('Buyer') }}:</strong> {{ $order->buyer->username }}</p>
                        <p><strong>{{ __('Vendor') }}:</strong> {{ $order->vendor->username }}</p>
                        <p><strong>{{ __('Total Amount') }}:</strong> {{ $order->total_amount }} XMR</p>
                        <p><strong>{{ __('Status') }}:</strong> {{ $order->status }}</p>

                        <hr>

                        <form action="{{ route('admin.escrow.release', $order) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">{{ __('Release Funds to Vendor') }}</button>
                        </form>

                        <form action="{{ route('admin.escrow.refund', $order) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger">{{ __('Refund Buyer') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
