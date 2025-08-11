import axios from 'axios';

const API_BASE = 'http://localhost:8000';

// 🔐 Ensure CSRF token is set before any POST
const ensureCsrf = async () => {
  await axios.get('http://localhost:8000/sanctum/csrf-cookie', {
    withCredentials: true,
  });
};

// 📝 Register a new candidate
export const registerCandidate = async (data: {
  FullName: string;
  Email: string;
  Organization: string;
  Occupation: string;
  MobileNo: string;
}) => {
  try {
    // 🔐 Step 1: Get CSRF cookie
    await axios.get('http://localhost:8000/sanctum/csrf-cookie', {
      withCredentials: true,
    });

    // 🔍 Step 2: Read CSRF token from cookie
    const xsrfToken = document.cookie
      .split('; ')
      .find(row => row.startsWith('XSRF-TOKEN='))
      ?.split('=')[1];

    const response = await axios.post('http://localhost:8000/api/student/register', data, {
      headers: {
        'Content-Type': 'application/json',
        'X-XSRF-TOKEN': decodeURIComponent(xsrfToken || ''),
      },
      withCredentials: true,
    });

    return response.data;
  } catch (error: any) {
    console.error('Registration failed:', error);
    throw error;
  }
};

// 👤 Fetch candidate profile
export const fetchCandidateProfile = async () => {
  try {
    const response = await axios.get(`${API_BASE}/api/student/profile`, {
      withCredentials: true,
    });

    return response.data;
  } catch (error: any) {
    console.error('Error fetching profile:', error);
    throw error;
  }
};

// 🚪 Logout candidate
export const logoutCandidate = async () => {
  try {
    await axios.post(`${API_BASE}/api/logout`, {}, {
      withCredentials: true,
    });
  } catch (error: any) {
    console.error('Logout failed:', error);
    throw error;
  }
};