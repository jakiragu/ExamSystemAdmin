<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Results</title>
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
    <h2 class="mb-4 text-center">Manage Results</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($candidates->isEmpty())
        <div class="alert alert-info">No candidates have submitted answers yet.</div>
    @else
        <div class="card">
            <div class="card-header">Candidates</div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Full Name</th>
                            <th scope="col">Certification ID</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidates as $candidate)
                            <tr>
                                <td>{{ $candidate->FullName }}</td>
                                <td>{{ $candidate->CertificationID }}</td>
                                <td>
                                    <a href="{{ route('ViewCandidateAnswers', $candidate->CertificationID) }}" class="btn btn-sm btn-purple rounded-pill">
                                        <i class="bi bi-eye"></i> View Answers
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Release Results button -->
        <form action="{{ route('ReleaseResults') }}" method="GET" class="mt-4 text-center">
            <button type="submit" class="btn btn-purple btn-lg rounded-pill">
                <i class="bi bi-send-check"></i> Release Results to All
            </button>
        </form>
    @endif

    <!-- Back to Dashboard button -->
    <div class="text-center mt-4">
        <a href="{{ route('adminDashboard') }}" class="btn btn-secondary btn-lg rounded-pill">
            <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
