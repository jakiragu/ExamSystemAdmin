import React from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';

import StudentRegistration from './pages/StudentRegistration.tsx';
import ExamLanding from './pages/ExamLanding';
import StudentDashboard from './pages/StudentDashboard';
import ExamInstructions from './pages/examInstructions/ExamInstructions.tsx';
import NotFound from './pages/NotFound.tsx';
import Login from './pages/login.tsx';

import StudentProfile from './pages/StudentProfile.tsx';
import UpcomingExams from './pages/UpcomingExams.tsx';
import BookExamSlot from './pages/BookExamSlot.tsx';
import JoinExam from './pages/JoinExam.tsx';
import PastExams from './pages/PastExams.tsx';
import PerformanceReport from './pages/PerformanceReport.tsx';
import ExamGuidelines from './pages/ExamGuidelines.tsx';
import BookingConfirmation from './pages/BookingConfirmation';




// Optional: Uncomment when ready
 import ExamPage from './pages/ExamPage/exampage.tsx';

import './index.css';
import MyBookings from './pages/mybookings.tsx';

const App: React.FC = () => {
  return (
    <Routes>
      {/* 🔐 Public routes */}
      <Route path="/" element={<Navigate to="/register" />} />
      <Route path="/register" element={<StudentRegistration />} />
      <Route path="/login" element={<Login />} />
      <Route path="/exam-landing" element={<ExamLanding />} />

      {/* 🧭 Exam Instructions Flow */}
      <Route path="/exam-instructions/:id" element={<ExamInstructions />} />
      {/* <Route path="/exam/:id" element={<ExamPage />} /> */}

      {/* 🧑‍🎓 Student Dashboard */}
      <Route path="/dashboard" element={<StudentDashboard />} />
      <Route path="/upcoming-exams" element={<UpcomingExams />} />
      <Route path="/book-exam" element={<BookExamSlot />} />
      <Route path="/join-exam/:schedule_id" element={<JoinExam />} />
      <Route path="/past-exams" element={<PastExams />} />
      <Route path="/performance" element={<PerformanceReport />} />
      <Route path="/guidelines" element={<ExamGuidelines />} />
      <Route path="/profile" element={<StudentProfile />} />
      <Route path="/logout" element={<StudentDashboard />} />
      <Route path="/booking-confirmation" element={<BookingConfirmation />} />
      <Route path="/bookings" element={<MyBookings />} />
      <Route path="/exam/:id" element={<ExamPage />} />



      {/* 🚫 Fallback */}
      <Route path="*" element={<NotFound />} />
    </Routes>
  );
};

export default App;