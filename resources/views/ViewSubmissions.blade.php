<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Submissions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f9f9f9;
        }
        .container {
            margin-top: 50px;
        }
        .page-title {
            color: #3F2B96;
            font-weight: 600;
        }
        .card-header {
            background-color: #3F2B96;
            color: #fff;
            font-size: 1.2rem;
            font-weight: 500;
        }
        .btn-purple {
            background-color: #3F2B96;
            color: white;
        }
        .btn-purple:hover {
            background-color: #2e2074;
            color: white;
        }
        .view-link {
            color: #FD7E14;
            font-weight: 500;
            text-decoration: none;
        }
        .view-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="text-center mb-4">
        <h2 class="page-title">Student Submissions</h2>
    </div>

    @if($students->isEmpty())
        <div class="alert alert-info text-center">No submissions found yet.</div>
    @else
        <div class="card shadow-sm rounded-4">
            <div class="card-header">Submitted Candidates</div>
            <div class="table-responsive">
                <table class="table table-bordered mb-0 text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Certification ID</th>
                            <th>Full Name</th>
                            <th>Submission</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->CertificationID }}</td>
                                <td>{{ $student->FullName }}</td>
                                <td>
                                    <a href="{{ route('ViewAnswers', ['id' => $student->CertificationID]) }}" class="view-link">
                                        <i class="bi bi-eye-fill"></i> View Submission
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <a class="btn btn-purple btn-sm rounded-pill mt-4" href="{{ route('adminDashboard') }}">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
