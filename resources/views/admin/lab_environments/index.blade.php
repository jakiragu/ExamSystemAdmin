@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Lab Environments</h2>
    <a href="{{ route('admin.lab-environments.create') }}" class="btn btn-primary mb-3">Add New</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Schema Name</th>
                <th>Setup Script</th>
                <th>Teardown Script</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($environments as $env)
            <tr>
                <td>{{ $env->schema_name }}</td>
                <td>{{ Str::limit($env->setup_script, 30) }}</td>
                <td>{{ Str::limit($env->teardown_script, 30) }}</td>
                <td>{{ $env->comments }}</td>
                <td>
                    <a href="{{ route('admin.lab-environments.edit', $env->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.lab-environments.destroy', $env->id) }}" method="POST" style="display:inline-block;">
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
