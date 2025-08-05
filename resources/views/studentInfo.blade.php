<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Info</title>

    {{-- Styles --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f8;
        }

        .page-wrapper {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-top: 40px;
        }

        .dashboard-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #3F2B96;
        }

        .btn-purple {
            background-color: #3F2B96;
            color: #fff;
        }

        .btn-purple:hover {
            background-color: #2e2074;
        }

        .badge-status {
            font-size: 0.85rem;
        }

        tbody tr:hover {
            background-color: #f8f9fc;
        }

        .table th, .table td {
            vertical-align: middle !important;
        }

        .toast-container {
            z-index: 1055;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-wrapper">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="dashboard-title">
                <i class="bi bi-people-fill me-2"></i> Student Info
            </div>
            <div class="bg-light px-3 py-2 rounded border text-center">
                <strong>Time Remaining</strong><br>
                <span class="text-success fw-semibold">3 Hours left</span>
            </div>
        </div>

        {{-- Toast Success --}}
        @if(session('success'))
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div class="toast align-items-center text-bg-success border-0 show" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Student Table --}}
        <div class="table-responsive">
            <table class="table table-hover text-center">
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
                        <td>
                            <span class="badge rounded-pill bg-warning text-dark badge-status">Pending</span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-orange btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-gear-fill me-1"></i> Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ route('deleteStudent', $student->CertificationID) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash3-fill me-2"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                    {{-- Future actions like Edit/View can be added here --}}
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- Back Button --}}
        <div class="text-start">
            <a href="{{ route('adminDashboard') }}" class="btn btn-purple btn-sm rounded-pill mt-4">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>