import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import axios from '../../api/axiosInstance';

interface SubjectArea {
  id: number;
  name: string;
}

interface Objective {
  id: number;
  objective_title: string;
  description: string;
  subject_area: SubjectArea;
}

interface LabEnvironment {
  schema_name: string;
  comments: string | null;
}

interface Exam {
  id: number;
  exam_code: string;
  exam_title: string;
  duration_minutes: number;
  status: string;
  start_time: string | null;
  end_time: string | null;
  is_visible_to_students: boolean;
  lab_environment: LabEnvironment | null;
  objectives: Objective[];
}

const ExamInstructions: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const [exam, setExam] = useState<Exam | null>(null);
  const [loading, setLoading] = useState(true);
  const [expandedSubjects, setExpandedSubjects] = useState<Record<string, boolean>>({});

  useEffect(() => {
    const fetchExam = async () => {
      try {
        const res = await axios.get(`/exam-catalogs/${id}/full`);
        setExam(res.data);

        // Expand all subjects by default
        const initialExpanded: Record<string, boolean> = {};
        res.data.objectives.forEach((obj: Objective) => {
          initialExpanded[obj.subject_area.name] = true;
        });
        setExpandedSubjects(initialExpanded);
      } catch (err) {
        console.error('Error fetching exam:', err);
      } finally {
        setLoading(false);
      }
    };
    fetchExam();
  }, [id]);

  const handleStartExam = async () => {
    try {
      const res = await axios.post(`/student/exams/${id}/start`);
      navigate(`/exam/${res.data.attempt_id}`);
    } catch (err) {
      console.error('Failed to start exam:', err);
    }
  };

  const groupObjectives = (objectives: Objective[]) => {
    const grouped = objectives.reduce((acc, obj) => {
      const subject = obj.subject_area.name;
      acc[subject] = acc[subject] || [];
      acc[subject].push(obj);
      return acc;
    }, {} as Record<string, Objective[]>);
    return Object.entries(grouped);
  };

  const toggleSubject = (subject: string) => {
    setExpandedSubjects(prev => ({
      ...prev,
      [subject]: !prev[subject],
    }));
  };

  if (loading) {
    return (
      <div className="d-flex justify-content-center align-items-center vh-100 bg-light">
        <p className="text-primary fs-5">Loading exam instructions...</p>
      </div>
    );
  }

  if (!exam) {
    return (
      <div className="container py-5">
        <div className="alert alert-danger">Exam not found or failed to load.</div>
      </div>
    );
  }

  return (
    <div className="container py-5">
      {/* Exam Overview */}
      <div className="card mb-4 shadow-sm">
        <div className="card-body">
          <h1 className="card-title h3">{exam.exam_title}</h1>
          <ul className="list-group list-group-flush mt-3">
            <li className="list-group-item"><strong>Exam Code:</strong> {exam.exam_code}</li>
            <li className="list-group-item"><strong>Status:</strong> {exam.status}</li>
            <li className="list-group-item"><strong>Start Time:</strong> {exam.start_time || 'Not scheduled'}</li>
            <li className="list-group-item"><strong>End Time:</strong> {exam.end_time || 'Not scheduled'}</li>
            <li className="list-group-item"><strong>Duration:</strong> {exam.duration_minutes} minutes</li>
          </ul>
        </div>
      </div>

      {/* Objectives Section */}
      <h2 className="h4 text-primary mb-3">📚 Objectives</h2>
      {groupObjectives(exam.objectives).map(([subject, objectives]) => {
        const isOpen = expandedSubjects[subject];
        return (
          <div key={subject} className="mb-3 border rounded">
            <button
              className="btn btn-light w-100 text-start d-flex justify-content-between align-items-center"
              onClick={() => toggleSubject(subject)}
              aria-expanded={isOpen}
            >
              <span className="fw-semibold text-primary">{subject}</span>
              <span className="text-muted">{isOpen ? '▲' : '▼'}</span>
            </button>
            {isOpen && (
              <ul className="list-group list-group-flush px-3 py-2">
                {objectives.map(obj => (
                  <li key={obj.id} className="list-group-item">
                    <strong>{obj.objective_title}</strong>: {obj.description}
                  </li>
                ))}
              </ul>
            )}
          </div>
        );
      })}

      {/* Lab Environment */}
      <h2 className="h4 text-primary mt-4 mb-3">🧪 Lab Environment</h2>
      {exam.lab_environment ? (
        <div className="card mb-4">
          <div className="card-body">
            <p><strong>Schema:</strong> {exam.lab_environment.schema_name}</p>
            <p><strong>Notes:</strong> {exam.lab_environment.comments || 'No additional notes.'}</p>
          </div>
        </div>
      ) : (
        <div className="alert alert-info">No lab environment required for this exam.</div>
      )}

      {/* Start Exam Button */}
      <div className="text-center mt-5">
        <button
          onClick={handleStartExam}
          className="btn btn-primary btn-lg d-flex align-items-center gap-2 justify-content-center"
        >
          🚀 Start Exam
        </button>
      </div>
    </div>
  );
};

export default ExamInstructions;