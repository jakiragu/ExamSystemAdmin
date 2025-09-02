import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axiosInstance from "../../api/axiosInstance";

type Question = {
  id: number;
  text: string;
  options: string[];
  type: "multiple_choice" | "text";
};

export default function ExamPage() {
  const { id } = useParams();
  const [questions, setQuestions] = useState<Question[]>([]);
  const [answers, setAnswers] = useState<{ [key: number]: string }>({});
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axiosInstance.get(`/api/exam/${id}/questions`, { withCredentials: true })
      .then((res) => {
        setQuestions(res.data);
        setLoading(false);
      })
      .catch((err) => {
        console.error("Error fetching questions:", err);
        setLoading(false);
      });
  }, [id]);

  const handleAnswer = (questionId: number, value: string) => {
    setAnswers((prev) => ({ ...prev, [questionId]: value }));
  };

  const handleSubmit = () => {
    axiosInstance.post(`/api/exam/${id}/submit`, { answers }, { withCredentials: true })
      .then(() => alert("Exam submitted successfully"))
      .catch((err) => console.error("Submission error:", err));
  };

  if (loading) return <p>Loading questions...</p>;

  return (
    <div style={{ padding: "2rem" }}>
      <h2>Exam #{id}</h2>
      {questions.map((q) => (
        <div key={q.id} style={questionStyle}>
          <p><strong>{q.text}</strong></p>
          {q.type === "multiple_choice" ? (
            q.options.map((opt) => (
              <label key={opt} style={{ display: "block", marginBottom: "4px" }}>
                <input
                  type="radio"
                  name={`question-${q.id}`}
                  value={opt}
                  checked={answers[q.id] === opt}
                  onChange={(e) => handleAnswer(q.id, e.target.value)}
                />
                {opt}
              </label>
            ))
          ) : (
            <textarea
              rows={3}
              style={{ width: "100%" }}
              value={answers[q.id] || ""}
              onChange={(e) => handleAnswer(q.id, e.target.value)}
            />
          )}
        </div>
      ))}
      <button onClick={handleSubmit} style={submitStyle}>Submit Exam</button>
    </div>
  );
}

const questionStyle = {
  marginBottom: "20px",
  padding: "12px",
  border: "1px solid #ddd",
  borderRadius: "6px",
  backgroundColor: "#fefefe",
};

const submitStyle = {
  padding: "10px 20px",
  backgroundColor: "#007bff",
  color: "#fff",
  border: "none",
  borderRadius: "4px",
  cursor: "pointer",
};