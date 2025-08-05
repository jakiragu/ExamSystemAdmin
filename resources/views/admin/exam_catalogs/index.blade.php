@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Exam Catalogs</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.exam-catalogs.create') }}" class="btn btn-primary">Add New Exam</a>
    </div>

    @if($examCatalogs->isEmpty())
        <p>No exam catalogs found.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Exam Code</th>
                    <th>Exam Title</th>
                    <th>Duration (minutes)</th>
                    <th>Lab Environment</th>
                    <th>Status</th>
                    <th>Visible to Students</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($examCatalogs as $examCatalog)
                    <tr>
                        <td>{{ $examCatalog->exam_code }}</td>
                        <td>{{ $examCatalog->exam_title }}</td>
                        <td>{{ $examCatalog->duration_minutes }}</td>
                        <td>{{ $examCatalog->labEnvironment?->schema_name ?? '-' }}</td>
                        <td>{{ ucfirst($examCatalog->status) }}</td>
                        <td>{{ $examCatalog->is_visible_to_students ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('admin.exam-catalogs.edit', ['exam_catalog' => $examCatalog->id]) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('admin.exam-catalogs.destroy', ['exam_catalog' => $examCatalog->id]) }}"
                                  method="POST"
                                  style="display:inline-block;"
                                  onsubmit="return confirm('Are you sure you want to delete this exam catalog?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
