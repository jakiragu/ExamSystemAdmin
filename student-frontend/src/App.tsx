import React from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';

import StudentRegistration from './pages/StudentRegister';
import ExamLanding from './pages/ExamLanding';
import ExamInstructions from './pages/ExamInstructions';
import NotFound from './pages/NotFound';

const App: React.FC = () => {
  return (
    <Routes>
      {/* Default route: redirect to /register */}
      <Route path="/" element={<Navigate to="/register" />} />

      {/* Registration/Login */}
      <Route path="/register" element={<StudentRegistration />} />

      {/* Exam landing page (after registration/login) */}
      <Route path="/exam-landing" element={<ExamLanding />} />

      {/* Exam instructions after selecting exam */}
      <Route path="/exam-instructions/:id" element={<ExamInstructions />} />

      {/* Catch-all for unknown routes */}
      <Route path="*" element={<NotFound />} />
    </Routes>
  );
};

export default App;
