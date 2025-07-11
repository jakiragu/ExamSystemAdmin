<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Answers - Oracle Database Exam</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
  <body>
    <div class="container bg-light my-5 pt-3">
        <div class="text-center mb-4">
            <h2>Oracle Database Administration Exam</h2>
            <h5>Student: {{ $student->FullName }} ({{ $student->CertificationID }})</h5>
        </div>

        <div class="col-md-10 mx-auto">
            @foreach($answers as $answer)
                @php
                    $QID = $answer->QuestionID;
                @endphp
                <div class="card my-3">
                    <div class="card-header">
                        Question {{ $question[$QID]->QuestionID }}: {{ $question[$QID]->title }}
                    </div>
                    <div class="card-body">
                        <p><strong>Text:</strong> {{ $question[$QID]->text }}</p>
                        <p><strong>Answer:</strong> {{ $answer->text }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <a class="btn btn-primary mt-4" href="{{ url()->previous() }}">Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
