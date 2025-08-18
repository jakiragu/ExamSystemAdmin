import React, { useEffect, useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';

const CompatibilityCheck: React.FC = () => {
  const [results, setResults] = useState({
    browser: '',
    resolution: '',
    network: '',
    cookies: '',
  });

  const [status, setStatus] = useState({
    browser: false,
    resolution: false,
    network: false,
    cookies: false,
  });

  useEffect(() => {
    // ✅ Browser Check
    const ua = navigator.userAgent;
    const browserOk = /Chrome|Firefox|Safari|Edge/.test(ua);
    const browser = browserOk ? `Compatible (${ua})` : `Incompatible (${ua})`;

    // 📏 Resolution Check
    const width = window.innerWidth;
    const height = window.innerHeight;
    const resolutionOk = width >= 1024 && height >= 768;
    const resolution = `${width}x${height} - ${resolutionOk ? 'OK' : 'Too small'}`;

    // 📶 Network Speed Check
    const start = performance.now();
    fetch('https://www.google.com/images/branding/googlelogo/2x/googlelogo_light_color_92x30dp.png')
      .then(() => {
        const latency = performance.now() - start;
        const networkOk = latency < 1000;
        const network = `${Math.round(latency)}ms - ${networkOk ? 'Fast enough' : 'Slow'}`;

        // 🔒 Cookie Check
        document.cookie = "testcookie=1";
        const cookieOk = document.cookie.includes("testcookie");
        const cookies = cookieOk ? "Cookies enabled" : "Cookies disabled";

        setResults({ browser, resolution, network, cookies });
        setStatus({ browser: browserOk, resolution: resolutionOk, network: networkOk, cookies: cookieOk });
      });
  }, []);

  const allGood = Object.values(status).every(Boolean);

  return (
    <div className="container py-5">
      <h2 className="mb-4"><i className="bi bi-tools me-2"></i> System Compatibility Check</h2>
      <ul className="list-group mb-4">
        <li className={`list-group-item ${status.browser ? 'list-group-item-success' : 'list-group-item-danger'}`}>
          <strong>Browser:</strong> {results.browser}
        </li>
        <li className={`list-group-item ${status.resolution ? 'list-group-item-success' : 'list-group-item-danger'}`}>
          <strong>Screen Resolution:</strong> {results.resolution}
        </li>
        <li className={`list-group-item ${status.network ? 'list-group-item-success' : 'list-group-item-danger'}`}>
          <strong>Network Speed:</strong> {results.network}
        </li>
        <li className={`list-group-item ${status.cookies ? 'list-group-item-success' : 'list-group-item-danger'}`}>
          <strong>Cookies:</strong> {results.cookies}
        </li>
      </ul>

      {allGood ? (
        <button className="btn btn-success">Proceed to Exam</button>
      ) : (
        <div className="alert alert-warning">
          Please fix the issues above before starting the exam.
        </div>
      )}
    </div>
  );
};

export default CompatibilityCheck;