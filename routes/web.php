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

Route::get('/Admin', [AdminLoginController::class, 'create'])->name('Admin');
Route::post('/Admin', [AdminLoginController::class, 'login'])->name('Admin.submit');
Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');
Route::post('/register-candidates', [ExamController::class, 'registerCandidates'])->name('register-candidates');

Route::middleware([CheckAdmin::class])->group(function () {
    // Admin sign-up
    Route::get('/AdminSignUp', [AdminLoginController::class, 'index'])->name('Admin.signup');
    Route::post('/AdminSignUp', [AdminLoginController::class, 'store'])->name('Admin.store');
    
    // Dashboard
    Route::get('/adminDashboard', function () {
        return view('adminDashboard');
    })->name('adminDashboard');
    Route::get('/studentInfo', [ExamController::class, 'viewStudentInfo'])->name('studentInfo');

    // Timer controls
    Route::get('/StartTimer', [TimerController::class, 'StartTimer'])->name('StartTimer');
    Route::get('/ResumeTimer', [TimerController::class, 'ResumeTimer'])->name('ResumeTimer');
    Route::get('/PauseTimer', [TimerController::class, 'PauseTimer'])->name('PauseTimer');
    Route::post('/AdjustTimer', [TimerController::class, 'AdjustTimer'])->name('AdjustTimer');
    Route::get('/ResetTimer', [TimerController::class, 'ResetTimer'])->name('ResetTimer');

    // Submissions & grading
    Route::get('/ViewSubmissions', [ExamController::class, 'viewSubmissions'])->name('ViewSubmissions');
    Route::get('/GradeExam', [GradingController::class, 'markAnswers'])->name('GradeExam');
    Route::get('/ViewAnswers/{id}', [ExamController::class, 'viewAnswers'])->name('ViewAnswers');
    Route::delete('/deleteStudent/{id}', [ExamController::class, 'deleteStudent'])->name('deleteStudent');


    // Questions
    Route::get('/ViewQuestions', [GradingController::class, 'viewQuestions'])->name('ViewQuestions');
    Route::delete('/questions/{id}', [GradingController::class, 'deleteQuestion'])->name('questions.delete');
    Route::get('/makeQuestions', function () {
        return view('MakeQuestions');
    });
    Route::post('/makeQuestions', [GradingController::class, 'makeQuestions'])->name('makeQuestions');

    // Results management
    Route::get('/ManageResults', [GradingController::class, 'manageResults'])->name('ManageResults');
    Route::get('/ViewCandidateAnswers/{id}', [GradingController::class, 'viewCandidateAnswers'])->name('ViewCandidateAnswers');
    Route::post('/UpdateAnswerStatus/{id}', [GradingController::class, 'updateAnswerStatus'])->name('UpdateAnswerStatus');
    Route::get('/ReleaseResults', [GradingController::class, 'releaseResults'])->name('ReleaseResults');
});
