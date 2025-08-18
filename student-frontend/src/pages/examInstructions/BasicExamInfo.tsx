import React from 'react';
import { Button, Alert } from 'react-bootstrap';

interface Exam {
  exam_title: string;
  exam_code: string;
  duration_minutes: number;
}

interface Props {
  exam: {
    exam_title: string;
    exam_code: string;
    duration_minutes: number;
  };
  examObjectives: Objective[];
  isBooked: boolean;
  onSchedule: () => void | Promise<void>;
  onNext: () => void | Promise<void>;
}{
    
  }[];
 interface Objective {}

const BasicExamInfo: React.FC<Props> = ({ exam, isBooked, onSchedule, onNext }) => {
  return (
    <>
      {exam ? (
        <>
          <h5>{exam.exam_title}</h5>
          <p><strong>Code:</strong> {exam.exam_code}</p>
          <p><strong>Duration:</strong> {exam.duration_minutes} minutes</p>

          <Alert variant="info">
            {isBooked
              ? '✅ Exam is scheduled. Proceed to payment check.'
              : '📅 You need to schedule this exam before proceeding.'}
          </Alert>

          <div className="d-flex gap-3">
            {!isBooked && (
              <Button variant="primary" onClick={onSchedule}>
                📅 Schedule Exam
              </Button>
            )}
            {isBooked && (
              <Button variant="success" onClick={onNext}>
                ➡️ Proceed to Payment Check
              </Button>
            )}
          </div>
        </>
      ) : (
        <Alert variant="danger">No exam selected. Please go back and choose one.</Alert>
      )}
    </>
  );
};

export default BasicExamInfo;