<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Candidate Answers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f9f9f9;
        }
        .container {
            margin-top: 40px;
        }
        .card-header {
            background-color: #3F2B96;
            color: #fff;
        }
        .btn-purple {
            background-color: #3F2B96;
            color: white;
        }
        .btn-purple:hover {
            background-color: #2e2074;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4 text-center">
        Answers for {{ $candidate->FullName ?? $candidate->Name }} ({{ $candidate->CertificationID }})
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($answers as $answer)
        @php
            $question = \App\Models\Questions::find($answer->QuestionID);
        @endphp
        @if($question)
            <div class="card mb-4">
                <div class="card-header">
                    Question {{ $question->QuestionID }}: {{ $question->title }}
                </div>
                <div class="card-body">
                    <p><strong>Question Text:</strong> {{ $question->text }}</p>
                    <p><strong>Student Answer:</strong> {{ $answer->text }}</p>
                    <p><strong>Current Status:</strong> <span class="badge bg-info text-dark">{{ $answer->Status }}</span></p>

                    @if($question->type === 'Practical' || $question->type === 'Text')
                        <form action="{{ route('UpdateAnswerStatus', $answer->AnswerID) }}" method="POST" class="row g-2">
                            @csrf
                            <div class="col-auto">
                                <select name="Status" class="form-select form-select-sm" required>
                                    <option value="">-- Select New Status --</option>
                                    <option value="correct">Correct</option>
                                    <option value="incorrect">Incorrect</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-sm btn-purple rounded-pill">
                                    <i class="bi bi-check-circle"></i> Update
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    @endforeach

    <a href="{{ route('ManageResults') }}" class="btn btn-secondary rounded-pill"><i class="bi bi-arrow-left-circle"></i> Back to Manage Results</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
