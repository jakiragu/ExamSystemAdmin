import React from 'react';
import { Button, Alert } from 'react-bootstrap';

interface Props {
  countdown: number;
  onStart: () => void;
}

const StartExamButton: React.FC<Props> = ({ countdown, onStart }) => {
  return (
    <>
      <h5>🚀 Ready to Begin</h5>
      <p>Click below to start your exam. Time will begin immediately.</p>

      {countdown < 5 && countdown > 0 && (
        <Alert variant="warning">
          ⏳ Starting exam in {countdown} seconds...
        </Alert>
      )}

      <Button variant="danger" onClick={onStart} disabled={countdown < 5}>
        Start Exam
      </Button>
    </>
  );
};

export default StartExamButton;