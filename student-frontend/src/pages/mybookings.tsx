import { useEffect, useState } from 'react';
import axiosInstance from '../api/axiosInstance';

type Booking = {
  examCatalog: {
    exam_title: string;
    exam_code: string;
    duration_minutes: number;
  };
  scheduled_at: string;
};

export default function MyBookings() {
  const [bookings, setBookings] = useState<Booking[]>([]);

  useEffect(() => {
  axiosInstance.get('/bookings/api/my-bookings')
    .then(res => {
      setBookings(res.data); // assuming Laravel returns raw array
    })
    .catch(err => {
      console.error('Error fetching bookings:', err);
      setBookings([]);
    });
}, []);



  return (
    <div className="container mt-4">
      <h2>📚 My Bookings</h2>
      {bookings.length === 0 ? (
        <p>No bookings found.</p>
      ) : (
        <table className="table table-bordered">
          <thead>
            <tr>
              <th>Exam</th>
              <th>Code</th>
              <th>Date</th>
              <th>Duration</th>
            </tr>
          </thead>
          <tbody>
            {bookings.map((b, i) => {
  const exam = b.examCatalog;
  return (
    <tr key={i}>
      <td>{exam?.exam_title || '—'}</td>
      <td>{exam?.exam_code || '—'}</td>
      <td>{new Date(b.scheduled_at).toLocaleString()}</td>
      <td>{exam?.duration_minutes ? `${exam.duration_minutes} mins` : '—'}</td>
    </tr>
  );
})}


          </tbody>
        </table>
      )}
    </div>
  );
}