import React, { useEffect, useState } from 'react';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import '../index.css';
import { useNavigate } from 'react-router-dom';

interface Student {
  id: number;
  FullName: string;
  Email: string;
}

export default function StudentProfile() {
  const [student, setStudent] = useState<Student | null>(null);
  const navigate = useNavigate();

  useEffect(() => {
    axios.get('http://127.0.0.1:8000/api/student/profile', { withCredentials: true })
      .then(res => {
        setStudent(res.data.candidate);
      })
      .catch(err => {
        console.error('Error fetching profile:', err);
        if (err.response?.status === 401) {
          navigate('/register');
        }
      });
  }, [navigate]);

  return (
    <div className="container py-5">
      <h2 className="mb-4"><i className="bi bi-person-circle me-2"></i> Student Profile</h2>

      {student ? (
        <div className="row g-4">
          {/* Profile Info */}
          <div className="col-md-6">
            <div className="card glass p-4 h-100">
              <h4 className="mb-3">{student.FullName}</h4>
              <p><strong>Email:</strong> {student.Email}</p>
              <p><strong>Phone:</strong> Not provided</p>
              <p><strong>Registered:</strong> N/A</p>
              <p><strong>Last Login:</strong> N/A</p>
              <p><strong>Status:</strong> Active</p>
            </div>
          </div>

          {/* Static Exam Summary */}
          <div className="col-md-6">
            <div className="card glass p-4 h-100">
              <h5 className="mb-3"><i className="bi bi-bar-chart-fill me-2"></i> Exam Summary</h5>
              <p><strong>Total Booked:</strong> 0</p>
              <p><strong>Upcoming Exams:</strong> 0</p>
              <p><strong>Completed Exams:</strong> 0</p>
              <p><strong>Average Score:</strong> N/A</p>
              <p><strong>Next Exam:</strong> Not scheduled</p>
            </div>
          </div>

          {/* Static Recent Activity */}
          <div className="col-md-12">
            <div className="card glass p-4">
              <h5 className="mb-3"><i className="bi bi-clock-history me-2"></i> Recent Activity</h5>
              <ul className="list-group list-group-flush">
                <li className="list-group-item">No recent activity</li>
              </ul>
            </div>
          </div>

          {/* Profile Actions */}
          <div className="col-md-12">
            <div className="card glass p-4">
              <h5 className="mb-3"><i className="bi bi-gear me-2"></i> Profile Actions</h5>
              <div className="d-flex flex-wrap gap-3">
                <button className="btn btn-outline-primary" disabled>Edit Profile</button>
                <button className="btn btn-outline-secondary" disabled>Change Password</button>
                <button className="btn btn-outline-success" disabled>Download History</button>
                <button className="btn btn-outline-danger" disabled>Delete Account</button>
              </div>
            </div>
          </div>
        </div>
      ) : (
        <p>Loading profile...</p>
      )}
    </div>
  );
}