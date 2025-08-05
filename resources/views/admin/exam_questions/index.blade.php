@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Exam Questions</h2>
        <a href="{{ route('admin.exam-questions.create') }}" class="btn btn-success">+ Add Question</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($questions->isEmpty())
        <div class="alert alert-warning">No exam questions found.</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Question Text</th>
                    <th>Objective</th>
                    <th>Difficulty</th>
                    <th>Evaluation</th>
                    <th>Lab Environment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $index => $question)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ Str::limit($question->question_text, 50) }}</td>
                        <td>{{ $question->objective->description ?? 'N/A' }}</td>
                        <td>{{ ucfirst($question->difficulty_level) }}</td>
                        <td>{{ $question->evaluation_type }}</td>
                        <td>{{ $question->labEnv->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.exam-questions.edit', $question->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.exam-questions.destroy', $question->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this question?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection