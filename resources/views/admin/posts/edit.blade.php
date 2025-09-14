@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Category</h1>
    <form action="{{ url('admin/categories/save') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $category->id }}">

        <div class="form-group">
            <label>Name</label>
            <input name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>

        <button class="btn btn-success mt-2">Update</button>
    </form>
</div>
@endsection
