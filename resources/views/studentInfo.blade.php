<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>StudentInfo</title>
</head>
<body>
<div class=" row container bg-light my-5 mx-auto pt-3 justify-content-center" id="background">

<div class=" col col-md-2 lightgray rounded text-center align-self-center offset-md-1"> Time Remaining:<br>3 Hours left</div>

<div class="ms-1 col row">

<div class="col-md-9 my-4" style="font-size:xx-large;"> Oracle Database Administration Exam</div>
    
    <div class="col-md-7 mb-3 ">
    <table class="table text-center border border-0" id="background">
    <thead>
        <tr>
        <th scope="col">CertificationID</th>
        <th scope="col">Full Name</th>
        <th scope="col">Email</th>
        <th scope="col">Organisation</th>
        <th scope="col">Occupation</th>
        <th scope="col">MobileNo</th>
        <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
        <th scope="row">{{$student->CertificationID}}</th>
        <td>{{$student->FullName}}</td>
        <td>{{$student->Email}}</td>
        <td>{{$student->Organization}}</td>
        <td>{{$student->Occupation}}</td>
        <td>{{$student->MobileNo}}</td>
        <td>Pending...</td>
        </tr>
        @endforeach

    </tbody>
    </table>

    </div>
</div>
<a class="btn btn-primary  btn-sm col-md-1 my-5 rounded-pill text-opacity-25" href="{{route('adminDashboard')}}" role="button">Back</a>
</div>
</body>
</html>

