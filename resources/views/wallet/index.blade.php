@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Wallet') }}</div>

                    <div class="card-body">
                        <div class="mb-3">
                            <strong>{{ __('Balance') }}:</strong> {{ $wallet->balance }} XMR
                        </div>

                        <hr>

                        <h4>{{ __('Deposit') }}</h4>
                        <p>{{ __('Your Monero Deposit Address') }}:</p>
                        <code>{{ $wallet->deposit_address }}</code>
                        <br>
                        <a href="{{ route('wallet.generate-address') }}" class="btn btn-primary mt-2">{{ __('Generate New Address') }}</a>

                        <hr>

                        <h4>{{ __('Withdraw') }}</h4>
                        <form action="{{ route('wallet.withdraw') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="address">{{ __('Address') }}</label>
                                <input type="text" name="address" id="address" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="amount">{{ __('Amount') }}</label>
                                <input type="number" name="amount" id="amount" class="form-control" step="0.00000001" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">{{ __('Withdraw') }}</button>
                        </form>

                        <hr>

                        <h4>{{ __('Transactions') }}</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Description') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>{{ $transaction->type }}</td>
                                        <td>{{ $transaction->amount }}</td>
                                        <td>{{ $transaction->description }}</td>
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
