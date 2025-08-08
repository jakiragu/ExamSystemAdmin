import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { registerCandidate } from '../api/candidateApi';

const StudentRegister: React.FC = () => {
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
      <h2>Student Registration</h2>
      <form onSubmit={handleSubmit}>
        {['FullName', 'Email', 'Organization', 'Occupation', 'MobileNo'].map((field) => (
          <div key={field} style={{ marginBottom: '1rem' }}>
            <label style={{ display: 'block', marginBottom: '0.5rem' }}>
              {field}:
              <input
                type="text"
                name={field}
                value={(formData as any)[field]}
                onChange={handleChange}
                required
                style={{
                  width: '100%',
                  padding: '0.5rem',
                  border: '1px solid #ccc',
                  borderRadius: '4px',
                }}
              />
            </label>
            {errors[field] && (
              <div style={{ color: 'red', fontSize: '0.9rem' }}>{errors[field][0]}</div>
            )}
          </div>
        ))}
        <button
          type="submit"
          disabled={loading}
          style={{
            padding: '0.75rem 1.5rem',
            backgroundColor: '#007bff',
            color: '#fff',
            border: 'none',
            borderRadius: '4px',
            cursor: loading ? 'not-allowed' : 'pointer',
          }}
        >
          {loading ? 'Registering...' : 'Register'}
        </button>
      </form>
    </div>
  );
};

export default StudentRegister;