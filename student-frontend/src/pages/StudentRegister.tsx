import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

const StudentRegistration: React.FC = () => {
  const navigate = useNavigate();

  const [formData, setFormData] = useState({
    FullName: '',
    Email: '',
    Organization: '',
    Occupation: '',
    MobileNo: '',
    CertificationID: '',
  });

  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setError(null);
    setLoading(true);

    try {
      const response = await axios.post('http://localhost:8000/api/student/register', formData);
      console.log("Registration success:", response.data);

      // Store student data locally
      localStorage.setItem("student", JSON.stringify(response.data.candidate || formData));

      // Navigate to exam landing page (relative to /student basename)
      navigate('/exam-landing');
    } catch (err: any) {
      console.error("Registration error:", err);
      setError(err.response?.data?.message || 'Registration failed. Please try again.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="max-w-md mx-auto p-6 bg-white shadow-md rounded-md">
      <h2 className="text-2xl font-bold mb-4">Student Registration</h2>

      {error && (
        <div className="mb-4 p-2 bg-red-100 text-red-700 rounded">
          {error}
        </div>
      )}

      <form onSubmit={handleSubmit} className="space-y-4">
        {[
          { name: 'FullName', label: 'Full Name' },
          { name: 'Email', label: 'Email' },
          { name: 'Organization', label: 'Organization' },
          { name: 'Occupation', label: 'Occupation' },
          { name: 'MobileNo', label: 'Mobile Number' },
          { name: 'CertificationID', label: 'Certification ID (optional)' },
        ].map(({ name, label }) => (
          <div key={name}>
            <label className="block text-sm font-medium text-gray-700">{label}</label>
            <input
              type="text"
              name={name}
              value={(formData as any)[name]}
              onChange={handleChange}
              className="mt-1 p-2 border border-gray-300 rounded w-full"
              required={name !== 'CertificationID'}
            />
          </div>
        ))}

        <button
          type="submit"
          disabled={loading}
          className={`w-full py-2 rounded text-white ${
            loading ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700'
          }`}
        >
          {loading ? 'Registering...' : 'Register'}
        </button>
      </form>
    </div>
  );
};

export default StudentRegistration;