import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import {
  Container, Row, Col, Card, Button, Form, Spinner, Alert,
} from 'react-bootstrap';
import { useForm } from 'react-hook-form';
import { Exam } from '../context/ExamContext';
import axiosInstance from '../api/axiosInstance';

interface BookingData {
  date: string;
  time: string;
}

const BookExamSlot: React.FC = () => {
  const [exams, setExams] = useState<Exam[]>([]);
  const [loading, setLoading] = useState(true);
  const [selectedExam, setSelectedExam] = useState<Exam | null>(null);
  const [errorMessage, setErrorMessage] = useState<string | null>(null);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const navigate = useNavigate();

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<BookingData>();

  useEffect(() => {
    const fetchExams = async () => {
      try {
        const res = await axiosInstance.get('/student/exams');
        setExams(Array.isArray(res.data.exams) ? res.data.exams : []);
      } catch (err) {
        console.error('Failed to fetch exams:', err);
        setErrorMessage('Unable to load exams. Please try again later.');
      } finally {
        setLoading(false);
      }
    };

    fetchExams();
  }, []);

  const onSubmit = async (data: BookingData) => {
    if (!selectedExam) return;

    setIsSubmitting(true);
    setErrorMessage(null);

    try {
      await axiosInstance.get("http://127.0.0.1:8000/sanctum/csrf-cookie", {
        withCredentials: true,
      });

      const scheduledDateTime = `${data.date} ${data.time}:00`;

      const response = await axiosInstance.post("/bookings", {
        exam_catalog_id: selectedExam.id,
        scheduled_at: scheduledDateTime,
      });
      const bookingId = response.data.booking.id;

      const fullBookingRes = await axiosInstance.get(`/bookings/${bookingId}`);
      const fullBooking = fullBookingRes.data;
    // console.log("fetching full booking from:", '/bookings/${bookingId}');

      navigate("/booking-confirmation", {
        state: { booking: fullBooking },
      });
    } catch (error) {
      console.error("Booking failed:", error);
      setErrorMessage("Booking failed. Please check your session and try again.");
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <Container className="mt-5">
      <h2 className="mb-4 text-center">📅 Book Your Exam Slot</h2>

      {errorMessage && (
        <Alert variant="danger" className="text-center">
          {errorMessage}
        </Alert>
      )}

      {loading ? (
        <div className="d-flex justify-content-center align-items-center vh-50">
          <Spinner animation="border" variant="primary" />
          <span className="ms-3">Loading exams...</span>
        </div>
      ) : selectedExam ? (
        <>
          <Card className="mb-4 shadow-sm">
            <Card.Body>
              <Card.Title>{selectedExam.exam_title}</Card.Title>
              <Card.Subtitle className="mb-2 text-muted">{selectedExam.exam_code}</Card.Subtitle>
              <Card.Text>Duration: {selectedExam.duration_minutes} minutes</Card.Text>
              <Button variant="outline-secondary" onClick={() => setSelectedExam(null)}>
                🔙 Back to Exams
              </Button>
            </Card.Body>
          </Card>

          <Form onSubmit={handleSubmit(onSubmit)}>
            <Form.Group className="mb-3">
              <Form.Label>Select Date</Form.Label>
              <Form.Control
                type="date"
                {...register("date", { required: "Date is required" })}
                isInvalid={!!errors.date}
              />
              <Form.Control.Feedback type="invalid">
                {errors.date?.message}
              </Form.Control.Feedback>
            </Form.Group>

            <Form.Group className="mb-3">
              <Form.Label>Select Time</Form.Label>
              <Form.Control
                type="time"
                {...register("time", { required: "Time is required" })}
                isInvalid={!!errors.time}
              />
              <Form.Control.Feedback type="invalid">
                {errors.time?.message}
              </Form.Control.Feedback>
            </Form.Group>

            <Button variant="success" type="submit" disabled={isSubmitting}>
              {isSubmitting ? "Booking..." : "✅ Confirm Booking"}
            </Button>
          </Form>
        </>
      ) : exams.length === 0 ? (
        <p className="text-center">No exams available at the moment.</p>
      ) : (
        <Row>
          {exams.map((exam) => (
            <Col md={6} lg={4} key={exam.id} className="mb-4">
              <Card
                className="shadow-sm h-100"
                onClick={() => setSelectedExam(exam)}
                style={{ cursor: 'pointer' }}
              >
                <Card.Body>
                  <Card.Title>{exam.exam_title}</Card.Title>
                  <Card.Subtitle className="mb-2 text-muted">{exam.exam_code}</Card.Subtitle>
                  <Card.Text>Duration: {exam.duration_minutes} minutes</Card.Text>
                  <Button variant="primary">Select This Exam</Button>
                </Card.Body>
              </Card>
            </Col>
          ))}
        </Row>
      )}
    </Container>
  );
};

export default BookExamSlot;