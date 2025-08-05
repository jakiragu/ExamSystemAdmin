@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Exam Objective</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.exam-objectives.update', $exam_objective) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Objective Title</label>
            <input type="text" name="objective_title" class="form-control" value="{{ old('objective_title', $exam_objective->objective_title) }}" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $exam_objective->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Subject Area</label>
            <select name="subject_area_id" class="form-control" required>
                <option value="">-- Select Subject Area --</option>
                @foreach($subjectAreas as $area)
                    <option value="{{ $area->id }}" {{ $exam_objective->subject_area_id == $area->id ? 'selected' : '' }}>
                        {{ $area->name }} (ID: {{ $area->id }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Exam Catalog</label>
            <select name="exam_catalog_id" class="form-control" required>
                <option value="">-- Select Exam --</option>
                @foreach($examCatalogs as $catalog)
                    <option value="{{ $catalog->exam_id }}" {{ $exam_objective->exam_catalog_id == $catalog->exam_id ? 'selected' : '' }}>
                        {{ $catalog->exam_title }} (ID: {{ $catalog->exam_id }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.exam-objectives.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
