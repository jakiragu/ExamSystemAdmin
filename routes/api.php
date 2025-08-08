<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\ExamCatalog;
use App\Http\Controllers\API\CandidateController;
use App\Http\Controllers\API\StudentExamController;
use App\Http\Controllers\API\ExamCatalogController;

// Default test route
Route::get('/exams', function () {
    return ExamCatalog::all();
});

// Student registration
Route::post('/student/register', [CandidateController::class, 'register']);

// Student exam flow
Route::get('/student/exams', [StudentExamController::class, 'getAvailableExams']);
Route::get('/student/exams/{id}', [StudentExamController::class, 'showExam']);
Route::post('/exams/{exam_id}/start', [StudentExamController::class, 'startExam']);

Route::get('/student/attempts/{attempt_id}/next', [StudentExamController::class, 'getNextQuestion']);
Route::post('/student/attempts/{attempt_id}/answer', [StudentExamController::class, 'submitAnswer']);
Route::post('/student/attempts/{attempt_id}/finish', [StudentExamController::class, 'finishExam']);
Route::get('/exam-catalogs/{id}', [ExamCatalogController::class, 'show']);

