<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Set Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f9f9f9;
        }
        .page-title {
            color: #3F2B96;
            font-weight: 600;
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
        .btn-orange {
            background-color: #FD7E14;
            color: white;
        }
        .btn-orange:hover {
            background-color: #dc6a0e;
            color: white;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="page-title">All Set Questions</h2>
    </div>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ url('/makeQuestions') }}" class="btn btn-purple rounded-pill">
            <i class="bi bi-plus-circle"></i> Create New Question
        </a>
        <a class="btn btn-purple rounded-pill" href="{{ route('adminDashboard') }}">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($questions->count() > 0)
        <div class="card shadow-sm rounded-4">
            <div class="card-header">Questions</div>
            <div class="table-responsive">
                <table class="table table-bordered mb-0 text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Text</th>
                            <th>Type</th>
                            <th>Image Path</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $question)
                            <tr>
                                <td>{{ $question->QuestionID }}</td>
                                <td>{{ $question->title }}</td>
                                <td>{{ $question->text }}</td>
                                <td>{{ $question->type }}</td>
                                <td>{{ $question->ImagePath ?? 'N/A' }}</td>
                                <td>{{ $question->created_at }}</td>
                                <td>
                                    <form action="{{ route('questions.delete', $question->QuestionID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-orange btn-sm rounded-pill">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center">No questions found.</div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
