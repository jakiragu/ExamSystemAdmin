@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Create Subject Area</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.subject-areas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Subject Area Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="exam_catalog_id" class="form-label">Exam Catalog</label>
            <select name="exam_catalog_id" class="form-control" required>
                <option value="" disabled selected>-- Select Catalog --</option>
                @foreach($examCatalogs as $catalog)
                    <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('admin.subject-areas.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection