<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Student Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2 class="mb-4 text-center">Review Results for {{ $student->FullName }} ({{ $student->CertificationID }})</h2>
    <form method="POST" action="{{ route('UpdateResult', ['id' => $student->CertificationID]) }}">
        @csrf
        @foreach($answers as $answer)
            @php $q = $questions[$answer->QuestionID]; @endphp
            <div class="card mb-3">
                <div class="card-header">
                    Question {{ $q->QuestionID }}: {{ $q->title }}
                </div>
                <div class="card-body">
                    <p><strong>Text:</strong> {{ $q->text }}</p>
                    <p><strong>Answer:</strong> {{ $answer->text }}</p>
                    <div class="mb-2">
                        <label>Status:</label>
                        <select name="statuses[{{ $answer->AnswerID }}]" class="form-select">
                            <option value="correct" {{ $answer->Status == 'correct' ? 'selected' : '' }}>Correct</option>
                            <option value="incorrect" {{ $answer->Status == 'incorrect' ? 'selected' : '' }}>Incorrect</option>
                            <option value="pending_review" {{ $answer->Status == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                        </select>
                    </div>
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-success">Update Results</button>
        <a href="{{ route('ManageResults') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
