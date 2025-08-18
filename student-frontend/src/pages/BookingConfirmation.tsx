import React from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import { Card, Button } from 'react-bootstrap';

interface ExamCatalog {
  id: number;
  name: string;
}

interface Booking {
  id: number;
  exam_catalog_id: number;
  scheduled_at: string;
  status?: string;
  payment_status?: string;
  examCatalog?: ExamCatalog;
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
        <h4>No booking data found.</h4>
        <Button onClick={() => navigate('/student/dashboard')}>Go to Dashboard</Button>
      </div>
    );
  }

  return (
    <div className="container mt-5">
      <Card className="shadow-sm">
        <Card.Body>
          <h3 className="text-success">✅ Booking Confirmed</h3>
          <p><strong>Exam:</strong> {booking.examCatalog?.name || '—'}</p>
          <p><strong>Date:</strong> {new Date(booking.scheduled_at).toLocaleDateString()}</p>
          <p><strong>Status:</strong> {booking.status || 'booked'}</p>
          <p><strong>Payment:</strong> {booking.payment_status || 'pending'}</p>

          <div className="mt-4">
            <Button variant="primary" onClick={() => navigate('/student/bookings')}>
              View My Bookings
            </Button>{' '}
            <Button variant="outline-secondary" onClick={() => navigate('/student/dashboard')}>
              Back to Dashboard
            </Button>
          </div>
        </Card.Body>
      </Card>
    </div>
  );
};

export default BookingConfirmation;