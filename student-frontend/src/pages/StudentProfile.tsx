import React, { useEffect, useState } from 'react';
import axios from 'axios';

interface Candidate {
  id: number;
  FullName: string;
  Email: string;
  Organization: string;
  Occupation: string;
  MobileNo: string;
}

const StudentProfile: React.FC = () => {
  const [candidate, setCandidate] = useState<Candidate | null>(null);
  const [error, setError] = useState<string>('');

  useEffect(() => {
    axios.get('http://localhost:8000/api/student/profile', { withCredentials: true })
      .then(response => {
        setCandidate(response.data);
      })
      .catch(err => {
        setError('Failed to fetch profile');
        console.error('Error fetching student profile:', err);
      });
  }, []);

  if (error) {
    return <div>{error}</div>;
  }

  if (!candidate) {
    return <div>Loading...</div>;
  }

  return (
    <div>
      <h2>{candidate.FullName}'s Profile</h2>
      <p>Email: {candidate.Email}</p>
      <p>Organization: {candidate.Organization}</p>
      <p>Occupation: {candidate.Occupation}</p>
      <p>Mobile No: {candidate.MobileNo}</p>
    </div>
  );
};

export default StudentProfile;
