import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import axiosInstance from '../api/axiosInstance';


const CandidateLogin: React.FC = () => {
  const navigate = useNavigate();

  const [formData, setFormData] = useState({
    Email: '',
    password: '',
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
      await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie', {
        withCredentials: true,
      });

      const response = await axios.post(
        'http://127.0.0.1:8000/api/candidates/login',
        formData,
        { withCredentials: true }
      );

      if (response.data.status === 'success') {
        // Save candidate in localStorage for persistence
        localStorage.setItem('candidate', JSON.stringify(response.data.candidate));
        navigate('/dashboard', { state: { candidate: response.data.candidate } });
      } else {
        alert('Login failed. Please check your credentials.');
      }
    } catch (error: any) {
      if (error.response?.status === 422) {
        setErrors(error.response.data.errors);
      } else {
        alert('Login error. Please try again.');
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="container mt-5" style={{ maxWidth: '500px' }}>
      <h2 className="mb-4 text-center">🔐 Candidate Login</h2>
      <form onSubmit={handleSubmit}>
        <div className="mb-3">
          <label className="form-label">Email</label>
          <input
            type="email"
            name="Email"
            value={formData.Email}
            onChange={handleChange}
            required
            className="form-control"
          />
          {errors.Email && (
            <div className="text-danger small">{errors.Email[0]}</div>
          )}
        </div>

        <div className="mb-3">
          <label className="form-label">Password</label>
          <input
            type="password"
            name="password"
            value={formData.password}
            onChange={handleChange}
            required
            className="form-control"
          />
          {errors.password && (
            <div className="text-danger small">{errors.password[0]}</div>
          )}
        </div>

        <button
          type="submit"
          disabled={loading}
          className="btn btn-success w-100"
        >
          {loading ? 'Logging in...' : 'Login'}
        </button>

        <div className="text-center mt-3">
          New here?{' '}
          <a href="/student/register" className="text-decoration-none">
            Register
          </a>
        </div>
      </form>
    </div>
  );
};

export default CandidateLogin;
