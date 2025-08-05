@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2>Add New Exam</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.exam-catalogs.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Exam Code</label>
            <input type="text" name="exam_code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Exam Title</label>
            <input type="text" name="exam_title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Duration (in minutes)</label>
            <input type="number" name="duration_minutes" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="draft">Draft</option>
                <option value="scheduled">Scheduled</option>
                <option value="active">Active</option>
                <option value="paused">Paused</option>
                <option value="stopped">Stopped</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Start Time</label>
            <input type="datetime-local" name="start_time" class="form-control">
        </div>

        <div class="mb-3">
            <label>End Time</label>
            <input type="datetime-local" name="end_time" class="form-control">
        </div>

        <div class="mb-3">
            <label>Lab Environment</label>
            <select name="lab_env_id" class="form-control">
                <option value="">-- None --</option>
                @foreach ($labEnvironments as $env)
                    <option value="{{ $env->lab_env_id }}">{{ $env->schema_name }}</option>
                @endforeach
            </select>
        </div>

       <div class="form-check mb-3">
    <input type="checkbox" name="is_visible_to_students" value="1" class="form-check-input" id="visibleCheck"
        {{ old('is_visible_to_students') ? 'checked' : '' }}>
    <label class="form-check-label" for="visibleCheck">Visible to Students</label>
</div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('admin.exam-catalogs.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
