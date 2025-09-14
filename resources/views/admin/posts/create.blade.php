@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Category</h1>
    <form action="{{ url('admin/categories/save') }}" method="post">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <button class="btn btn-success mt-2">Save</button>
    </form>
</div>
@endsection
