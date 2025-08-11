import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import App from './App';
import './index.css'; // optional styling
import 'bootstrap/dist/css/bootstrap.min.css';
import { ExamProvider } from './context/ExamContext';

ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>
    <BrowserRouter basename="/student">
      <ExamProvider>
      <App />
      </ExamProvider>
    </BrowserRouter>
  </React.StrictMode>
);