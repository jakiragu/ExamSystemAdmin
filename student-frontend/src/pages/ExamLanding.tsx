import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import { Spinner, Card, Button, Container, Row, Col } from 'react-bootstrap';
import { useExam, Exam } from '../context/ExamContext';

const ExamLanding: React.FC = () => {
  const [exams, setExams] = useState<Exam[]>([]);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();
  const { setSelectedExam } = useExam();

  useEffect(() => {
    axios.get('http://localhost:8000/api/student/exams')
      .then(response => {
        const fetchedExams = Array.isArray(response.data.exams) ? response.data.exams : [];
        setExams(fetchedExams);
        setLoading(false);
      })
      .catch(error => {
        console.error('Failed to fetch exams:', error);
        setExams([]);
        setLoading(false);
      });
  }, []);

  const handleSelectExam = (exam: Exam) => {
    setSelectedExam(exam);
    navigate(`/exam-instructions/${exam.id}`);
  };

  if (loading) {
    return (
      <div className="d-flex justify-content-center align-items-center vh-100">
        <Spinner animation="border" variant="primary" />
        <span className="ms-3">Loading exams...</span>
      </div>
    );
  }

  return (
    <Container className="mt-5">
      <h2 className="mb-4 text-center">📘 Select an Exam</h2>
      {exams.length === 0 ? (
        <p className="text-center">No exams available at the moment.</p>
      ) : (
        <Row>
          {exams.map((exam) => (
            <Col md={6} lg={4} key={exam.id} className="mb-4">
              <Card className="shadow-sm h-100">
                <Card.Body>
                  <Card.Title>{exam.exam_title}</Card.Title>
                  <Card.Subtitle className="mb-2 text-muted">{exam.exam_code}</Card.Subtitle>
                  <Card.Text>
                    Duration: {exam.duration_minutes} minutes
                  </Card.Text>
                  <Button variant="primary" onClick={() => handleSelectExam(exam)}>
                    Select This Exam
                  </Button>
                </Card.Body>
              </Card>
            </Col>
          ))}
        </Row>
      )}
    </Container>
  );
};

export default ExamLanding;