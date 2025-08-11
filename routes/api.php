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


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student/profile', [CandidateController::class, 'profile']);
});

Route::post('/logout', [CandidateController::class, 'logout']);

Route::post('/login', [CandidateController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student/exams', [StudentExamController::class, 'listAvailableExams']);
    Route::get('/student/exams/{id}', [StudentExamController::class, 'getExamDetails']);
    Route::post('/student/exams/{id}/start', [StudentExamController::class, 'startExam']);
    Route::get('/student/exams/{id}/booking-status', [StudentExamController::class, 'checkBookingStatus']);
    Route::post('/student/exams/book', [StudentExamController::class, 'bookExam']);
    Route::get('/student/exams/{id}/payment-status', [StudentExamController::class, 'checkPaymentStatus']);
    // ... other routes like getNextQuestion, submitAnswer, finishExam
});


use Illuminate\Support\Facades\DB;

Route::get('/student/exams', function () {
    return response()->json([
        'exams' => DB::table('exam_catalogs')->get()
    ]);
});

