<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamObjective;
use App\Models\SubjectArea;
use App\Models\ExamCatalog;

class ExamObjectiveController extends Controller
{
    public function index()
    {
        $examObjectives = ExamObjective::with(['subjectArea', 'examCatalog'])->get();
        return view('admin.exam_objectives.index', compact('examObjectives'));
    }

    public function create()
    {
        $subjectAreas = SubjectArea::all();
        $examCatalogs = ExamCatalog::all();
        return view('admin.exam_objectives.create', compact('subjectAreas', 'examCatalogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'objective_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_area_id' => 'required|exists:subject_areas,id',
            'exam_catalog_id' => 'required|exists:exam_catalogs,id',
        ]);

        ExamObjective::create($request->all());

        return redirect()->route('admin.exam-objectives.index')->with('success', 'Exam objective created.');
    }

    public function edit(ExamObjective $exam_objective)
    {
        $subjectAreas = SubjectArea::all();
        $examCatalogs = ExamCatalog::all();
        return view('admin.exam_objectives.edit', compact('exam_objective', 'subjectAreas', 'examCatalogs'));
    }

    public function update(Request $request, ExamObjective $exam_objective)
    {
        $request->validate([
            'objective_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_area_id' => 'required|exists:subject_areas,id',
            'exam_catalog_id' => 'required|exists:exam_catalogs,id',
        ]);

        $exam_objective->update($request->all());

        return redirect()->route('admin.exam-objectives.index')->with('success', 'Exam objective updated.');
    }

    public function destroy(ExamObjective $exam_objective)
    {
        $exam_objective->delete();

        return redirect()->route('admin.exam-objectives.index')->with('success', 'Exam objective deleted.');
    }
}
