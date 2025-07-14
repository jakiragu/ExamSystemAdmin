<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login - Oracle Database Exam</title>
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f9f9f9;
    }
    .page-title {
      color: #3F2B96;
      font-weight: 600;
    }
    .btn-purple {
      background-color: #3F2B96;
      color: white;
    }
    .btn-purple:hover {
      background-color: #2e2074;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container my-5 p-5 bg-white shadow rounded-4" style="max-width: 600px;">
    <h2 class="text-center page-title mb-4">Admin Login</h2>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('Admin.submit') }}" method="post">
      @csrf
      <div class="mb-3">
        <label for="Email" class="form-label">Email</label>
        <input type="email" class="form-control border-0 bg-light" id="Email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
      </div>

      <div class="mb-4">
        <label for="Password" class="form-label">Password</label>
        <input type="password" class="form-control border-0 bg-light" id="Password" name="password" placeholder="••••••••" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-purple rounded-pill">Login</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
