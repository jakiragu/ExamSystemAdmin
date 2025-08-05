@extends('layouts.base')

@section('content')
<div id="student-spa"
     data-student="{{ json_encode(session('student')) }}"
     data-visible-exams="{{ json_encode($visibleExams) }}"
     data-session-id="{{ session()->getId() }}">
</div>
@vite('resources/js/studentApp.js')
@endsection