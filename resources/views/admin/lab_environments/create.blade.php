@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Add Lab Environment</h2>

    <form action="{{ route('admin.lab-environments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Schema Name</label>
            <input type="text" name="schema_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Setup Script</label>
            <textarea name="setup_script" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Teardown Script</label>
            <textarea name="teardown_script" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Comments</label>
            <textarea name="comments" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection
