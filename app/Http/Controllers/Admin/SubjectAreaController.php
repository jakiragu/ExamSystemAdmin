<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubjectArea;
use App\Models\ExamCatalog; // ✅ Import the related model

class SubjectAreaController extends Controller
{
    public function index()
    {
        $subjectAreas = SubjectArea::with('examCatalog')->get(); // Optional eager loading
        return view('admin.subject_areas.index', compact('subjectAreas'));
    }

    public function create()
    {
        $examCatalogs = ExamCatalog::orderBy('exam_title')->get(); // ✅ Fetch catalogs for dropdown
        return view('admin.subject_areas.create', compact('examCatalogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exam_catalog_id' => 'required|exists:exam_catalogs,id', // ✅ Validate catalog
        ]);

        SubjectArea::create([
            'name' => $request->name,
            'description' => $request->description,
            'exam_catalog_id' => $request->exam_catalog_id, // ✅ Store relationship
        ]);

        return redirect()->route('admin.subject-areas.index')
                         ->with('success', 'Subject area created.');
    }

    public function edit(SubjectArea $subject_area)
    {
        $examCatalogs = ExamCatalog::orderBy('exam_title')->get(); // ✅ Pass catalogs for editing
        return view('admin.subject_areas.edit', compact('subject_area', 'examCatalogs'));
    }

    public function update(Request $request, SubjectArea $subject_area)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exam_catalog_id' => 'required|exists:exam_catalogs,id', // ✅ Validate update
        ]);

        $subject_area->update([
            'name' => $request->name,
            'description' => $request->description,
            'exam_catalog_id' => $request->exam_catalog_id, // ✅ Update relationship
        ]);

        return redirect()->route('admin.subject-areas.index')
                         ->with('success', 'Subject area updated.');
    }

    public function destroy(SubjectArea $subject_area)
    {
        $subject_area->delete();

        return redirect()->route('admin.subject-areas.index')
                         ->with('success', 'Subject area deleted.');
    }
}