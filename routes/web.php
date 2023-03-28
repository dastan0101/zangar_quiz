<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/register', [AuthController::class, 'loadRegister']);
Route::post('/register', [AuthController::class, 'studentRegister'])->name('studentRegister');

Route::get('/login', function () {
    return redirect('/');
});

Route::get('/', [AuthController::class, 'loadLogin']);
Route::get('/login', [AuthController::class, 'userLogin'])->name('userLogin');

Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/forget-password', [AuthController::class, 'forgetPasswordLoad']);
Route::post('/forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');

Route::get('/reset-password', [AuthController::class, 'resetPasswordLoad']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');

Route::group(['middleware'=>['web', 'checkAdmin']], function(){
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard']);

    // Add subject
    Route::post('/add-subject', [AdminController::class, 'addSubject'])->name('addSubject');
    Route::post('/edit-subject', [AdminController::class, 'editSubject'])->name('editSubject');
    Route::post('/delete-subject', [AdminController::class, 'deleteSubject'])->name('deleteSubject');

    // exam
    Route::get('/admin/exam', [AdminController::class, 'examDashboard']);
    Route::post('/add-exam', [AdminController::class, 'addExam'])->name('addExam');
    Route::get('/get-exam-detail/{id}', [AdminController::class, 'getExamDetail'])->name('getExamDetail');
    Route::post('/edit-exam', [AdminController::class, 'editExam'])->name('editExam');
    Route::post('/delete-exam', [AdminController::class, 'deleteExam'])->name('deleteExam');

    // question and answer
    Route::get('/admin/question-answer', [AdminController::class, 'questionAnswerDashboard']);
    Route::post('/add-question-answer', [AdminController::class, 'addQna'])->name('addQna');
    Route::get('/get-question-answer-details', [AdminController::class, 'getQnaDetails'])->name('getQnaDetails');
    Route::get('/delete-answer', [AdminController::class, 'deleteAnswer'])->name('deleteAnswer');
    Route::post('/edit-question-answer', [AdminController::class, 'editQna'])->name('editQna');
    Route::get('/delete-question-answer', [AdminController::class, 'deleteQna'])->name('deleteQna');
    Route::post('/import-question-answer', [AdminController::class, 'importQna'])->name('importQna');
    
    // Students
    Route::get('/admin/students', [AdminController::class, 'studentsDashboard']);
    Route::post('/add-student', [AdminController::class, 'addStudent'])->name('addStudent');
    Route::post('/edit-student', [AdminController::class, 'editStudent'])->name('editStudent');
    Route::post('/delete-student', [AdminController::class, 'deleteStudent'])->name('deleteStudent');

});

Route::group(['middleware'=>['web', 'checkStudent']], function(){
    Route::get('/dashboard', [AuthController::class, 'loadDashboard']);
});



