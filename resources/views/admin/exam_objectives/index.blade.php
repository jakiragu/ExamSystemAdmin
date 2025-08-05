@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Exam Objectives</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.exam-objectives.create') }}" class="btn btn-primary mb-3">Add Objective</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Objective Title</th>
                <th>Description</th>
                <th>Subject Area</th>
                <th>Exam Catalog</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($examObjectives as $objective)
                <tr>
                    <td>{{ $objective->objective_title }}</td>
                    <td>{{ $objective->description }}</td>
                    <td>{{ $objective->subjectArea->name ?? 'N/A' }}</td>
                    <td>{{ $objective->examCatalog->exam_title ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.exam-objectives.edit', $objective->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.exam-objectives.destroy', $objective->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
