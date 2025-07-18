@extends('layouts.app')

@section('title', 'Edit Service')

@section('content')
    <div class="container">
        <h1>Edit Service</h1>
        <form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $service->name }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required>{{ $service->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ $service->price }}" required>
            </div>
            <div class="form-group">
                <label for="service_picture">Service Picture</label>
                <input type="file" name="service_picture" id="service_picture" class="form-control-file">
                @if($service->service_picture)
                    <img src="{{ asset('storage/' . $service->service_picture) }}" alt="{{ $service->name }}" width="200" class="mt-2">
                @endif
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="active" id="active" class="form-check-input" value="1" @if($service->active) checked @endif>
                <label for="active" class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-primary">Update Service</button>
        </form>
    </div>
@endsection
