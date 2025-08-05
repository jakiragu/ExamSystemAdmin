<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examiner Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .nav-link:hover {
            background-color: #f1f1f1;
        }

        .card-title {
            font-size: 1.2rem;
        }

        .card-text {
            font-size: 0.95rem;
        }

        .timer-box {
            background: #e9ecef;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 1.2rem;
        }

        #timer {
            color: #0d6efd;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-white shadow-sm" style="min-height: 100vh;">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-4 text-dark">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                    <span class="fs-4 fw-bold"><i class="bi bi-speedometer2 me-2"></i>Dashboard</span>
                </a>
                <ul class="nav nav-pills flex-column mb-auto w-100 mt-4">
                    <li><a href="{{ route('studentInfo') }}" class="nav-link text-dark"><i class="bi bi-people-fill me-2"></i>Student Info</a></li>
                    <li><a href="{{ route('ViewSubmissions') }}" class="nav-link text-dark"><i class="bi bi-folder-check me-2"></i>Submissions</a></li>
                    <li><a href="{{ route('GradeExam') }}" class="nav-link text-dark"><i class="bi bi-pencil-square me-2"></i>Grading</a></li>
                    <li><a href="{{ route('ManageResults') }}" class="nav-link text-dark"><i class="bi bi-list-check me-2"></i>Results</a></li>
                    <li><a href="{{ route('admin.exam-catalogs.index') }}" class="nav-link text-dark"><i class="bi bi-folder2-open me-2"></i>Catalogs</a></li>
                    <li><a href="{{ route('admin.exam-objectives.index') }}" class="nav-link text-dark"><i class="bi bi-bullseye me-2"></i>Objectives</a></li>
                    <li><a href="{{ route('admin.subject-areas.index') }}" class="nav-link text-dark"><i class="bi bi-diagram-3 me-2"></i>Subjects</a></li>
                    <li><a href="{{ route('admin.lab-environments.index') }}" class="nav-link text-dark"><i class="bi bi-pc-display me-2"></i>Labs</a></li>
                    <li><a href="{{ route('admin.exam-questions.index') }}" class="nav-link text-dark"><i class="bi bi-ui-checks me-2"></i>Questions</a></li>
                </ul>
                <hr>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col py-4">
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('admin_name'))
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-person-check-fill me-2"></i>
                        <div>Logged in as: <strong>{{ session('admin_name') }}</strong></div>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h4 text-primary"><i class="bi bi-speedometer2 me-2"></i>Examiner Dashboard</h1>
                    <div class="timer-box text-center">
                        <strong>Time Remaining</strong><br>
                        <span id="timer" class="fw-bold">00:00:00</span>
                    </div>
                </div>

                <!-- 💡 Dynamic Exam Controls -->
               <!-- Exam Selector Dropdown -->
 <div class="d-flex flex-wrap align-items-center gap-2 mt-3">

              
<select name="exam_id" id="exam_id" class="form-select w-auto" required>
    <option value="" selected disabled>Choose Exam</option>
    @foreach($catalogs as $catalog)
        <option value="{{ $catalog->id }}">{{ $catalog->exam_code }} - {{ $catalog->exam_title }}</option>
    @endforeach
</select>

<!-- Individual Exam Action Forms -->
<div class="d-flex gap-2 mt-3 flex-wrap">
    <form method="POST" id="startExamForm">
        @csrf
        <button type="submit" class="btn btn-outline-success btn-sm" id="startBtn">
            <i class="bi bi-play-fill me-1"></i> Start
        </button>
    </form>

    <form method="POST" id="pauseExamForm">
        @csrf
        <button type="submit" class="btn btn-outline-warning btn-sm" id="pauseBtn">
            <i class="bi bi-pause-fill me-1"></i> Pause
        </button>
    </form>

    <form method="POST" id="stopExamForm">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm" id="stopBtn">
            <i class="bi bi-stop-fill me-1"></i> Stop
        </button>
    </form>

    <form method="POST" id="resetExamForm">
        @csrf
        <button type="submit" class="btn btn-outline-secondary btn-sm" id="resetBtn">
            <i class="bi bi-arrow-repeat me-1"></i> Reset
        </button>
    </form>
</div>
</div>
<br>

                <!-- Summary Cards -->
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-people me-2"></i> Students</h5>
                                <p class="card-text">Check student details & readiness.</p>
                                <a href="{{ route('studentInfo') }}" class="btn btn-sm btn-outline-primary">View Students</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-pc-display me-2"></i> Lab Environments</h5>
                                <p class="card-text">Manage pre-configured lab environments.</p>
                                <a href="{{ route('admin.lab-environments.index') }}" class="btn btn-sm btn-outline-primary">Manage Labs</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-folder-check me-2"></i> Submissions</h5>
                                <p class="card-text">Track and evaluate exam submissions.</p>
                                <a href="{{ route('ViewSubmissions') }}" class="btn btn-sm btn-outline-primary">Check Submissions</a>
                            </div>
                        </div>
                    </div>
                </div>

                @if(auth('admin')->user() && auth('admin')->user()->is_super)
                    <div class="row g-3 mt-1">
                        <div class="col-md-4">
                            <div class="card shadow-sm border-success">
                                <div class="card-body">
                                    <h5 class="card-title text-success"><i class="bi bi-person-gear me-2"></i> Manage Admins</h5>
                                    <p class="card-text">Add, update, or remove admin accounts.</p>
                                    <a href="{{ route('manage-admins.index') }}" class="btn btn-sm btn-outline-success">Admin Panel</a>
                </div>
            </div>
        </div>
    </div>
@endif
<script>
    
    function updateExamActionLinks() {
        const examId = document.getElementById('exam_id').value;
        const formActions = {
            startExamForm: 'start',
            pauseExamForm: 'pause',
            stopExamForm: 'stop',
            resetExamForm: 'reset'
        };

        for (const [formId, action] of Object.entries(formActions)) {
            const form = document.getElementById(formId);
            form.action = examId ? `/admin/exams/${examId}/${action}` : '#';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const dropdown = document.getElementById('exam_id');
        dropdown.addEventListener('change', updateExamActionLinks);
        updateExamActionLinks(); // Init
    });
</script>




