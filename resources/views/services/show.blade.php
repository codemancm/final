@extends('layouts.app')

@section('title', 'Service Details')

@section('content')
    <div class="container">
        <h1>{{ $service->name }}</h1>
        <p>{{ $service->description }}</p>
        <p>Price: {{ $service->price }}</p>
        @if($service->service_picture)
            <img src="{{ asset('storage/' . $service->service_picture) }}" alt="{{ $service->name }}" width="200">
        @endif
    </div>
@endsection
