<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oracle Database Administration Exam</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/js/app.js', 'resources/js/Timer.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
        }
        #background {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.05);
            padding: 30px;
        }
        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            color: #3F2B96;
            letter-spacing: 0.5px;
        }
        .timer-box {
            background: #f1f3f5;
            border-radius: 8px;
            padding: 18px;
        }
        .btn-custom {
            font-weight: 500;
            transition: all 0.3s ease;
            color: #fff;
        }
        .btn-blue {
            background-color: #3F2B96;
            border-color: #3F2B96;
        }
        .btn-blue:hover {
            background-color: #2e2074;
            border-color: #2e2074;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-1px);
        }
        .btn-orange {
            background-color: #FD7E14;
            border-color: #FD7E14;
        }
        .btn-orange:hover {
            background-color: #e96b0f;
            border-color: #e35b0d;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-1px);
        }
        .section-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            background: #ffffff;
        }
        .section-header {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            color: #3F2B96;
        }
    </style>
</head>
<body>
<div class="container my-5" id="background">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('admin_name'))
        <div class="alert alert-info" role="alert">
            Logged in as: <strong>{{ session('admin_name') }}</strong>
        </div>
    @endif

    <!-- Header Row -->
    <div class="row mb-4">
        <div class="col-md-3 timer-box text-center">
            <strong>Time Remaining</strong><br>
            <span id="timer" class="fw-bold fs-4">00:00:00</span>
        </div>
        <div class="col-md-9 d-flex align-items-center">
            <div class="dashboard-title">
                <i class="bi bi-speedometer2 me-2"></i>Examiner Dashboard
            </div>
        </div>
    </div>

    <!-- Main Sections -->
    <div class="row g-4">
        <!-- Time & Control Section -->
        <div class="col-md-6">
            <div class="section-card">
                <div class="section-header"><i class="bi bi-clock-history me-2"></i>Time & Control</div>
                <div class="d-grid gap-3">
                    <a class="btn btn-blue btn-sm btn-custom rounded-pill" href="{{ route('studentInfo') }}">
                        <i class="bi bi-people-fill me-1"></i>Check Student Info
                    </a>
                    <a class="btn btn-blue btn-sm btn-custom rounded-pill" href="{{ route('StartTimer') }}">
                        <i class="bi bi-play-fill me-1"></i>Start Examination
                    </a>
                    <a class="btn btn-orange btn-sm btn-custom rounded-pill" href="{{ route('PauseTimer') }}">
                        <i class="bi bi-pause-fill me-1"></i>Stop Examination
                    </a>
                    <a class="btn btn-orange btn-sm btn-custom rounded-pill" href="#" id="toggle">
                        <i class="bi bi-arrow-repeat me-1"></i>Reset/Adjust Timer
                    </a>

                    <!-- Adjust Timer Form -->
                    <form class="row row-cols-lg-auto g-3 align-items-center" style="display:none;" action="{{ route('AdjustTimer') }}" method="post">
                        @csrf
                        <div class="col-6" style="width:80px;">
                            <label for="hours" class="form-label">Hours</label>
                            <input type="text" class="form-control" id="hours" maxlength="1" name="hours" value="0">
                        </div>
                        <div class="col-6" style="width:90px;">
                            <label for="minutes" class="form-label">Minutes</label>
                            <input type="text" class="form-control" id="minutes" maxlength="2" name="minutes" value="00">
                        </div>
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-blue btn-sm btn-custom rounded-pill">
                                <i class="bi bi-check-circle me-1"></i>Set
                            </button>
                            <a class="btn btn-orange btn-sm btn-custom rounded-pill" href="{{ route('ResetTimer') }}">
                                <i class="bi bi-x-circle me-1"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Exam & Results Section -->
        <div class="col-md-6">
            <div class="section-card">
                <div class="section-header"><i class="bi bi-journal-text me-2"></i>Exam & Results</div>
                <div class="d-grid gap-3">
                    <a class="btn btn-blue btn-sm btn-custom rounded-pill" href="{{ route('ViewSubmissions') }}">
                        <i class="bi bi-folder-check me-1"></i>Check Submissions
                    </a>
                    <a class="btn btn-blue btn-sm btn-custom rounded-pill" href="{{ route('GradeExam') }}">
                        <i class="bi bi-pencil-square me-1"></i>Start Grading
                    </a>
                    <a class="btn btn-blue btn-sm btn-custom rounded-pill" href="{{ route('ManageResults') }}">
                        <i class="bi bi-list-check me-1"></i>Manage Results
                    </a>
                    <a class="btn btn-orange btn-sm btn-custom rounded-pill" href="{{ route('ViewQuestions') }}">
                        <i class="bi bi-question-circle me-1"></i>View Set Questions
                    </a>
                </div>
            </div>
