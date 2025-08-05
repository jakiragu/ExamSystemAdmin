<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="#">Exam Admin</a>
    <div class="ms-auto">
        <a href="{{ url('/adminDashboard') }}" class="btn btn-sm btn-outline-light">Back to Home</a>
    </div>
</nav>

<main class="py-4">
    @yield('content')
</main>

</body>
</html>
