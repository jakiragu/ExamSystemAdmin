@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0">
                            <i class="fas fa-user-edit text-primary me-2"></i>Edit Admin
                        </h2>
                        <a href="{{ route('manage-admins.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Please fix these issues:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('manage-admins.update', $admin->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="AdminName" class="form-label fw-semibold">
                                <i class="fas fa-user me-1 text-muted"></i> Username
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   name="AdminName" 
                                   id="AdminName" 
                                   value="{{ old('AdminName', $admin->AdminName) }}" 
                                   required
                                   placeholder="Admin username">
                            <div class="invalid-feedback">
                                Please provide a valid username.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="Email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-1 text-muted"></i> Email Address
                            </label>
                            <input type="email" 
                                   class="form-control form-control-lg" 
                                   name="Email" 
                                   id="Email" 
                                   value="{{ old('Email', $admin->Email) }}" 
                                   required
                                   placeholder="admin@example.com">
                            <div class="invalid-feedback">
                                Please provide a valid email address.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-1 text-muted"></i> New Password
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control form-control-lg" 
                                       name="password" 
                                       id="password" 
                                       placeholder="Leave blank to keep current">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted mt-1">
                                Minimum 8 characters with at least one number and special character
                            </small>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="is_super" 
                                       id="is_super"
                                       {{ old('is_super', $admin->is_super) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_super">
                                    <i class="fas fa-shield-alt me-1 text-muted"></i> Super Admin Privileges
                                </label>
                                <small class="form-text text-muted d-block mt-1">
                                    Super admins have full access to all system features
                                </small>
                            </div>
                        </div>

                        <div class="d-grid gap-3 d-md-flex justify-content-md-end mt-4 pt-2">
                            <a href="{{ route('manage-admins.index') }}" class="btn btn-lg btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-lg btn-primary">
                                <i class="fas fa-save me-1"></i> Update Admin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }
    .form-label {
        margin-bottom: 0.5rem;
    }
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.5em;
    }
    .card {
        border-radius: 0.75rem;
    }
    .toggle-password {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    // Form validation
    (function () {
        'use strict'
        
        const forms = document.querySelectorAll('.needs-validation')
        
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
    })()
    
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
    });

    // Confirm before leaving if form has changes
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const initialData = new FormData(form);
        let formChanged = false;

        form.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('change', () => {
                formChanged = true;
            });
        });

        window.addEventListener('beforeunload', (e) => {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
            }
        });
    });
</script>
@endpush