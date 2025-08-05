<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamCatalog;
use App\Models\LabEnvironment;

class ExamCatalogController extends Controller
{
    public function index()
    {
        $examCatalogs = ExamCatalog::with('labEnvironment')->get();
        return view('admin.exam_catalogs.index', compact('examCatalogs'));
    }

    public function create()
    {
        $labEnvironments = LabEnvironment::all(); // To populate dropdown
        return view('admin.exam_catalogs.create', compact('labEnvironments'));
    }

    public function store(Request $request)
    {
         // ✅ Normalize checkbox input BEFORE validation
    $request->merge([
        'is_visible_to_students' => $request->has('is_visible_to_students')
    ]);

        $validated = $request->validate([
            'exam_code' => 'required|string|max:255|unique:exam_catalogs',
            'exam_title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'status' => 'required|in:draft,scheduled,active,paused,stopped',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'lab_env_id' => 'nullable|exists:lab_environments,lab_env_id',
            'is_visible_to_students' => 'sometimes|boolean',
        ]);

        // Default false if checkbox not present
        $validated['is_visible_to_students'] = $request->has('is_visible_to_students');

        ExamCatalog::create($validated);

        return redirect()->route('admin.exam-catalogs.index')
                         ->with('success', 'Exam catalog added successfully.');
    }

    public function edit(ExamCatalog $examCatalog)
    {
        $labEnvironments = LabEnvironment::all();
        return view('admin.exam_catalogs.edit', compact('examCatalog', 'labEnvironments'));
    }

    public function update(Request $request, ExamCatalog $examCatalog)
    {
        $request->merge([
        'is_visible_to_students' => $request->has('is_visible_to_students')
    ]);


        $validated = $request->validate([
            'exam_code' => 'required|string|max:255|unique:exam_catalogs,exam_code,' . $examCatalog->id,
            'exam_title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'status' => 'required|in:draft,scheduled,active,paused,stopped',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'lab_env_id' => 'nullable|exists:lab_environments,lab_env_id',
            'is_visible_to_students' => 'sometimes|boolean',
        ]);

        $validated['is_visible_to_students'] = $request->has('is_visible_to_students');

        $examCatalog->update($validated);

        return redirect()->route('admin.exam-catalogs.index')
                         ->with('success', 'Exam catalog updated successfully.');
    }

    public function destroy(ExamCatalog $examCatalog)
    {
        $examCatalog->delete();

        return redirect()->route('admin.exam-catalogs.index')
                         ->with('success', 'Exam catalog deleted.');
    }
    
public function getAvailableExams()
{
    $exams = ExamCatalog::with('labEnvironment')
        ->where('is_visible_to_students', true)
        ->where('status', 'active')
        ->get();

    return response()->json([
        'status' => 'success',
        'exams' => $exams
    ]);
}

}
