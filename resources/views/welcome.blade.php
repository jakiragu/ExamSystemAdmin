<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to the Exam System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #f8fafc, #e2e8f0);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h1 {
            font-size: 2rem;
            color: #1e293b;
            margin-bottom: 1.5rem;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        a.button {
            text-decoration: none;
            background-color: #2563eb;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        a.button:hover {
            background-color: #1e40af;
        }

        .footer {
            position: absolute;
            bottom: 20px;
            font-size: 0.9rem;
            color: #64748b;
        }
    </style>
</head>
<body>
    <h1>Welcome to the Certification Exam System</h1>

    <div class="button-group">
        <a href="{{ url('/admin/login') }}" class="button">Admin Login</a>
        <a href="{{ url('/student') }}" class="button">Student Portal</a>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} DataInfinity. All rights reserved.
    </div>
</body>
</html>
