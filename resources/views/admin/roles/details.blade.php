@extends('layouts.admin')

@section('title', 'Role Details')

@section('content')
    <div class="container">
        <h1>Role Details: {{ $role->name }}</h1>
        <form action="{{ route('admin.roles.permissions.update', $role) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="permissions">Permissions</label>
                <select name="permissions[]" id="permissions" class="form-control" multiple>
                    @foreach($permissions as $permission)
                        <option value="{{ $permission->id }}" @if($role->hasPermissionTo($permission->name)) selected @endif>{{ $permission->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Permissions</button>
        </form>
    </div>
@endsection
