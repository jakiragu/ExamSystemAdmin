<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\TimerController;
use App\Http\Controllers\GradingController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckCandidate;
use App\Http\Controllers\TerminalController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\Admin\ExamQuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;



Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/login', function () {
    return view('AdminLogin');
});

// Authentication Routes
Route::get('/Admin', [AdminLoginController::class, 'create'])->name('Admin');
Route::post('/Admin', [AdminLoginController::class, 'login'])->name('Admin.submit');
Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');
 Route::get('/AdminSignUp', [AdminLoginController::class, 'index'])->name('Admin.signup');
    Route::post('/AdminSignUp', [AdminLoginController::class, 'store'])->name('Admin.store');

// Public Routes
Route::post('/register-candidates', [ExamController::class, 'registerCandidates'])->name('register-candidates');

// Admin Protected Routes
Route::middleware([CheckAdmin::class])->group(function () {
    // Admin sign-up
    
    
    // Dashboard
   

Route::get('/adminDashboard', [DashboardController::class, 'index'])->name('adminDashboard');
    
    // Student Management
    Route::get('/studentInfo', [ExamController::class, 'viewStudentInfo'])->name('studentInfo');
    Route::delete('/deleteStudent/{id}', [ExamController::class, 'deleteStudent'])->name('deleteStudent');

    // Timer controls
    Route::get('/StartTimer', [TimerController::class, 'StartTimer'])->name('StartTimer');
    Route::get('/ResumeTimer', [TimerController::class, 'ResumeTimer'])->name('ResumeTimer');
    Route::get('/PauseTimer', [TimerController::class, 'PauseTimer'])->name('PauseTimer');
    Route::post('/AdjustTimer', [TimerController::class, 'AdjustTimer'])->name('AdjustTimer');
    Route::get('/ResetTimer', [TimerController::class, 'ResetTimer'])->name('ResetTimer');

    // Submissions & grading
    Route::get('/ViewSubmissions', [ExamController::class, 'showSubmittedStudents'])->name('ViewSubmissions');


    Route::get('/ViewAnswers/{id}', [ExamController::class, 'viewAnswers'])->name('ViewAnswers');

    // Questions
    Route::get('/ViewQuestions', [GradingController::class, 'viewQuestions'])->name('ViewQuestions');
    Route::delete('/questions/{id}', [GradingController::class, 'deleteQuestion'])->name('questions.delete');
    Route::get('/makeQuestions', function () {
        return view('MakeQuestions');
    });
    Route::post('/makeQuestions', [GradingController::class, 'makeQuestions'])->name('makeQuestions');

    // Exam Grading
    Route::get('/GradeExam', [GradingController::class, 'markAnswers'])->name('GradeExam');
    Route::get('/ViewCandidateAnswers/{id}', [GradingController::class, 'viewCandidateAnswers'])->name('ViewCandidateAnswers');
    Route::post('/UpdateAnswerStatus/{id}', [GradingController::class, 'updateAnswerStatus'])->name('UpdateAnswerStatus');

    // Results management
    Route::get('/ManageResults', [GradingController::class, 'manageResults'])->name('ManageResults');
    Route::get('/ReleaseResults', [GradingController::class, 'releaseResults'])->name('ReleaseResults');
});

// Admin Resource Routes
Route::prefix('admin')->name('admin.')->middleware([CheckAdmin::class])->group(function () {
    Route::resource('exam-catalogs', App\Http\Controllers\Admin\ExamCatalogController::class);
    Route::resource('subject-areas', App\Http\Controllers\Admin\SubjectAreaController::class);
    Route::resource('exam-objectives', App\Http\Controllers\Admin\ExamObjectiveController::class);
    Route::resource('lab-environments', App\Http\Controllers\Admin\LabEnvironmentController::class);
    Route::resource('exam-questions', App\Http\Controllers\Admin\ExamQuestionController::class);
    Route::resource('evaluator-scripts', App\Http\Controllers\Admin\EvaluatorScriptController::class);
});
Route::resource('admin/lab-environments', \App\Http\Controllers\Admin\LabEnvironmentController::class)->names([
    'index' => 'admin.lab-environments.index',
    'create' => 'admin.lab-environments.create',
    'store' => 'admin.lab-environments.store',
    'edit' => 'admin.lab-environments.edit',
    'update' => 'admin.lab-environments.update',
    'destroy' => 'admin.lab-environments.destroy',
]);
Route::middleware(['auth:admin', 'is_super'])->group(function () {
    Route::resource('manage-admins', AdminManagementController::class)->parameters([
        'manage-admins' => 'id'
    ]);
});
Route::get('/admin/exam-questions/import', [ExamQuestionController::class, 'showImportForm'])->name('admin.exam-questions.import');

Route::prefix('admin/exams')->name('admin.exams.')->group(function () {
    Route::post('{id}/start', [ExamController::class, 'startExam'])->name('start');
    Route::post('{id}/pause', [ExamController::class, 'pauseExam'])->name('pause');
    Route::post('{id}/stop', [ExamController::class, 'stopExam'])->name('stop');
    Route::post('{id}/reset', [ExamController::class, 'resetExam'])->name('reset');
});

Route::get('/student/register', [StudentController::class, 'form'])->name('student.register.form');
Route::post('/student/register', [StudentController::class, 'submit'])->name('student.register.submit');
Route::get('/student/portal', [StudentController::class, 'examEntry'])->name('student.exam.entry');


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('/student/{any}', function () {
    $path = public_path('student/index.html');
    if (File::exists($path)) {
       return response()->file($path);
    }
    return Response::make("React app not found", 404);
})->where('any', '.*');



Route::get('/csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});
