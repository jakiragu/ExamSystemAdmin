import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

interface Exam {
  exam_id: number;
  exam_code: string;
  exam_title: string;
  duration_minutes: number;
}

const ExamLanding: React.FC = () => {
  const [exams, setExams] = useState<Exam[]>([]);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    axios.get('http://localhost:8000/api/student/exams') // Adjust backend URL/port
      .then(response => {
        setExams(response.data.exams); // Make sure API returns this key
        setLoading(false);
      })
      .catch(error => {
        console.error('Failed to fetch exams:', error);
        setLoading(false);
      });
  }, []);

  const handleSelectExam = (exam: Exam) => {
    localStorage.setItem('selectedExam', JSON.stringify(exam));
    navigate('/exam-instructions/${selectedExam.exam_id}');
  };

  if (loading) return <div>Loading exams...</div>;

  return (
    <div className="exam-landing">
      <h2>Select an Exam</h2>
      {exams.length === 0 ? (
        <p>No exams available at the moment.</p>
      ) : (
        <ul>
          {exams.map((exam) => (
            <li key={exam.exam_id} style={{ marginBottom: '1rem' }}>
              <div>
                <strong>{exam.exam_title}</strong> ({exam.exam_code}) — {exam.duration_minutes} minutes
              </div>
              <button onClick={() => handleSelectExam(exam)}>
                Select This Exam
              </button>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

export default ExamLanding;
