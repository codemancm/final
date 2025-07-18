@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Vendor Escrow Balances</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Vendor</th>
                                <th>Escrow Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendors as $vendor)
                                <tr>
                                    <td>{{ $vendor->username }}</td>
                                    <td>{{ $vendor->sales->sum('total') }} XMR</td>
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
