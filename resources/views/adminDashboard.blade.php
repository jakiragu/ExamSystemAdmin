<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oracle Database Administration Exam</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    @vite(['resources/js/app.js', 'resources/js/Timer.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
  <body>
<div class=" row container bg-light my-5 mx-auto pt-3 justify-content-center" id="background">

<div class="col col-md-2 lightgray rounded text-center align-self-center"> Time Remaining:<br><span id="timer">00:00:00</span></div>
   
    <div class=" col row ">
    
        <div class="col-md-9 mt-4 mb-3" style="font-size:xx-large;"> Oracle Database Administration Examiner Dashboard</div>        
        <!-- @if(session('admin_logged_in'))
        <h1>Welcome, {{session('admin_name')}}</h1>
        @endif -->
            <div class="row col-md-7 mb-3 ms-5">
                <div class="col row gy-3">
                  <a class="btn btn-primary btn-sm col-md-12 rounded-pill text-opacity-25" href="{{route('studentInfo')}}" role="button">Check Student Info</a>
                  <a class="btn btn-primary btn-sm col-md-12 rounded-pill text-opacity-25" href="{{route('StartTimer')}}" role="button">Start Examination</a>
                  <a class="btn btn-primary btn-sm col-md-12 rounded-pill text-opacity-25" href="{{route('PauseTimer')}}" role="button">Stop Examination</a>
                  <a class="btn btn-primary btn-sm col-md-12 rounded-pill text-opacity-25" href="" id="toggle">Reset/Adjust Timer</a>
                  <form class="row row-cols-lg-auto g-3 align-items-center ms-2 mt-0" style="display:none;" action="{{route('AdjustTimer')}}" method="post">
                          @csrf
                          <div class="col-6" style="width:60px;">
                            <label for="formGroupExampleInput" class="form-label">Hours</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" maxlength="1" name="hours" value="0">
                          </div>
                          <div class="col-6" style="width:60px;">
                            <label for="formGroupExampleInput2" class="form-label">Minutes</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" maxlength="2" name="minutes" value="00">
                          </div>
                          <div class="row justify-content-center mt-5"><button type="submit" class="btn btn-primary btn-sm rounded-pill" name="SetTime">Set</button></div>
                          <div class="row justify-content-center mt-5"><a class="btn btn-primary btn-sm rounded-pill" href="{{route('ResetTimer')}}" role="button">Reset</a>
                          </div>

                      </form>
                    
                </div>
                <div class="col gy-3 row ms-5">
                    <a class="btn btn-primary btn-sm col-md-12 rounded-pill text-opacity-25" href="{{route('ViewSubmissions')}}" role="button">Check Exam Submissions</a>
                    <a class="btn btn-primary btn-sm col-md-12 rounded-pill text-opacity-25" href="{{route('GradeExam')}}" role="button">Start Exam Grading</a>
                    <a class="btn btn-primary btn-sm col-md-12 rounded-pill text-opacity-25 " style="visibility:hidden;" href="#" role="button">Submit</a>
                    <a class="btn btn-primary btn-sm col-md-12 rounded-pill text-opacity-25" style="visibility:hidden;" href="#" role="button">Submit</a>

                </div> 
            </div>
    </div>
    <div class="row justify-content-evenly my-5">
    <a class="btn btn-primary btn-sm col-md-1 rounded-pill text-opacity-25" href="#" role="button">Back</a>
    <a class="btn btn-primary btn-sm col-md-1 rounded-pill text-opacity-25" href="#" role="button">Submit</a>

    <a class="btn btn-primary btn-sm col-md-1 rounded-pill text-opacity-25" href="{{route('logout')}}" role="button">Logout</a>
</div>
</div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('toggle').addEventListener('click', function() {
          event.preventDefault();
          var form = document.querySelector('form');
          if (form.style.display === 'none') {
            form.style = '';
          } else {
            form.style.display = 'none';
          }
        });
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>