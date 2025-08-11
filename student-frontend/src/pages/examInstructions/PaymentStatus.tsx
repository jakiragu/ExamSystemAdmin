import React from 'react';
import { Button, Alert } from 'react-bootstrap';

interface Props {
  isPaid: boolean;
  onNext: () => void;
}

const PaymentStatus: React.FC<Props> = ({ isPaid, onNext }) => {
  return (
    <>
      <h5>💳 Payment Verification</h5>
      <Alert variant={isPaid ? 'success' : 'warning'}>
        {isPaid
          ? '✅ Payment confirmed. You may proceed to lab setup.'
          : '⚠️ Payment not found. Please complete payment to continue.'}
      </Alert>

      {isPaid && (
        <Button variant="success" onClick={onNext}>
          ➡️ Proceed to Lab Setup
        </Button>
      )}
    </>
  );
};

export default PaymentStatus;