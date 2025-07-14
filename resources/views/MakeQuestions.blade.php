<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create New Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f9f9f9;
        }
        .page-title {
            color: #3F2B96;
            font-weight: 600;
        }
        .card {
            border-radius: 20px;
        }
        .btn-purple {
            background-color: #3F2B96;
            color: white;
        }
        .btn-purple:hover {
            background-color: #2e2074;
            color: white;
        }
        label {
            font-weight: 500;
        }
        .form-control {
            background-color: #f1f1f1;
            border: none;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="page-title">Create New Question</h2>
    </div>

    @if($errors->any())
        <div class="alert alert-danger text-center">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-4 shadow-sm">
        <form action="{{ route('makeQuestions') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="QuestionTitle" class="form-label">Question Title</label>
                <input type="text" class="form-control" id="QuestionTitle" name="QuestionTitle">
            </div>

            <div class="mb-3">
                <label for="QuestionImage" class="form-label">Question Image (optional)</label>
                <input type="file" class="form-control" id="QuestionImage" name="QuestionImage">
            </div>

            <div class="mb-3">
                <label for="QuestionText" class="form-label">Question Text</label>
                <input type="text" class="form-control" id="QuestionText" name="QuestionText">
            </div>

            <div class="mb-3">
                <label for="Type" class="form-label">Type</label>
                <select class="form-control" id="Type" name="Type">
                    <option value="" disabled selected>Select Type</option>
                    <option value="MCQ">MCQ</option>
                    <option value="MRQ">MRQ</option>
                    <option value="Text">Text</option>
                </select>
            </div>

            <div id="Choices"></div>

            <div id="CorrectAnswer" class="mt-3"></div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-purple rounded-pill px-4">Submit</button>
            </div>
        </form>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('ViewQuestions') }}" class="btn btn-purple rounded-pill">
            <i class="bi bi-arrow-left"></i> Back to Questions
        </a>
    </div>
</div>

<script>
document.getElementById('Type').addEventListener('change', function() {
    const value = this.value;
    let choicesHtml = '';
    let correctHtml = '';

    if (value === "MCQ" || value === "MRQ") {
        for (let i = 1; i <= 5; i++) {
            choicesHtml += `
                <div class="mb-3">
                    <label for="Choice${i}" class="form-label">Choice ${String.fromCharCode(64 + i)}</label>
                    <input type="text" class="form-control" id="Choice${i}" name="Choices[]">
                </div>
            `;
        }
        correctHtml = `
            <label for="CorrectAnswerSelect" class="form-label">Select Correct Answer(s)</label>
            <select class="form-control" id="CorrectAnswerSelect" name="CorrectAnswer[]" multiple>
                <option value="" disabled>Select options above first</option>
            </select>
        `;
    } else if (value === "Text") {
        correctHtml = `
            <label for="Keywords" class="form-label">Correct Keywords</label>
            <input type="text" class="form-control" id="Keywords" name="CorrectAnswer">
        `;
    }

    document.getElementById('Choices').innerHTML = choicesHtml;
    document.getElementById('CorrectAnswer').innerHTML = correctHtml;

    if (value === "MCQ" || value === "MRQ") {
        document.querySelectorAll("input[name='Choices[]']").forEach(choice => {
            choice.addEventListener('input', updateCorrectOptions);
        });
    }
});

function updateCorrectOptions() {
    let select = document.getElementById('CorrectAnswerSelect');
    if (!select) return;

    select.innerHTML = '';
    let char = 'A';

    document.querySelectorAll("input[name='Choices[]']").forEach((input) => {
        if (input.value.trim() !== '') {
            let option = document.createElement('option');
            option.value = input.value;
            option.text = `${char}: ${input.value}`;
            select.appendChild(option);
            char = String.fromCharCode(char.charCodeAt(0) + 1);
        }
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
