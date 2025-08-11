import React from 'react';
import { useParams } from 'react-router-dom';

const JoinExam: React.FC = () => {
  const { schedule_id } = useParams();

  return (
    <div className="container py-4">
      <h2>🚀 Join Exam</h2>
      <p>Exam Schedule ID: <strong>{schedule_id}</strong></p>
      <button className="btn btn-primary">Start Exam</button>
    </div>
  );
};

export default JoinExam;
