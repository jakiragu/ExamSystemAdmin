import React from 'react';
import { useExam } from '../../context/ExamContext';
import { Container, Card, Button, ProgressBar, ListGroup, Alert } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';

const ExamInstructions: React.FC = () => {
  const { selectedExam } = useExam();
  const navigate = useNavigate();

  if (!selectedExam) {
    return (
      <Container className="mt-5 text-center">
        <h4>Step 1 of 4</h4>
        <p>No exam selected. Please go back and choose one.</p>
      </Container>
    );
  }

  const {
    exam_title,
    exam_code,
    exam_objectives = [],
   // instructions = [],
  } = selectedExam;

  return (
    <Container className="mt-5">
      <ProgressBar now={25} label="25%" className="mb-4" />

      <h4 className="mb-3">Step 1 of 4: Exam Instructions</h4>

      <Card className="glass-card shadow-sm p-3">
        <Card.Body>
          <Card.Title className="fs-4">{exam_title}</Card.Title>
          <Card.Subtitle className="mb-2 text-muted">{exam_code}</Card.Subtitle>

          <Alert variant="info" className="mt-3">
            Please read all instructions carefully before proceeding to book your exam slot.
          </Alert>

          <h5 className="mt-4">📌 Exam Objectives</h5>
          {exam_objectives.length > 0 ? (
            <ListGroup variant="flush" className="mb-3">
              {exam_objectives.map((obj: any, idx: number) => (
                <ListGroup.Item key={idx}>
                  <strong>{obj.title}</strong>
                  <br />
                  <span className="text-muted">{obj.description}</span>
                </ListGroup.Item>
              ))}
            </ListGroup>
          ) : (
            <p>No objectives provided for this exam.</p>
          )}

          
          <Button
            variant="success"
            className="mt-4"
            onClick={() => navigate(`/exam-booking/${selectedExam.id}`)}
          >
            Proceed to Booking
          </Button>
        </Card.Body>
      </Card>
    </Container>
  );
};

export default ExamInstructions;