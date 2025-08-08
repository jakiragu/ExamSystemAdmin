import axios from 'axios';

export const registerCandidate = async (data: {
  FullName: string;
  Email: string;
  Organization: string;
  Occupation: string;
  MobileNo: string;
}) => {
  const response = await axios.post('http://localhost:8000/api/student/register', data, {
    headers: {
      'Content-Type': 'application/json',
    },
  });

  return response.data;
};
