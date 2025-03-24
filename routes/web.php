<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ExamController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckCandidate;
use App\Http\Controllers\TimerController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\TerminalController;

// Route::get('/set-session', function (Request $request) {
//     session(['key' => 'value']);
//     return "Session stored!";
// });

// Route::get('/get-session', function (Request $request) {
//     return session()->all();
// });


Route::get('/Admin', [AdminLoginController::class,'create'])->name('Admin');
Route::post('/Admin',[AdminLoginController::class,'login'])->name('Admin.submit');
Route::get('/logout', [AdminLoginController::class,'logout'])->name('logout');
Route::post('/register-candidates', [ExamController::class, 'registerCandidates'])->name('register-candidates');
Route::get('/AdminSignUp', [AdminLoginController::class,'index'])->name('Admin.signup');
Route::post('/AdminSignUp', [AdminLoginController::class,'store'])->name('Admin.store');
Route::middleware([CheckAdmin::class])->group(function (){
   
    Route::get('/adminDashboard', function () { return view('adminDashboard'); })->name('adminDashboard');
    Route::get('/studentInfo', [ExamController::class,'viewStudentInfo'])->name('studentInfo');
    Route::get('/StartTimer',[TimerController::class,'StartTimer'])->name('StartTimer');
    Route::get('/ResumeTimer',[TimerController::class,'ResumeTimer'])->name('ResumeTimer');
    Route::get('/PauseTimer',[TimerController::class,'PauseTimer'])->name('PauseTimer');
    Route::post('/AdjustTimer',[TimerController::class,'AdjustTimer'])->name('AdjustTimer');
    Route::get('/ResetTimer',[TimerController::class,'ResetTimer'])->name('ResetTimer');
    Route::get('/ViewSubmissions',[ExamController::class,'viewSubmissions'])->name('ViewSubmissions');
    Route::get('/GradeExam',[GradingController::class,'markAnswers'])->name('GradeExam');	
    Route::get('/ViewAnswers/{id}',[ExamController::class,'viewAnswers'])->name('ViewAnswers');
});
Route::get('/makeQuestions', function () {
    return view('MakeQuestions');
});

Route::post('/makeQuestions',[GradingController::class,'makeQuestions'])->name('makeQuestions');


Route::post('/grade-exam', [GradingController::class, 'gradeExam'])->name('grade.exam');


