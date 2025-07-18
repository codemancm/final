@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Vendor Wallet</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Balance</h4>
                            <p>{{ $wallet->balance }} XMR</p>
                        </div>
                        <div class="col-md-6">
                            <h4>Escrowed Balance</h4>
                            <p>{{ $wallet->escrowed_balance }} XMR</p>
                        </div>
                    </div>

                    <hr>

                    <h4>Transactions</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->type }}</td>
                                    <td>{{ $transaction->amount }} XMR</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
