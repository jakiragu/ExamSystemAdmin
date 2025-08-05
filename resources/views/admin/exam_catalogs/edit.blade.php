@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2>Edit Exam</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Something went wrong.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.exam-catalogs.update', ['exam_catalog' => $examCatalog]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Exam Code</label>
            <input type="text" name="exam_code" value="{{ $examCatalog->exam_code }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Exam Title</label>
            <input type="text" name="exam_title" value="{{ $examCatalog->exam_title }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Duration (in minutes)</label>
            <input type="number" name="duration_minutes" value="{{ $examCatalog->duration_minutes }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                @foreach (['draft', 'scheduled', 'active', 'paused', 'stopped'] as $status)
                    <option value="{{ $status }}" {{ $examCatalog->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Start Time</label>
            <input type="datetime-local" name="start_time" value="{{ optional($examCatalog->start_time)->format('Y-m-d\TH:i') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>End Time</label>
            <input type="datetime-local" name="end_time" value="{{ optional($examCatalog->end_time)->format('Y-m-d\TH:i') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Lab Environment</label>
            <select name="lab_env_id" class="form-control">
                <option value="">-- None --</option>
                @foreach ($labEnvironments as $env)
                    <option value="{{ $env->lab_env_id }}" {{ $examCatalog->lab_env_id == $env->lab_env_id ? 'selected' : '' }}>
                        {{ $env->schema_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_visible_to_students" class="form-check-input" id="visibleCheck"
                   {{ $examCatalog->is_visible_to_students ? 'checked' : '' }}>
            <label class="form-check-label" for="visibleCheck">Visible to Students</label>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.exam-catalogs.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
