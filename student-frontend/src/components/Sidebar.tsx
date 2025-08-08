import React from "react";
import { FaHome, FaClipboardList, FaUser } from "react-icons/fa";
import { motion } from "framer-motion";

interface SidebarProps {
  setView?: (view: string) => void;
  navigate?: (path: string) => void;
}

const Sidebar: React.FC<SidebarProps> = ({ setView, navigate }) => {
  return (
    <motion.aside
      initial={{ opacity: 0, x: -30 }}
      animate={{ opacity: 1, x: 0 }}
      transition={{ duration: 0.5 }}
      className="bg-slate-900 text-white w-full md:w-64 md:h-screen p-6 space-y-8 border-r border-white/10 backdrop-blur-md shadow-glass"
    >
      <h2 className="text-2xl font-bold tracking-tight">📘 Menu</h2>

      <nav className="flex flex-col space-y-4">
        <button
          onClick={() => setView?.("dashboard")}
          className="flex items-center gap-3 text-white hover:text-indigo-400 transition-colors"
        >
          <FaHome className="w-5 h-5" /> Dashboard
        </button>

        <button
          onClick={() => navigate?.("/exams")}
          className="flex items-center gap-3 text-white hover:text-indigo-400 transition-colors"
        >
          <FaClipboardList className="w-5 h-5" /> Exams
        </button>

        <button
          onClick={() => navigate?.("/profile")}
          className="flex items-center gap-3 text-white hover:text-indigo-400 transition-colors"
        >
          <FaUser className="w-5 h-5" /> Profile
        </button>
      </nav>
    </motion.aside>
  );
};

export default Sidebar;