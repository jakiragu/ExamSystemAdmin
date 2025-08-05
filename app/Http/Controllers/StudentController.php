<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamCatalog;

class StudentController extends Controller
{
    public function form()
    {
        return view('student.register');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'reg_no' => 'required|string',
            'name' => 'required|string',
        ]);

        session(['student' => $validated]);

        return redirect()->route('student.exam.entry');
    }

    public function examEntry()
    {
        $student = session('student');

        if (!$student) {
            return redirect()->route('student.register.form');
        }

        $visibleExams = ExamCatalog::where('is_visible', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->get();

        return view('student.exam_entry', compact('student', 'visibleExams'));
    }
}