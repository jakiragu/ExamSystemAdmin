<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oracle Database Administration Exam</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
  <body>
<div class=" container bg-light my-5 mx-auto pt-3 justify-content-center" id="background">

      <div class="mx-auto row">
    
        <div class="col-md-9 offset-md-2 mt-5 mb-3" style="font-size:xx-large;"> Oracle Database Administration Exam</div>
        
        <div class="my-5 ms-5">
            <form action="{{route('Admin.store')}}" method="post">
                @csrf
                @if($errors->any())
                <div class="alert alert-danger col-md-4 offset-md-2">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                  </div>
                @endif
                <div class="row my-4 gx-0">
                  <label for="Username" class="col-md-2 col-form-label offset-md-2 ">Username</label>
                  <div class="col-md-4">
                    <input type="text" class="lightgray form-control border border-0 " id="Username" name="AdminName">
                  </div>
                </div>
                <div class="row my-4 gx-0">
                  <label for="Email" class="col-md-2 col-form-label offset-md-2 ">Email</label>
                  <div class="col-md-4">
                    <input type="text" class="lightgray form-control border border-0 " id="Email" name="Email">
                  </div>
                </div>
                <div class="row mb-5 pb-5 gx-0">
                    <label for="Password" class="col-md-2 form-label offset-md-2">Password</label>
                    <div class="col-md-4">
                      <input type="password" class="lightgray form-control border border-0 " id="Password" name="password">
                </div>
                  </div>
                
        
                <button type="submit" class="btn btn-primary btn-sm col-md-1 rounded-pill offset-md-4 my-5">Login</button>
            </form>
        </div>
    </div>
   
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>