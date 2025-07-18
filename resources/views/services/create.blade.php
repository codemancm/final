@extends('layouts.app')

@section('title', 'Create Service')

@section('content')
    <div class="container">
        <h1>Create Service</h1>
        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="service_picture">Service Picture</label>
                <input type="file" name="service_picture" id="service_picture" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Create Service</button>
        </form>
    </div>
@endsection
