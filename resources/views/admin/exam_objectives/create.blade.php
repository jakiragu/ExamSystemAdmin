@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Create Exam Objective</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.exam-objectives.store') }}">
        @csrf

        <div class="mb-3">
            <label>Objective Title</label>
            <input type="text" name="objective_title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Subject Area</label>
            <select name="subject_area_id" class="form-control" required>
                <option value="">-- Select Subject Area --</option>
                @foreach($subjectAreas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }} (ID: {{ $area->id }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Exam Catalog</label>
            <select name="exam_catalog_id" class="form-control" required>
                <option value="">-- Select Exam --</option>
                @foreach($examCatalogs as $catalog)
                    <option value="{{ $catalog->id }}">{{ $catalog->exam_title }} (ID: {{ $catalog->id }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('admin.exam-objectives.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
