@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Subject Area</h2>

    <form action="{{ route('admin.subject-areas.update', ['subject_area' => $subject_area->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name', $subject_area->name) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $subject_area->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Update</button>
        <a href="{{ route('admin.subject-areas.index') }}" class="btn btn-secondary mt-2">Cancel</a>
    </form>
</div>
@endsection