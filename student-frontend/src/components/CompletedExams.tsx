// src/components/CompletedExams.tsx
import React from "react";

interface CompletedExamsProps {
  onBack?: () => void;
}

const CompletedExams: React.FC<CompletedExamsProps> = ({ onBack }) => {
  return (
    <div className="space-y-4">
      <div className="text-gray-700">No completed exams yet.</div>
      <button
        onClick={onBack}
        className="text-sm text-blue-600 hover:underline"
      >
        Back
      </button>
    </div>
  );
};

export default CompletedExams;