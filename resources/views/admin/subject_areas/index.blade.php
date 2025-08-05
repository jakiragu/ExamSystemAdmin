@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Subject Areas</h1>

        <a href="{{ route('admin.subject-areas.create') }}" class="btn btn-success mb-3">Add New Subject Area</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($subjectAreas->isEmpty())
            <div class="alert alert-info">No subject areas available.</div>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjectAreas as $index => $subjectArea)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $subjectArea->name }}</td>
                            <td>{{ $subjectArea->description }}</td>
                            <td>
                                <a href="{{ route('admin.subject-areas.edit', ['subject_area' => $subjectArea->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                                
                                <form action="{{ route('admin.subject-areas.destroy', ['subject_area' => $subjectArea->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
