@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">🧠 Add New Exam Question</h2>

    <form action="{{ route('admin.exam-questions.store') }}" method="POST">
        @csrf

        {{-- Question Text --}}
        <div class="mb-3">
            <label for="question_text" class="form-label">Question Text</label>
            <textarea class="form-control" id="question_text" name="question_text" rows="4" required></textarea>
            @error('question_text')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Question Type --}}
        <div class="mb-3">
            <label for="question_type" class="form-label">Question Type</label>
            <select class="form-control" id="question_type" name="question_type" required>
                <option value="">Select Type</option>
                <option value="mcq">Multiple Choice</option>
                <option value="multiple_response">Multiple Response</option>
                <option value="coding">Practical</option>
                <option value="short_answer">Open Ended</option>
            </select>
            @error('question_type')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Dynamic Choices for MCQ / Multiple Response --}}
        <div id="choices-container" class="mb-3" style="display: none;">
            <label class="form-label">Choices</label>
            <div id="choices-list">
                <div class="input-group mb-2">
                    <input type="text" name="choices[0][choice_text]" class="form-control" placeholder="Choice 1" required>
                    <div class="input-group-text">
                        <input type="checkbox" name="choices[0][is_correct]"> Correct
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-secondary" onclick="addChoice()">➕ Add Choice</button>
        </div>

        {{-- Difficulty Level --}}
        <div class="mb-3">
            <label for="difficulty_level" class="form-label">Difficulty Level</label>
            <select class="form-control" id="difficulty_level" name="difficulty_level" required>
                <option value="">Select Difficulty</option>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
            </select>
            @error('difficulty_level')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Practical Question Metadata --}}
        <div id="practical-container" class="card mb-4" style="display: none;">
            <div class="card-header">🧪 Practical Exercise Details</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="expected_action" class="form-label">Expected Action</label>
                    <input type="text" class="form-control" id="expected_action" name="expected_action">
                    @error('expected_action')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label for="sample_input" class="form-label">Sample Input</label>
                    <textarea class="form-control" id="sample_input" name="sample_input" rows="3"></textarea>
                    @error('sample_input')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label for="expected_output" class="form-label">Expected Output</label>
                    <textarea class="form-control" id="expected_output" name="expected_output" rows="3"></textarea>
                    @error('expected_output')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        {{-- Objective --}}
        <div class="mb-3">
            <label for="exam_objective_id" class="form-label">Exam Objective</label>
            <select class="form-control" name="exam_objective_id" required>
                <option value="">Select Objective</option>
                @foreach($objectives as $obj)
                    <option value="{{ $obj->id }}">{{ $obj->description }}</option>
                @endforeach
            </select>
            @error('exam_objective_id')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Lab Environment for Practical --}}
        <div id="labenv-container" class="mb-3" style="display: none;">
            <label for="lab_env_id" class="form-label">Lab Environment</label>
            <select class="form-control" name="lab_env_id">
                <option value="">Select Environment</option>
                @foreach($labEnvs as $env)
                    <option value="{{ $env->id }}">{{ $env->name }}</option>
                @endforeach
            </select>
            @error('lab_env_id')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Evaluation Type --}}
        <div class="mb-3">
            <label for="evaluation_type" class="form-label">Evaluation Type</label>
            <input type="text" class="form-control" id="evaluation_type" name="evaluation_type">
            @error('evaluation_type')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Cognitive Level --}}
        <div class="mb-3">
            <label for="cognitive_level" class="form-label">Cognitive Level (optional)</label>
            <select class="form-control" name="cognitive_level">
                <option value="">Select Level</option>
                <option value="remember">Remember</option>
                <option value="understand">Understand</option>
                <option value="apply">Apply</option>
                <option value="analyze">Analyze</option>
                <option value="evaluate">Evaluate</option>
                <option value="create">Create</option>
            </select>
        </div>

        {{-- CTA --}}
        <button type="submit" class="btn btn-success">✅ Save Question</button>
         <a href="{{ route('admin.exam-questions.index') }}" class="btn btn-secondary">Cancel</a>
         <a href="{{ route('admin.exam-questions.import') }}" class="btn btn-outline-primary ms-2">📥 Bulk Import CSV</a>
    </form>
</div>

{{-- Dynamic UI Script --}}
<script>
    document.getElementById('question_type').addEventListener('change', function () {
        const selected = this.value;
        const showChoices = ['mcq', 'multiple_response'].includes(selected);
        const showPractical = selected === 'coding';

        document.getElementById('choices-container').style.display = showChoices ? 'block' : 'none';
        document.getElementById('practical-container').style.display = showPractical ? 'block' : 'none';
        document.getElementById('labenv-container').style.display = showPractical ? 'block' : 'none';
    });

    let choiceIndex = 1;
    function addChoice() {
        const container = document.getElementById('choices-list');
        const newField = document.createElement('div');
        newField.className = 'input-group mb-2';
        newField.innerHTML = `
            <input type="text" name="choices[${choiceIndex}][choice_text]" class="form-control" placeholder="Choice ${choiceIndex + 1}" required>
            <div class="input-group-text">
                <input type="checkbox" name="choices[${choiceIndex}][is_correct]"> Correct
            </div>
        `;
        container.appendChild(newField);
        choiceIndex++;
    }
</script>
@endsection