// src/components/Profile.tsx
import React from "react";

interface ProfileProps {
  onBack?: () => void;
}

const Profile: React.FC<ProfileProps> = ({ onBack }) => {
  return (
    <div className="flex items-center space-x-4">
      <div className="text-sm text-gray-700">Welcome, Student</div>
      <button
        onClick={onBack}
        className="text-sm text-blue-600 hover:underline"
      >
        Back
      </button>
    </div>
  );
};

export default Profile;