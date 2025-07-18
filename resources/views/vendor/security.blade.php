@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Security Settings</div>

                <div class="card-body">
                    <p>You can manage your security settings on the main settings page.</p>
                    <a href="{{ route('settings') }}" class="btn btn-primary">Go to Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
