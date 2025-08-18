<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\ExamCatalog;
use App\Http\Controllers\API\CandidateController;
use App\Http\Controllers\API\StudentExamController;
use App\Http\Controllers\API\ExamCatalogController;
use App\Http\Controllers\API\CandidateExamBookingController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

//
// 🔓 Public Routes (No Auth Required)
//
Route::get('/exams', fn () => ExamCatalog::all());

Route::get('/exam-catalogs/{id}', [ExamCatalogController::class, 'show']);
Route::get('/exam-catalogs/{id}/full', [ExamCatalogController::class, 'showFull']);

//
// 📝 Stateful Auth Routes (CSRF + Session Protected)
//
Route::middleware([
    EnsureFrontendRequestsAreStateful::class,
    'web',
])->group(function () {
    Route::post('/student/register', [CandidateController::class, 'register']);
    Route::post('/student/login', [CandidateController::class, 'login']);
    Route::get('/student/profile', [CandidateController::class, 'profile']);

    Route::post('/logout', function (Request $request) {
        $request->user()?->currentAccessToken()?->delete();
        return response()->json(['message' => 'Logged out']);
    });
});

//
// 🎓 Public Exam Flow (No Auth Required)
//
Route::get('/student/exams', [StudentExamController::class, 'getAvailableExams']);
Route::get('/student/exams/{id}', [StudentExamController::class, 'showExam']);
Route::post('/exams/{exam_id}/start', [StudentExamController::class, 'startExam']);
Route::get('/student/attempts/{attempt_id}/next', [StudentExamController::class, 'getNextQuestion']);
Route::post('/student/attempts/{attempt_id}/answer', [StudentExamController::class, 'submitAnswer']);
Route::post('/student/attempts/{attempt_id}/finish', [StudentExamController::class, 'finishExam']);

//
// 🔐 Authenticated + Stateful Exam Actions
//
Route::middleware([
    EnsureFrontendRequestsAreStateful::class,
    'web',
    'auth:sanctum',
])->group(function () {
    Route::get('/student/exams/{id}/booking-status', [StudentExamController::class, 'checkBookingStatus']);
    Route::post('/student/exams/book', [StudentExamController::class, 'bookExam']);
    Route::get('/student/exams/{id}/payment-status', [StudentExamController::class, 'checkPaymentStatus']);
});
//
// 📅 Exam Bookings (CRUD)
//
Route::middleware([
    EnsureFrontendRequestsAreStateful::class,
    'web',
    'auth:sanctum',
])->group(function () {
    Route::prefix('bookings')->group(function () {
        Route::get('/', [CandidateExamBookingController::class, 'index']);
        Route::post('/', [CandidateExamBookingController::class, 'store']);
        Route::get('/{id}', [CandidateExamBookingController::class, 'show']);
        Route::put('/{id}', [CandidateExamBookingController::class, 'update']);
        Route::delete('/{id}', [CandidateExamBookingController::class, 'destroy']);
    });
});

