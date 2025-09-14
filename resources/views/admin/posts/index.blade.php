@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Categories</h1>
    <a href="{{ url('admin/categories/create') }}" class="btn btn-primary mb-3">Create Category</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Posts Count</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($categories as $cat)
            <tr>
                <td>{{ $cat->id }}</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->posts()->count() }}</td>
                <td>
                    <a href="{{ url('admin/categories/edit/'.$cat->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ url('admin/categories/delete/'.$cat->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
