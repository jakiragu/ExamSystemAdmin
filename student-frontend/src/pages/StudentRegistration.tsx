import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
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
      await axios.get('http://localhost:8000/sanctum/csrf-cookie', {
        withCredentials: true,
      });

      // Step 2: Register student
      const response = await registerCandidate(formData);

      if (response.status === 'success') {
        console.log('Registration success:', response);
        navigate('/dashboard', { state: { candidate: response.candidate } });
      } else {
        console.warn('Unexpected response:', response);
      }
    } catch (error: any) {
      if (error.response?.status === 422) {
        setErrors(error.response.data.errors);
      } else if (!error.response) {
        alert('Network error. Please check your connection.');
      } else {
        console.error('Registration failed:', error);
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div style={{ maxWidth: '600px', margin: 'auto', padding: '2rem' }}>
      <h2 className="mb-4">🎓 Student Registration</h2>
      <form onSubmit={handleSubmit}>
        {['FullName', 'Email', 'Organization', 'Occupation', 'MobileNo'].map((field) => (
          <div key={field} className="mb-3">
            <label className="form-label">
              {field}
              <input
                type="text"
                name={field}
                value={(formData as any)[field]}
                onChange={handleChange}
                required
                className="form-control"
              />
            </label>
            {errors[field] && (
              <div className="text-danger small">{errors[field][0]}</div>
            )}
          </div>
        ))}
        <button
          type="submit"
          disabled={loading}
          className="btn btn-primary w-100"
        >
          {loading ? 'Registering...' : 'Register'}
        </button>
      </form>
    </div>
  );
};

export default StudentRegistration;