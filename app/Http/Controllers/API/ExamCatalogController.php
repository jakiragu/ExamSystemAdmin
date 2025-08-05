<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamCatalog;

class ExamCatalogController extends Controller
{
    public function show($id)
{
    $exam = ExamCatalog::with([
        'objectives:id,exam_id,objective_title',
        'labEnvironment:id,schema_name,comments'
    ])->find($id);

    if (!$exam) {
        return response()->json(['error' => 'Exam not found'], 404);
    }

    return response()->json($exam);
}

}
