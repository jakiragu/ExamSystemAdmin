import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import axios from 'axios';

interface LabEnvironment {
  schema_name: string;
  setup_script: string;
}

interface ExamInstructionsData {
  exam_id: number;
  exam_title: string;
  duration_minutes: number;
  instructions: string;
  objectives: string[];
  lab_environment?: LabEnvironment;
}

const ExamInstructions: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const [loading, setLoading] = useState(true);
  const [exam, setExam] = useState<ExamInstructionsData | null>(null);
  const [error, setError] = useState('');

  useEffect(() => {
    const fetchExamDetails = async () => {
      try {
        const response = await axios.get(`/api/exams/${id}/instructions`);
        setExam(response.data);
      } catch (err) {
        setError('Failed to fetch exam details.');
      } finally {
        setLoading(false);
      }
    };

    fetchExamDetails();
  }, [id]);

  const handleStartExam = () => {
    navigate(`/start-exam/${id}`);
  };

  if (loading) return <p>Loading exam instructions...</p>;
  if (error || !exam) return <p>{error || 'Exam not found.'}</p>;

  return (
    <div className="p-6 max-w-3xl mx-auto bg-white shadow-md rounded-xl mt-6">
      <h1 className="text-2xl font-bold mb-4">{exam.exam_title}</h1>
      <p className="mb-2"><strong>Duration:</strong> {exam.duration_minutes} minutes</p>
      <p className="mb-4"><strong>Instructions:</strong> {exam.instructions}</p>

      <div className="mb-4">
        <h2 className="text-lg font-semibold">Objectives:</h2>
        <ul className="list-disc list-inside">
          {exam.objectives.map((obj, index) => (
            <li key={index}>{obj}</li>
          ))}
        </ul>
      </div>

      {exam.lab_environment && (
        <div className="mb-4">
          <h2 className="text-lg font-semibold">Lab Environment:</h2>
          <p><strong>Schema:</strong> {exam.lab_environment.schema_name}</p>
          <p><strong>Setup Script:</strong> {exam.lab_environment.setup_script}</p>
        </div>
      )}

      <button
        className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        onClick={handleStartExam}
      >
        Start Exam
      </button>
    </div>
  );
};

export default ExamInstructions;
