import React, { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import axios from 'axios';
import { registerCandidate } from '../api/candidateApi';

const StudentRegistration: React.FC = () => {
  const navigate = useNavigate();

  const [formData, setFormData] = useState({
    FullName: '',
    Email: '',
    Organization: '',
    Occupation: '',
    MobileNo: '',
    password: '',
    password_confirmation: '',
  });

  const [errors, setErrors] = useState<{ [key: string]: string[] }>({});
  const [loading, setLoading] = useState(false);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };
  const handleSubmit = async (e: React.FormEvent) => {
  e.preventDefault();
  setErrors({});
  setLoading(true);

  try {
    // Step 1: Set CSRF cookie
    await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie', {
      withCredentials: true,
    });

    // Step 2: Register candidate
    const response = await registerCandidate(formData); // Make sure this returns full Axios response

    if (response.status === 201 && response.data.candidate) {
      console.log('Registration success:', response.data);

      // Step 3: Log in candidate immediately
      ;

      // Step 4: Navigate to dashboard
      console.log('Navigating to dashboard...');
      navigate('/dashboard');
    } else {
      console.warn('Unexpected registration response:', response);
      alert('Unexpected response. Please try again.');
    }
  } catch (error: any) {
    if (error.response?.status === 422) {
      setErrors(error.response.data.errors);
    } else if (!error.response) {
      alert('Network error. Please check your connection.');
    } else {
      console.error('Registration failed:', error);
      alert('Registration failed. Please try again.');
    }
  } finally {
    setLoading(false);
  }
};


  return (
    <div className="container mt-5" style={{ maxWidth: '600px' }}>
      <div className="card shadow-sm p-4">
        <h2 className="mb-4 text-center">🎓 Student Registration</h2>
        <form onSubmit={handleSubmit}>
          {[
            { label: 'Full Name', name: 'FullName' },
            { label: 'Email', name: 'Email' },
            { label: 'Organization', name: 'Organization' },
            { label: 'Occupation', name: 'Occupation' },
            { label: 'Mobile Number', name: 'MobileNo' },
          ].map(({ label, name }) => (
            <div key={name} className="mb-3">
              <label className="form-label">{label}</label>
              <input
                type="text"
                name={name}
                value={(formData as any)[name]}
                onChange={handleChange}
                required
                className={`form-control ${errors[name] ? 'is-invalid' : ''}`}
              />
              {errors[name] && (
                <div className="invalid-feedback d-block">{errors[name][0]}</div>
              )}
            </div>
          ))}

          <div className="mb-3">
            <label className="form-label">Password</label>
            <input
              type="password"
              name="password"
              value={formData.password}
              onChange={handleChange}
              required
              className={`form-control ${errors.password ? 'is-invalid' : ''}`}
            />
            {errors.password && (
              <div className="invalid-feedback d-block">{errors.password[0]}</div>
            )}
          </div>

          <div className="mb-3">
            <label className="form-label">Confirm Password</label>
            <input
              type="password"
              name="password_confirmation"
              value={formData.password_confirmation}
              onChange={handleChange}
              required
              className={`form-control ${errors.password_confirmation ? 'is-invalid' : ''}`}
            />
            {errors.password_confirmation && (
              <div className="invalid-feedback d-block">
                {errors.password_confirmation[0]}
              </div>
            )}
          </div>

          <button
            type="submit"
            disabled={loading}
            className="btn btn-primary w-100"
          >
            {loading ? 'Registering...' : 'Register'}
          </button>

          <div className="text-center mt-3">
            Already have an account? <Link to="/login">Log in</Link>
          </div>
        </form>
      </div>
    </div>
  );
};

export default StudentRegistration;