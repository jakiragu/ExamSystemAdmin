@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Lab Environment</h2>

    <form action="{{ route('admin.lab-environments.update', $environment->lab_env_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Schema Name</label>
            <input type="text" name="schema_name" value="{{ $environment->schema_name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Setup Script</label>
            <textarea name="setup_script" class="form-control">{{ $environment->setup_script }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Teardown Script</label>
            <textarea name="teardown_script" class="form-control">{{ $environment->teardown_script }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Comments</label>
            <textarea name="comments" class="form-control">{{ $environment->comments }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
