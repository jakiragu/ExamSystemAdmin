import React from 'react';
import { ProgressBar } from 'react-bootstrap';

const StepIndicator: React.FC<{ currentStep: number }> = ({ currentStep }) => {
  const progress = (currentStep / 4) * 100;

  return (
    <div className="mb-4">
      <ProgressBar now={progress} label={`Step ${currentStep} of 4`} />
    </div>
  );
};

export default StepIndicator;