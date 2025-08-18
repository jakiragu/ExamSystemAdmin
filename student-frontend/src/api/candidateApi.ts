import axios from './axiosInstance';
import Cookies from 'js-cookie';



const API_BASE = 'http://127.0.0.1:8000';

// 🔐 Ensure CSRF token is set before any POST
const ensureCsrf = async () => {
  await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie', {
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
  password: string;
  password_confirmation: string;
}) => {
  try {
    // 🔐 Step 1: Get CSRF cookie
    await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie', {
      withCredentials: true,
    });

    // 🔍 Step 2: Read CSRF token from cookie
    const xsrfToken = document.cookie
      .split('; ')
      .find(row => row.startsWith('XSRF-TOKEN='))
      ?.split('=')[1];

    const response = await axios.post('http://127.0.0.1:8000/api/student/register', data, {
      headers: {
        'Content-Type': 'application/json',
        'X-XSRF-TOKEN': decodeURIComponent(xsrfToken || ''),
      },
      withCredentials: true,
    });

    return response;
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
  await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie', {
    withCredentials: true,
  });

  const xsrfToken = Cookies.get('XSRF-TOKEN');

  return await axios.post(
    'http://127.0.0.1:8000/api/logout',
    {},
    {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': xsrfToken || '',
      },
    }
  );
};

