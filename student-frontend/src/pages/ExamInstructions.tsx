
// ExamInstructions.tsx
import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import axios from 'axios';

interface Exam {
  id: number;
  exam_code: string;
  exam_title: string;
  duration_minutes: number;
  is_visible_to_students: number;
}

const ExamInstructions: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const [exam, setExam] = useState<Exam | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const registered = localStorage.getItem('studentRegistered');
    if (!registered) {
      navigate('/register');
      return;
    }

    axios.get(`http://localhost:8000/api/exam-catalogs/${id}`)
      .then(response => {
        const data = response.data;
        if (data.is_visible_to_students) {
          setExam(data);
        }
        setLoading(false);
      })
      .catch(() => setLoading(false));
  }, [id]);

  const handleStartExam = () => {
    navigate(`/start-exam/${id}`);
  };

  if (loading) return <div className="p-6 text-center">Loading exam info...</div>;

  if (!exam) return <div className="p-6 text-red-600 text-center">Exam not found or not yet available.</div>;

  return (
    <div className="p-6 max-w-xl mx-auto bg-white shadow-md rounded-md mt-10">
      <h1 className="text-2xl font-bold mb-2 text-center">{exam.exam_title}</h1>
      <p className="text-gray-700 mb-2 text-center">Exam Code: {exam.exam_code}</p>
      <p className="text-gray-700 mb-4 text-center">Duration: {exam.duration_minutes} minutes</p>

      <div className="my-4 p-4 bg-yellow-100 rounded">
        <p className="font-semibold">Exam Instructions:</p>
        <ul className="list-disc list-inside text-sm mt-2 text-gray-700">
          <li>No phones or unauthorized materials allowed.</li>
          <li>Do not reload or switch devices during the exam.</li>
          <li>Answers are auto-submitted when time runs out.</li>
          <li>Start only when you're ready — the timer begins immediately.</li>
        </ul>
      </div>

      <button
        onClick={handleStartExam}
        className="w-full mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
      >
        Start Exam
      </button>
    </div>
  );
};

export default ExamInstructions;