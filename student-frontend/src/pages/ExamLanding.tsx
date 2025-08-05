import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';

interface Exam {
  id: number;
  exam_title: string;
  description?: string;
  duration?: number;
}

const ExamLanding: React.FC = () => {
  const navigate = useNavigate();
  const [exams, setExams] = useState<Exam[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    const registered = localStorage.getItem('studentRegistered');
    if (!registered) {
      navigate('/register');
      return;
    }

    axios
      .get(`${import.meta.env.VITE_API_BASE_URL}/exam-catalogs`)
      .then(response => setExams(response.data))
      .catch(err => {
        console.error('Error fetching exams:', err);
        setError('Failed to load exams. Please try again.');
      })
      .finally(() => setLoading(false));
  }, []);

  const handleViewInstructions = (id: number) => {
    navigate(`/exam-instructions/${id}`);
  };

  return (
    <div className="max-w-2xl mx-auto p-6 mt-12 bg-white shadow-md rounded-md">
      <h1 className="text-3xl font-bold mb-6 text-center">Available Exams</h1>

      {loading ? (
        <p className="text-center text-gray-500">Loading exams...</p>
      ) : error ? (
        <p className="text-center text-red-600">{error}</p>
      ) : exams.length === 0 ? (
        <p className="text-center text-gray-600">No exams available at the moment.</p>
      ) : (
        <ul className="space-y-4">
          {exams.map(exam => (
            <li key={exam.id} className="p-4 bg-gray-100 rounded-md shadow-sm">
              <div className="flex flex-col md:flex-row md:justify-between md:items-center">
                <div>
                  <h2 className="text-lg font-semibold">{exam.exam_title}</h2>
                  {exam.description && (
                    <p className="text-sm text-gray-600">{exam.description}</p>
                  )}
                  {exam.duration && (
                    <p className="text-sm text-gray-500 mt-1">
                      Duration: {exam.duration} minutes
                    </p>
                  )}
                </div>
                <button
                  onClick={() => handleViewInstructions(exam.id)}
                  className="mt-4 md:mt-0 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                >
                  View Instructions
                </button>
              </div>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

export default ExamLanding;