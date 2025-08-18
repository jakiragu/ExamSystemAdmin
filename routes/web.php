<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\{
    RegistrationController,
    AdminLoginController,
    ExamController,
    TimerController,
    GradingController,
    TerminalController,
    AdminManagementController,
    DashboardController,
    StudentController,
    Admin\ExamQuestionController
};
use App\Http\Middleware\{CheckAdmin, CheckCandidate};

// Public welcome page
Route::get('/', function () {
    return view('welcome');
});

// ✅ Wrap all session-dependent routes in 'web' middleware
Route::middleware(['web'])->group(function () {
    // Admin Auth Routes
    Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('Admin');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('Admin.submit');
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Admin Sign Up
    Route::get('/AdminSignUp', [AdminLoginController::class, 'index'])->name('Admin.signup');
    Route::post('/AdminSignUp', [AdminLoginController::class, 'store'])->name('Admin.store');

    // CSRF Token Endpoint
    Route::get('/csrf-token', function () {
        return response()->json(['csrfToken' => csrf_token()])
        ->withCookie(cookie('XSRF-TOKEN', csrf_token(), 120, null, null, false, false))
;
    });

    // Student Registration & Portal
    Route::get('/student/register', [StudentController::class, 'form'])->name('student.register.form');
    Route::post('/student/register', [StudentController::class, 'submit'])->name('student.register.submit');
    Route::get('/student/portal', [StudentController::class, 'examEntry'])->name('student.exam.entry');

    // React SPA fallback
    Route::get('/student/{any}', function () {
        $path = public_path('student/index.html');
        return File::exists($path)
            ? response()->file($path)
            : Response::make("React app not found", 404);
    })->where('any', '.*');
});

// ✅ Admin Protected Routes
Route::middleware([CheckAdmin::class])->group(function () {
    Route::get('/adminDashboard', [DashboardController::class, 'index'])->name('adminDashboard');

    // Student Management
    Route::get('/studentInfo', [ExamController::class, 'viewStudentInfo'])->name('studentInfo');
    Route::delete('/deleteStudent/{id}', [ExamController::class, 'deleteStudent'])->name('deleteStudent');

    // Timer Controls
    Route::get('/StartTimer', [TimerController::class, 'StartTimer'])->name('StartTimer');
    Route::get('/ResumeTimer', [TimerController::class, 'ResumeTimer'])->name('ResumeTimer');
    Route::get('/PauseTimer', [TimerController::class, 'PauseTimer'])->name('PauseTimer');
    Route::post('/AdjustTimer', [TimerController::class, 'AdjustTimer'])->name('AdjustTimer');
    Route::get('/ResetTimer', [TimerController::class, 'ResetTimer'])->name('ResetTimer');

    // Submissions & Grading
    Route::get('/ViewSubmissions', [ExamController::class, 'showSubmittedStudents'])->name('ViewSubmissions');
    Route::get('/ViewAnswers/{id}', [ExamController::class, 'viewAnswers'])->name('ViewAnswers');

    // Questions
    Route::get('/ViewQuestions', [GradingController::class, 'viewQuestions'])->name('ViewQuestions');
    Route::delete('/questions/{id}', [GradingController::class, 'deleteQuestion'])->name('questions.delete');
    Route::view('/makeQuestions', 'MakeQuestions');
    Route::post('/makeQuestions', [GradingController::class, 'makeQuestions'])->name('makeQuestions');

    // Exam Grading
    Route::get('/GradeExam', [GradingController::class, 'markAnswers'])->name('GradeExam');
    Route::get('/ViewCandidateAnswers/{id}', [GradingController::class, 'viewCandidateAnswers'])->name('ViewCandidateAnswers');
    Route::post('/UpdateAnswerStatus/{id}', [GradingController::class, 'updateAnswerStatus'])->name('UpdateAnswerStatus');

    // Results Management
    Route::get('/ManageResults', [GradingController::class, 'manageResults'])->name('ManageResults');
    Route::get('/ReleaseResults', [GradingController::class, 'releaseResults'])->name('ReleaseResults');
});

// ✅ Admin Resource Routes
Route::prefix('admin')->name('admin.')->middleware([CheckAdmin::class])->group(function () {
    Route::resource('exam-catalogs', App\Http\Controllers\Admin\ExamCatalogController::class);
    Route::resource('subject-areas', App\Http\Controllers\Admin\SubjectAreaController::class);
    Route::resource('exam-objectives', App\Http\Controllers\Admin\ExamObjectiveController::class);
    Route::resource('lab-environments', App\Http\Controllers\Admin\LabEnvironmentController::class);
    Route::resource('exam-questions', App\Http\Controllers\Admin\ExamQuestionController::class);
    Route::resource('evaluator-scripts', App\Http\Controllers\Admin\EvaluatorScriptController::class);
    Route::get('exam-questions/import', [ExamQuestionController::class, 'showImportForm'])->name('exam-questions.import');

    Route::prefix('exams')->name('exams.')->group(function () {
        Route::post('{id}/start', [ExamController::class, 'startExam'])->name('start');
        Route::post('{id}/pause', [ExamController::class, 'pauseExam'])->name('pause');
        Route::post('{id}/stop', [ExamController::class, 'stopExam'])->name('stop');
        Route::post('{id}/reset', [ExamController::class, 'resetExam'])->name('reset');
    });
});

// ✅ Super Admin Routes
Route::middleware(['auth:admin', 'is_super'])->group(function () {
    Route::resource('manage-admins', AdminManagementController::class)->parameters([
        'manage-admins' => 'id'
    ]);
});