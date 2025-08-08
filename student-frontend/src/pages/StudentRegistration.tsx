import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { registerCandidate } from '../api/candidateApi.ts';

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

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setErrors({});

    try {
      const response = await registerCandidate(formData);

      if (response.status === 'success') {
        console.log('Registration success:', response);
        // You can pass data via state or context
        navigate('/dashboard', { state: { candidate: response.candidate } });
      }
    } catch (error: any) {
      if (error.response?.status === 422) {
        setErrors(error.response.data.errors);
      } else {
        console.error('Registration failed:', error);
      }
    }
  };

  return (
    <div style={{ maxWidth: '600px', margin: 'auto', padding: '2rem' }}>
      <h2>Student Registration</h2>
      <form onSubmit={handleSubmit}>
        {['FullName', 'Email', 'Organization', 'Occupation', 'MobileNo'].map((field) => (
          <div key={field} style={{ marginBottom: '1rem' }}>
            <label>
              {field}:
              <input
                type="text"
                name={field}
                value={(formData as any)[field]}
                onChange={handleChange}
                required
                style={{ width: '100%', padding: '0.5rem' }}
              />
            </label>
            {errors[field] && (
              <div style={{ color: 'red', fontSize: '0.9rem' }}>{errors[field][0]}</div>
            )}
          </div>
        ))}
        <button type="submit">Register</button>
      </form>
    </div>
  );
};

export default StudentRegister;
