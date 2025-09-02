import { useEffect, useState } from "react";
import axiosInstance from "../api/axiosInstance";
import { useNavigate } from "react-router-dom";

// Define types for clarity
type ExamCatalog = {
  id: number;
  title: string;
  start_url?: string;
  start_time?: string;
  end_time?: string;
};

type Booking = {
  id: number;
  scheduled_at: string;
  status: string;
  payment_status: string;
  examCatalog?: ExamCatalog;
};

export default function UpcomingExams() {
  const [exams, setExams] = useState<Booking[]>([]);
  const navigate = useNavigate();

  useEffect(() => {
    axiosInstance
      .get("http://127.0.0.1:8000/api/my-bookings", {
        withCredentials: true,
      })
      .then((res) => {
       const normalized = res.data.map((booking: any) => ({
        ...booking,
        examCatalog: booking.exam_catalog, // 👈 fix naming
      }));
      setExams(normalized);
    })
    .catch((err) => {
      console.error("Error fetching bookings:", err);
    });
}, []);



  const startExam = (booking: Booking) => {
    if (!booking.examCatalog?.start_url) {
      alert("Exam not yet available");
      return;
    }

    navigate(`/exam/${booking.examCatalog.id}`, {
      state: { bookingId: booking.id },
    });
  };

  return (
    <div className="upcoming-exams">
      <h2>Upcoming Exams</h2>

      {exams.length === 0 ? (
        <p>No upcoming exams booked.</p>
      ) : (
        exams.map((booking) => {
          const exam = booking.examCatalog;

          if (!exam || !exam.start_time || !exam.end_time) {
            return (
              <div key={booking.id} className="exam-card" style={cardStyle}>
                <h4>{exam?.title || "Untitled Exam"}</h4>
                <p><strong>Booking ID:</strong> #{booking.id}</p>
                <p style={{ color: "#a00" }}>
                  ❌ Exam details are incomplete. Please contact support.
                </p>
              </div>
            );
          }

          const now = new Date();
          const examStart = new Date(exam.start_time);
          const examEnd = new Date(exam.end_time);
          const isLiveWindow = now >= examStart && now <= examEnd;
          const canStart =
            booking.payment_status === "confirmed" &&
            isLiveWindow &&
            !!exam.start_url;

          return (
            <div key={booking.id} className="exam-card" style={cardStyle}>
              <h4>{exam.title}</h4>
              <p><strong>Booked On:</strong> {new Date(booking.scheduled_at).toLocaleString()}</p>
              <p><strong>Status:</strong> {booking.status}</p>
              <p><strong>Payment:</strong> {booking.payment_status}</p>
              <p><strong>Exam Window:</strong> {examStart.toLocaleString()} – {examEnd.toLocaleString()}</p>

              <button
                disabled={!canStart}
                onClick={() => startExam(booking)}
                style={{
                  backgroundColor: canStart ? "#28a745" : "#ccc",
                  color: "#fff",
                  padding: "8px 16px",
                  border: "none",
                  borderRadius: "4px",
                  cursor: canStart ? "pointer" : "not-allowed",
                }}
              >
                {!exam.start_url
                  ? "No Start URL"
                  : booking.payment_status !== "confirmed"
                  ? "Payment Pending"
                  : isLiveWindow
                  ? "Start Exam"
                  : "Not Yet Available"}
              </button>
            </div>
          );
        })
      )}
    </div>
  );
}

// Simple inline style for demo purposes
const cardStyle = {
  border: "1px solid #ddd",
  padding: "16px",
  marginBottom: "12px",
  borderRadius: "6px",
  backgroundColor: "#f9f9f9",
};