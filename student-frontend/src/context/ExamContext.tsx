import React, { createContext, useContext, useState } from 'react';

export interface Exam {
  id: number;
  exam_code: string;
  exam_title: string;
  duration_minutes: number;
  exam_objectives?: {
    title: string;
    description: string;
  }[];
    
    // Add other fields as necessary
}

interface ExamContextType {
  selectedExam: Exam | null;
  setSelectedExam: (exam: Exam) => void;
}

const ExamContext = createContext<ExamContextType | undefined>(undefined);

export const ExamProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [selectedExam, setSelectedExam] = useState<Exam | null>(null);

  return (
    <ExamContext.Provider value={{ selectedExam, setSelectedExam }}>
      {children}
    </ExamContext.Provider>
  );
};

export const useExam = (): ExamContextType => {
  const context = useContext(ExamContext);
  if (!context) {
    throw new Error('useExam must be used within an ExamProvider');
  }
  return context;
};