// src/components/ExamList.tsx
import React from "react";

interface Exam {
  id: number;
  title: string;
  date: string;
}

interface ExamListProps {
  exams?: Exam[];
  loading?: boolean;
  error?: any;
  onViewInstructions?: (id: string) => void;
  onBack?: () => void;
}

const ExamList: React.FC<ExamListProps> = ({
  exams = [],
  loading,
  error,
  onViewInstructions,
  onBack,
}) => {
  if (loading) return <div>Loading exams...</div>;
  if (error) return <div className="text-red-500">Error loading exams.</div>;

  return (
    <div className="space-y-4">
      {exams.length === 0 ? (
        <div>No upcoming exams.</div>
      ) : (
        exams.map((exam) => (
          <div
            key={exam.id}
            className="border rounded p-4 flex justify-between items-center"
          >
            <div>
              <h3 className="text-lg font-semibold">{exam.title}</h3>
              <p className="text-sm text-gray-600">Date: {exam.date}</p>
            </div>
            <button
              onClick={() => onViewInstructions?.(exam.id.toString())}
              className="text-blue-600 hover:underline text-sm"
            >
              View Instructions
            </button>
          </div>
        ))
      )}
    </div>
  );
};

export default ExamList;