@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Rotate PGP Key</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.pgp-key-rotation.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="public_key" class="col-md-4 col-form-label text-md-right">New Public Key</label>

                            <div class="col-md-6">
                                <textarea id="public_key" class="form-control @error('public_key') is-invalid @enderror" name="public_key" required rows="10"></textarea>

                                @error('public_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Rotate Key
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
