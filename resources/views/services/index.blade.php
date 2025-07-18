@extends('layouts.app')

@section('title', 'Services')

@section('content')
    <div class="container">
        <h1>Services</h1>
        <a href="{{ route('services.create') }}" class="btn btn-primary">Create Service</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->price }}</td>
                        <td>{{ $service->active ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('services.show', $service) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('services.destroy', $service) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $services->links() }}
    </div>
@endsection
