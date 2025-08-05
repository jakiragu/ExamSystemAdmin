@extends('layouts.admin') {{-- Reuse your dashboard layout --}}
@section('title', 'Candidate Submissions')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
            <h4><i class="bi bi-check2-square me-2"></i>Submitted Candidates</h4>
            <a href="{{ route('adminDashboard') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Back
            </a>
        </div>

        <div class="card-body">
            @if($candidates->isEmpty())
                <div class="alert alert-warning text-center">
                    No submissions found.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Occupation</th>
                                <th>Answers Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submittedCandidates as $candidate)
                                <tr>
                                    <td>{{ $candidate->FullName }}</td>
                                    <td>{{ $candidate->Email }}</td>
                                    <td>{{ $candidate->MobileNo }}</td>
                                    <td>{{ $candidate->Occupation }}</td>
                                    <td>
                                        <span class="badge bg-success rounded-pill">{{ $candidate->answers_count }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('ViewCandidateAnswers', $candidate->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="bi bi-search"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection