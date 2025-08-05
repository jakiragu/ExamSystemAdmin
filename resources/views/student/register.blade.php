@extends('layouts.base')

@section('content')
<div class="container mt-5">
    <h2>Student Registration</h2>
    <form method="POST" action="{{ route('student.register.submit') }}">
        @csrf
        <div class="mb-3">
            <label for="reg_no" class="form-label">Registration Number</label>
            <input type="text" class="form-control" name="reg_no" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <button type="submit" class="btn btn-success">Enter Portal</button>
    </form>
</div>
@endsection