import React from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';

import StudentRegistration from './pages/StudentRegistration.tsx';
import ExamLanding from './pages/ExamLanding';
import StudentDashboard from './pages/StudentDashboard'; // ✅ Import
import ExamInstructions from './pages/ExamInstructions.tsx';
import NotFound from './pages/NotFound.tsx';
import './index.css';


const App: React.FC = () => {
  return (
    <Routes>
      <Route path="/" element={<Navigate to="/register" />} />
      <Route path="/register" element={<StudentRegistration />} />
      <Route path="/dashboard" element={<StudentDashboard />} /> {/* ✅ Add this */}
      <Route path="/exam-landing" element={<ExamLanding />} />
      <Route path="/exam-instructions/:id" element={<ExamInstructions />} />
      <Route path="*" element={<NotFound />} />
    </Routes>
  );
};

export default App;
