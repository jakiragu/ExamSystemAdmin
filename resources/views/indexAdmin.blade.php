@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0"><i class="fas fa-user-shield me-2"></i>Admin Management</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/adminDashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Admins</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="/adminDashboard" class="btn btn-outline-secondary me-2">
                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
            </a>
            <a href="{{ route('manage-admins.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Add Admin
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Admin</th>
                            <th>Privileges</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3 bg-light-primary p-2 rounded">
                                            <i class="fas fa-user-cog fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $admin->AdminName }}</h6>
                                            <small class="text-muted">{{ $admin->Email ?? 'No Email' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($admin->is_super)
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="fas fa-star me-1"></i> Super Admin
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                            <i class="fas fa-user me-1"></i> Regular Admin
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('manage-admins.edit', $admin->id) }}" 
                                           class="btn btn-sm btn-outline-primary rounded-pill"
                                           data-bs-toggle="tooltip" title="Edit Admin">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('manage-admins.destroy', $admin->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger rounded-pill"
                                                    onclick="return confirm('Are you sure? This will permanently delete this admin.')"
                                                    data-bs-toggle="tooltip" title="Delete Admin">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-user-slash fs-1 text-muted"></i>
                                        <h5 class="mt-3">No Admins Found</h5>
                                        <p class="text-muted">Click the button above to add a new admin</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Only show pagination if $admins is a paginator instance --}}
    @if(method_exists($admins, 'hasPages') && $admins->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $admins->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
    .breadcrumb {
        font-size: 0.85rem;
        padding: 0;
        background: transparent;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush