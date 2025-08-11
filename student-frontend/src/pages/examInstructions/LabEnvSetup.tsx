import React from 'react';
import { Button, Card } from 'react-bootstrap';

const LabSetupInstructions: React.FC<{ onReady: () => void }> = ({ onReady }) => {
  return (
    <Card className="mt-4">
      <Card.Header>🧪 Lab Environment Setup</Card.Header>
      <Card.Body>
        <ul>
          <li>Install Docker Desktop (Windows/Mac/Linux)</li>
          <li>Ensure virtualization is enabled in BIOS</li>
          <li>Run: <code>docker run oracle/exam-env</code></li>
          <li>Verify container is running before starting exam</li>
          <li>Use provided credentials to access the lab</li>
        </ul>
        <Button variant="success" onClick={onReady}>
          ✅ I'm Ready
        </Button>
      </Card.Body>
    </Card>
  );
};

export default LabSetupInstructions;