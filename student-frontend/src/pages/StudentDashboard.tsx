import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import '../index.css';

export default function Dashboard() {
  return (
    <>
      {/* Navbar */}
      <nav className="navbar navbar-expand-lg navbar-light navbar-custom sticky-top px-4">
        <a className="navbar-brand fw-bold" href="#">
          TG.ExamSystem
        </a>
        <div className="ms-auto">
          <button className="btn btn-outline-primary">
            <i className="bi bi-person-circle me-2"></i> Profile
          </button>
        </div>
      </nav>

      <div className="container-fluid">
        <div className="row">
          {/* Sidebar */}
          <div className="col-md-3 col-lg-2 sidebar">
            <h5 className="px-3">Navigation</h5>
            <a href="#"><i className="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a href="#"><i className="bi bi-journal-text me-2"></i> Assignments</a>
            <a href="#"><i className="bi bi-bar-chart-fill me-2"></i> Performance</a>
            <a href="#"><i className="bi bi-bell-fill me-2"></i> Notifications</a>
            <a href="#"><i className="bi bi-box-arrow-right me-2"></i> Logout</a>
          </div>

          {/* Main Content */}
          <div className="col-md-9 col-lg-10 py-4 px-3">
            <h2 className="mb-4">🎓 Student Dashboard</h2>
            <div className="row g-4">
              {/* Cards */}
              <div className="col-md-6 col-lg-4">
                <div className="card glass fade-in-up h-100">
                  <div className="card-body">
                    <h5 className="card-title">
                      <i className="bi bi-bar-chart-fill me-2"></i> Performance Overview
                    </h5>
                    <p className="card-text">Track your grades and progress.</p>
                    <button className="btn btn-primary">View Report</button>
                  </div>
                </div>
              </div>

              <div className="col-md-6 col-lg-4">
                <div className="card glass fade-in-up h-100">
                  <div className="card-body">
                    <h5 className="card-title">
                      <i className="bi bi-journal-text me-2"></i> Assignments
                    </h5>
                    <p className="card-text">Upcoming deadlines and submissions.</p>
                    <button className="btn btn-primary">Go to Assignments</button>
                  </div>
                </div>
              </div>

              <div className="col-md-6 col-lg-4">
                <div className="card glass fade-in-up h-100">
                  <div className="card-body">
                    <h5 className="card-title">
                      <i className="bi bi-bell-fill me-2"></i> Notifications
                    </h5>
                    <p className="card-text">Announcements and alerts.</p>
                    <button className="btn btn-primary">Check Alerts</button>
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