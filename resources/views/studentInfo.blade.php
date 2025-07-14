<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Info</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
        }
        #background {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }
        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            color: #3F2B96;
        }
        .btn-purple {
            background-color: #3F2B96;
            color: #fff;
        }
        .btn-purple:hover {
            background-color: #2e2074;
            color: #fff;
        }
        .btn-orange {
            background-color: #FD7E14;
            color: #fff;
        }
        .btn-orange:hover {
            background-color: #e96b0f;
            color: #fff;
        }
        table th, table td {
            vertical-align: middle !important;
        }
    </style>
</head>
<body>
<div class="container my-5" id="background">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="dashboard-title">
            <i class="bi bi-people-fill me-2"></i>Student Info
        </div>
        <div class="text-center bg-light rounded px-3 py-2 border">
            <strong>Time Remaining:</strong><br>3 Hours left
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Certification ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Organization</th>
                    <th>Occupation</th>
                    <th>Mobile No</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->CertificationID }}</td>
                    <td>{{ $student->FullName }}</td>
                    <td>{{ $student->Email }}</td>
                    <td>{{ $student->Organization }}</td>
                    <td>{{ $student->Occupation }}</td>
                    <td>{{ $student->MobileNo }}</td>
                    <td>Pending...</td>
                    <td>
                        <form action="{{ route('deleteStudent', $student->CertificationID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-orange btn-sm rounded-pill"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a class="btn btn-purple btn-sm rounded-pill mt-4" href="{{ route('adminDashboard') }}">
        <i class="bi bi-arrow-left-circle"></i> Back
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
