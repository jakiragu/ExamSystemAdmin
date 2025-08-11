import React from 'react';
import { useParams } from 'react-router-dom';
import { Container, Card } from 'react-bootstrap';

const ExamPage: React.FC = () => {
  const { id } = useParams();

  return (
    <Container className="mt-5">
      <Card className="p-4 shadow-sm">
        <h3>📝 Exam Interface</h3>
        <p>Exam ID: <strong>{id}</strong></p>
        <p>This is where the actual exam UI will go.</p>
        {/* Add timer, questions, submission logic here */}
      </Card>
    </Container>
  );
};

export default ExamPage;