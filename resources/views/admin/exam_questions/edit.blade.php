@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Exam Question</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.exam-questions.update', $examQuestion->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="question_text" class="form-label">Question Text</label>
            <textarea class="form-control" name="question_text" id="question_text" rows="3" required>{{ old('question_text', $examQuestion->question_text) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="exam_objective_id" class="form-label">Objective</label>
            <select name="exam_objective_id" id="exam_objective_id" class="form-control" required>
                <option value="">-- Select Objective --</option>
                @foreach($objectives as $objective)
                    <option value="{{ $objective->id }}" {{ $examQuestion->exam_objective_id == $objective->id ? 'selected' : '' }}>
                        {{ $objective->description }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="difficulty_level" class="form-label">Difficulty Level</label>
            <select name="difficulty_level" id="difficulty_level" class="form-control" required>
                <option value="easy" {{ $examQuestion->difficulty_level == 'easy' ? 'selected' : '' }}>Easy</option>
                <option value="medium" {{ $examQuestion->difficulty_level == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="hard" {{ $examQuestion->difficulty_level == 'hard' ? 'selected' : '' }}>Hard</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="expected_action" class="form-label">Expected Action</label>
            <input type="text" class="form-control" id="expected_action" name="expected_action" value="{{ old('expected_action', $examQuestion->expected_action) }}">
        </div>

        <div class="mb-3">
            <label for="sample_input" class="form-label">Sample Input</label>
            <textarea class="form-control" id="sample_input" name="sample_input">{{ old('sample_input', $examQuestion->sample_input) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="expected_output" class="form-label">Expected Output</label>
            <textarea class="form-control" id="expected_output" name="expected_output">{{ old('expected_output', $examQuestion->expected_output) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="lab_env_id" class="form-label">Lab Environment</label>
            <select name="lab_env_id" id="lab_env_id" class="form-control">
                <option value="">-- Select Lab --</option>
                @foreach($labEnvs as $lab)
                    <option value="{{ $lab->id }}" {{ $examQuestion->lab_env_id == $lab->id ? 'selected' : '' }}>
                        {{ $lab->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="evaluation_type" class="form-label">Evaluation Type</label>
            <select name="evaluation_type" id="evaluation_type" class="form-control" required>
                <option value="manual" {{ $examQuestion->evaluation_type == 'manual' ? 'selected' : '' }}>Manual</option>
                <option value="auto" {{ $examQuestion->evaluation_type == 'auto' ? 'selected' : '' }}>Auto</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Question</button>
        <a href="{{ route('admin.exam-questions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
