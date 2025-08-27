import React from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import { Card, Button, Alert } from 'react-bootstrap';

interface ExamCatalog {
  id: number;
  exam_title: string;
  exam_code: string;
  duration_minutes: number; 
  location?: string;
}

interface Candidate {
  id: number;
  FullName: string;
  email?: string;
}

interface Booking {
  id: number;
  exam_catalog_id: number;
  scheduled_at: string;
  status?: string;
  payment_status?: string;
  examCatalog?: ExamCatalog;
  candidate?: Candidate;
}

interface LocationState {
  booking?: Booking;
}

const BookingConfirmation: React.FC = () => {
  const location = useLocation();
  const navigate = useNavigate();
  const state = location.state as LocationState;
  const booking = state?.booking;

  if (!booking) {
    return (
      <div className="text-center mt-5">
        <Alert variant="warning">No booking data found.</Alert>
        <Button onClick={() => navigate('/dashboard')}>Go to Dashboard</Button>
      </div>
    );
  }

  const formattedDateTime = new Date(booking.scheduled_at).toLocaleString();

  return (
    <div className="container mt-5">
      <Card className="shadow-sm border-success">
        <Card.Body>
          <h3 className="text-success mb-4">✅ Booking Confirmed</h3>

          <p><strong>Student:</strong> {booking.candidate?.FullName || '—'}</p>
          <p><strong>Exam:</strong> {booking.examCatalog?.exam_title || '—'}</p>
          <p><strong>Date & Time:</strong> {formattedDateTime}</p>
          <p><strong>Location:</strong> {booking.examCatalog?.location || 'To be announced'}</p>
          <p><strong>Status:</strong> {booking.status || 'booked'}</p>
          <p><strong>Payment:</strong> {booking.payment_status || 'pending'}</p>
          <p><strong>Booking ID:</strong> #{booking.id}</p>
          <p><strong>Code:</strong> {booking.examCatalog?.exam_code || '—'}</p>
          <p><strong>Duration:</strong> {booking.examCatalog?.duration_minutes} minutes</p>

          <div className="mt-4 d-flex gap-2">
            <Button variant="primary" onClick={() => navigate('/bookings')}>
              View My Bookings
            </Button>
            <Button variant="outline-secondary" onClick={() => navigate('/dashboard')}>
              Back to Dashboard
            </Button>
          </div>
        </Card.Body>

        <Card.Footer className="text-muted text-center">
          You’ll receive a reminder 24 hours before your exam.
        </Card.Footer>
      </Card>
    </div>
  );
};

export default BookingConfirmation;