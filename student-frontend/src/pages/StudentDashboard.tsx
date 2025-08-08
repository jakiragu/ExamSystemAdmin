// src/pages/StudentDashboard.tsx

import Sidebar from "../components/Sidebar";
import ExamList from "../components/ExamList";
import CompletedExams from "../components/CompletedExams";
import Profile from "../components/Profile";
import { useNavigate } from "react-router-dom";
import { BookOpenIcon, UserCheckIcon, UserCircleIcon, LogOutIcon } from "lucide-react";

const StudentDashboard = () => {
  const navigate = useNavigate();

  return (
    <div className="min-h-screen bg-gray-100 flex flex-col md:flex-row">
      {/* Sidebar */}
      <Sidebar />

      {/* Main Content */}
      <main className="flex-1 p-6 md:p-10 space-y-6">
        {/* Header */}
        <header className="border-b pb-4 mb-6">
          <div className="flex justify-between items-center">
            <div>
              <h1 className="text-3xl font-bold text-gray-800">Welcome to Your Dashboard</h1>
              <p className="text-gray-500 text-sm mt-1">Manage your exams, view progress, and more.</p>
            </div>
            <Profile />
          </div>
        </header>

        {/* Action Buttons */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <button
            onClick={() => navigate("/exam-landing")}
            className="bg-blue-600 hover:bg-blue-700 text-white flex flex-col items-center justify-center p-6 rounded-2xl shadow-md transition transform hover:scale-105"
          >
            <BookOpenIcon className="w-8 h-8 mb-2" />
            <span className="text-lg font-medium">Start Exam</span>
          </button>

          <button
            onClick={() => navigate("/results")}
            className="bg-green-600 hover:bg-green-700 text-white flex flex-col items-center justify-center p-6 rounded-2xl shadow-md transition transform hover:scale-105"
          >
            <UserCheckIcon className="w-8 h-8 mb-2" />
            <span className="text-lg font-medium">View Results</span>
          </button>

          <button
            onClick={() => navigate("/update-profile")}
            className="bg-yellow-500 hover:bg-yellow-600 text-white flex flex-col items-center justify-center p-6 rounded-2xl shadow-md transition transform hover:scale-105"
          >
            <UserCircleIcon className="w-8 h-8 mb-2" />
            <span className="text-lg font-medium">Update Profile</span>
          </button>

          <button
            onClick={() => navigate("/logout")}
            className="bg-red-600 hover:bg-red-700 text-white flex flex-col items-center justify-center p-6 rounded-2xl shadow-md transition transform hover:scale-105"
          >
            <LogOutIcon className="w-8 h-8 mb-2" />
            <span className="text-lg font-medium">Logout</span>
          </button>
        </div>

        {/* Exam Sections */}
        <section className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div className="bg-white rounded-xl shadow-md p-6">
            <h2 className="text-xl font-semibold text-gray-700 mb-4">Upcoming Exams</h2>
            <ExamList />
          </div>

          <div className="bg-white rounded-xl shadow-md p-6">
            <h2 className="text-xl font-semibold text-gray-700 mb-4">Completed Exams</h2>
            <CompletedExams />
          </div>
        </section>
      </main>
    </div>
  );
};

export default StudentDashboard;
