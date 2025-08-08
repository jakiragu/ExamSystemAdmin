// src/components/Sidebar.tsx
import React from "react";
import { FaHome, FaClipboardList, FaUser } from "react-icons/fa";

interface SidebarProps {
  setView?: (view: string) => void;
  navigate?: (path: string) => void;
}

const Sidebar: React.FC<SidebarProps> = ({ setView, navigate }) => {
  return (
    <aside className="bg-white shadow md:w-64 w-full md:h-screen p-6 space-y-6">
      <nav className="space-y-4">
        <button
          onClick={() => setView?.("dashboard")}
          className="flex items-center text-gray-700 hover:text-blue-600"
        >
          <FaHome className="mr-2" /> Dashboard
        </button>
        <button
          onClick={() => navigate?.("/exams")}
          className="flex items-center text-gray-700 hover:text-blue-600"
        >
          <FaClipboardList className="mr-2" /> Exams
        </button>
        <button
          onClick={() => navigate?.("/profile")}
          className="flex items-center text-gray-700 hover:text-blue-600"
        >
          <FaUser className="mr-2" /> Profile
        </button>
      </nav>
    </aside>
  );
};

export default Sidebar;