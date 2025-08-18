import React, { useEffect, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import '../index.css';
import Cookies from 'js-cookie';
import { logoutCandidate } from '../api/candidateApi';

interface Student {
  id: number;
  FullName: string;
  Email: string;
  // Add other fields here if needed
}

export default function StudentDashboard() {
  const [student, setStudent] = useState<Student | null>(null);
  const navigate = useNavigate();

const handleLogout = async (e: React.MouseEvent) => {
  e.preventDefault();
  try {
    await logoutCandidate();
    navigate('/login');
  } catch (error) {
    console.error('Logout failed:', error);
    alert('Logout failed. Please try again.');
  }
};

  useEffect(() => {
    console.log('Dashboard component mounted');
    axios.get('http://127.0.0.1:8000/api/student/profile', { withCredentials: true })
      .then(res => {
        setStudent(res.data.candidate);
      })
      .catch(err => {
        console.error('Error fetching student profile:', err);
        // Optionally handle redirect to login if unauthenticated
        if (err.response?.status === 401) {
          navigate('/register');
        }
      });
  }, [navigate]);

  return (
    <>
      {/* Navbar */}
      <nav className="navbar navbar-expand-lg navbar-light navbar-custom sticky-top px-4">
        <Link className="navbar-brand fw-bold" to="/dashboard">
          ExamSystem
        </Link>
        <div className="ms-auto d-flex align-items-center">
          <span className="me-3 fw-semibold">
            {student?.FullName ? `Hi, ${student.FullName}` : 'Loading...'}
          </span>
          <Link to="/profile" className="btn btn-outline-primary">
            <i className="bi bi-person-circle me-2"></i> Profile
          </Link>
        </div>
      </nav>

      <div className="container-fluid">
        <div className="row">
          {/* Sidebar */}
          <div className="col-md-3 col-lg-2 sidebar">
            <h5 className="px-3">Navigation</h5>
            <Link to="/exam-landing"><i className="bi bi-calendar-event me-2"></i>Available Exams</Link>
            <Link to="/upcoming-exams"><i className="bi bi-calendar-event me-2"></i> Upcoming Exams</Link>
            <Link to="/book-exam"><i className="bi bi-pencil-square me-2"></i> Book Exam Slot</Link>
            <Link to="/past-exams"><i className="bi bi-journal-check me-2"></i> Past Exams</Link>
            <Link to="/performance"><i className="bi bi-bar-chart-fill me-2"></i> Performance</Link>
            <Link to="/guidelines"><i className="bi bi-book me-2"></i> Exam Guidelines</Link>
            <button className="btn btn-outline-danger w-100 text-start" onClick={handleLogout}>
  <i className="bi bi-box-arrow-right me-2"></i> Logout
</button>
          </div>

          {/* Main Content */}
          <div className="col-md-9 col-lg-10 py-4 px-3">
            <h2 className="mb-4">🎓 Student Dashboard</h2>
            <div className="row g-4">

              {/* Performance Overview */}
              <div className="col-md-6 col-lg-4">
                <div className="card glass fade-in-up h-100">
                  <div className="card-body">
                    <h5 className="card-title">
                      <i className="bi bi-bar-chart-fill me-2"></i> Performance Overview
                    </h5>
                    <p className="card-text">Track your grades and progress.</p>
                    <Link to="/performance" className="btn btn-primary">View Report</Link>
                  </div>
                </div>
              </div>

              {/* Book Exam Slot */}
              <div className="col-md-6 col-lg-4">
                <div className="card glass fade-in-up h-100">
                  <div className="card-body">
                    <h5 className="card-title">
                      <i className="bi bi-pencil-square me-2"></i> Book an Exam
                    </h5>
                    <p className="card-text">Reserve your spot for upcoming exams.</p>
                    <Link to="/book-exam" className="btn btn-primary">Book Now</Link>
                  </div>
                </div>
              </div>

              {/* Upcoming Exams */}
              <div className="col-md-6 col-lg-4">
                <div className="card glass fade-in-up h-100">
                  <div className="card-body">
                    <h5 className="card-title">
                      <i className="bi bi-calendar-event me-2"></i> Upcoming Exams
                    </h5>
                    <p className="card-text">See your scheduled exams.</p>
                    <Link to="/upcoming-exams" className="btn btn-primary">View Schedule</Link>
                  </div>
                </div>
              </div>

              {/* Past Exams */}
              <div className="col-md-6 col-lg-4">
                <div className="card glass fade-in-up h-100">
                  <div className="card-body">
                    <h5 className="card-title">
                      <i className="bi bi-journal-check me-2"></i> Past Exams
                    </h5>
                    <p className="card-text">Review your completed exams.</p>
                    <Link to="/past-exams" className="btn btn-primary">View History</Link>
                  </div>
                </div>
              </div>

              {/* Guidelines */}
              <div className="col-md-6 col-lg-4">
                <div className="card glass fade-in-up h-100">
                  <div className="card-body">
                    <h5 className="card-title">
                      <i className="bi bi-book me-2"></i> System Compatability Check
                    </h5>
                    <p className="card-text">Read important exam rules.</p>
                    <Link to="/guidelines" className="btn btn-primary">Read Now</Link>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </>
  );
}
