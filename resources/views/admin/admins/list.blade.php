@extends('layouts.admin')

@section('title', 'Admins')

@section('content')
    <div class="container">
        <h1>Admins</h1>
        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">Create Admin</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Roles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->username }}</td>
                        <td>
                            @foreach($admin->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
