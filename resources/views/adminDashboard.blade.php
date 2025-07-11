<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oracle Database Administration Exam</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/js/app.js', 'resources/js/Timer.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
  <body>
<div class="row container bg-light my-5 mx-auto pt-3 justify-content-center" id="background">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('admin_name'))
    <div class="alert alert-info mt-3" role="alert">
        Logged in as: <strong>{{ session('admin_name') }}</strong>
    </div>
    @endif

    <div class="col col-md-2 bg-light rounded text-center align-self-center border p-2"> 
        <strong>Time Remaining:</strong><br>
        <span id="timer" class="fw-bold">00:00:00</span>
    </div>
   
    <div class="col row">
        <div class="col-md-9 mt-4 mb-3" style="font-size:xx-large;"> Oracle Database Administration Examiner Dashboard</div>        

        <div class="row col-md-7 mb-3 ms-5">
            <div class="col row gy-3">
                <a class="btn btn-primary btn-sm col-md-12 rounded-pill" href="{{ route('studentInfo') }}" role="button">Check Student Info</a>
                <a class="btn btn-primary btn-sm col-md-12 rounded-pill" href="{{ route('StartTimer') }}" role="button">Start Examination</a>
                <a class="btn btn-primary btn-sm col-md-12 rounded-pill" href="{{ route('PauseTimer') }}" role="button">Stop Examination</a>
                <a class="btn btn-secondary btn-sm col-md-12 rounded-pill" href="#" id="toggle">Reset/Adjust Timer</a>
                
                <form class="row row-cols-lg-auto g-3 align-items-center ms-2 mt-0" style="display:none;" action="{{ route('AdjustTimer') }}" method="post">
                    @csrf
                    <div class="col-6" style="width:60px;">
                        <label for="hours" class="form-label">Hours</label>
                        <input type="text" class="form-control" id="hours" maxlength="1" name="hours" value="0">
                    </div>
                    <div class="col-6" style="width:60px;">
                        <label for="minutes" class="form-label">Minutes</label>
                        <input type="text" class="form-control" id="minutes" maxlength="2" name="minutes" value="00">
                    </div>
                    <div class="row justify-content-center mt-3">
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill">Set</button>
                    </div>
                    <div class="row justify-content-center mt-2">
                        <a class="btn btn-warning btn-sm rounded-pill" href="{{ route('ResetTimer') }}" role="button">Reset</a>
                    </div>
                </form>
            </div>
            <div class="col gy-3 row ms-5">
                <a class="btn btn-primary btn-sm col-md-12 rounded-pill" href="{{ route('ViewSubmissions') }}" role="button">Check Exam Submissions</a>
                <a class="btn btn-primary btn-sm col-md-12 rounded-pill" href="{{ route('GradeExam') }}" role="button">Start Exam Grading</a>
                <a class="btn btn-success btn-sm col-md-12 rounded-pill" href="{{ route('ReleaseResults') }}" role="button">Release Results to Students</a>
                <a class="btn btn-primary btn-sm col-md-12 rounded-pill" href="{{ route('ViewQuestions') }}" role="button">View Set Questions</a>
                <a class="btn btn-secondary btn-sm col-md-12 rounded-pill disabled" href="#" role="button">Submit</a>
            </div> 
        </div>
    </div>

    <div class="row justify-content-evenly my-5">
        <a class="btn btn-secondary btn-sm col-md-1 rounded-pill" href="#" role="button">Back</a>
        <a class="btn btn-success btn-sm col-md-1 rounded-pill" href="#" role="button">Submit</a>
        <a class="btn btn-danger btn-sm col-md-1 rounded-pill" href="{{ route('logout') }}" role="button">Logout</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('toggle').addEventListener('click', function(event) {
            event.preventDefault();
            var form = document.querySelector('form');
            if (form.style.display === 'none') {
                form.style.display = '';
            } else {
                form.style.display = 'none';
            }
        });

        // Optional: Auto-hide alerts after 5 sec
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                new bootstrap.Alert(alert).close();
            });
        }, 5000);
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
