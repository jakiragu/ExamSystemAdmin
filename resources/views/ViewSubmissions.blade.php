<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oracle Database Administration Exam</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- @vite(['resources/js/app.js', 'resources/js/Timer.js']) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
  <body>
  <div class=" row container bg-light my-5 mx-auto pt-3 justify-content-center" id="background">

   
    <div class="ms-1 justify-content-center row">
    
        <div class="col-md-8 my-4 text-center" style="font-size:xx-large;"> Student Submissions: </div>
        
        <div class="col-md-6 mb-3 ">
        <table class="table text-center border border-0 mb-3" id="background">
    <thead>
        <tr>
        <th scope="col">CertificationID</th>
        <th scope="col">Full Name</th>
        <th scope="col">Submission</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
        <th scope="row">{{$student->CertificationID}}</th>
        <td>{{$student->FullName}}</td>
        <td><a href="{{route('ViewAnswers', ['id'=>$student->CertificationID])}}">View Submission</a></td>
        </tr>
        @endforeach

    </tbody>
    </table>
        </div>
    </div>
    <a class="btn btn-primary  btn-sm col-md-1 me-2 mt-5 mb-3 offset-md-11 rounded-pill text-opacity-25" href="{{route('adminDashboard')}}" role="button">Back</a>
</div>
  </body>
</html>
