<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\TeacherController;

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
    return view('index');
});


Route::get('/register', [AuthController::class, 'loadRegister']);
Route::post('/register', [AuthController::class, 'studentRegister'])->name('studentRegister');

Route::get('/login', function () {
    return redirect('/');
});

Route::get('/login', [AuthController::class, 'loadLogin']);
Route::get('/user-login', [AuthController::class, 'userLogin'])->name('userLogin');

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
    Route::get('/get-question-answer-details', [AdminController::class, 'getQnaExamDetails'])->name('getQnaExamDetails');
    Route::get('/delete-answer', [AdminController::class, 'deleteAnswer'])->name('deleteAnswer');
    Route::post('/edit-question-answer', [AdminController::class, 'editQna'])->name('editQna');
    Route::get('/delete-question-answer', [AdminController::class, 'deleteQna'])->name('deleteQna');
    Route::post('/import-question-answer', [AdminController::class, 'importQna'])->name('importQna');
    
    // Students
    Route::get('/admin/students', [AdminController::class, 'studentsDashboard']);
    Route::post('/add-student', [AdminController::class, 'addStudent'])->name('addStudent');
    Route::post('/edit-student', [AdminController::class, 'editStudent'])->name('editStudent');
    Route::post('/delete-student', [AdminController::class, 'deleteStudent'])->name('deleteStudent');

    // add question and answer to exam
    Route::get('/get-questions', [AdminController::class, 'getQuestions'])->name('getQuestions');
    Route::post('/add-questions', [AdminController::class, 'addQuestions'])->name('addQuestions');
    Route::get('/get-exam-questions', [AdminController::class, 'getExamQuestions'])->name('getExamQuestions');
    Route::get('/delete-exam-questions', [AdminController::class, 'deleteExamQuestions'])->name('deleteExamQuestions');

    // marks 
    Route::get('/admin/marks', [AdminController::class, 'marksDashboard']);
    Route::post('/edit-marks', [AdminController::class, 'editMarks'])->name('editMarks');

    // review exams
    Route::get('/admin/review-exams', [AdminController::class, 'reviewExams'])->name('reviewExams');
    Route::get('/get-reviewed-qna', [AdminController::class, 'reviewQna'])->name('reviewQna');

    Route::post('/approved-qna', [AdminController::class, 'approvedQna'])->name('approvedQna');

    // course material
    Route::get('/admin/course-{id}', [AdminController::class, 'courseDashboard']);
    Route::post('/add-course-materials', [AdminController::class, 'addCourseMaterials'])->name('addCourseMaterials');
    Route::get('/get-course-material/{id}', [AdminController::class, 'getCourseMaterial'])->name('getCourseMaterial');
    Route::get('/download-presentation/{presentation}', [AdminController::class, 'downloadCoursePresentation'])->name('downloadCoursePresentation');
    Route::post('/edit-course-materials', [AdminController::class, 'editCourseMaterial'])->name('editCourseMaterial');
    Route::post('/delete-course-material', [AdminController::class, 'deleteCourseMaterial'])->name('deleteCourseMaterial');
    
});





Route::group(['middleware'=>['web', 'checkTeacher']], function(){
    Route::get('/teacher/dashboard', [AuthController::class, 'teacherDashboard']);
    Route::get('/teacher/course-{id}', [TeacherController::class, 'teacherCourseDashboard']);
    Route::post('/teacher/add-course-materials', [TeacherController::class, 'teacherAddCourseMaterials'])->name('teacherAddCourseMaterials');
    Route::get('/teacher/get-course-material/{id}', [TeacherController::class, 'teacherGetCourseMaterial'])->name('teacherGetCourseMaterial');
    Route::get('/teacher/download-presentation/{presentation}', [TeacherController::class, 'teacherDownloadCoursePresentation'])->name('teacherDownloadCoursePresentation');
    Route::post('/teacher/edit-course-materials', [TeacherController::class, 'teacherEditCourseMaterial'])->name('teacherEditCourseMaterial');
    Route::post('/teacher/delete-course-material', [TeacherController::class, 'teacherDeleteCourseMaterial'])->name('teacherDeleteCourseMaterial');
    
    // exam
    Route::get('/teacher/exam', [TeacherController::class, 'teacherExamDashboard']);
    Route::post('/teacher/add-exam', [TeacherController::class, 'teacherAddExam'])->name('teacherAddExam');
    Route::get('/teacher/get-exam-detail/{id}', [TeacherController::class, 'teacherGetExamDetail'])->name('teacherGetExamDetail');
    Route::post('/teacher/edit-exam', [TeacherController::class, 'teacherEditExam'])->name('teacherEditExam');
    Route::post('/teacher/delete-exam', [TeacherController::class, 'teacherDeleteExam'])->name('teacherDeleteExam');

    // add question and answer to exam
    Route::get('/teacher/get-questions', [TeacherController::class, 'teacherGetQuestions'])->name('teacherGetQuestions');
    Route::post('/teacher/add-questions', [TeacherController::class, 'teacherAddQuestions'])->name('teacherAddQuestions');
    Route::get('/teacher/get-exam-questions', [TeacherController::class, 'teacherGetExamQuestions'])->name('teacherGetExamQuestions');
    Route::get('/teacher/delete-exam-questions', [TeacherController::class, 'teacherDeleteExamQuestions'])->name('teacherDeleteExamQuestions');

    // marks 
    Route::get('/teacher/marks', [TeacherController::class, 'teacherMarksDashboard']);
    Route::post('/teacher/edit-marks', [TeacherController::class, 'teacherEditMarks'])->name('teacherEditMarks');

    // question and answer
    Route::get('/teacher/question-answer', [TeacherController::class, 'teacherQuestionAnswerDashboard']);
    Route::post('/teacher/add-question-answer', [TeacherController::class, 'teacherAddQna'])->name('teacherAddQna');
    Route::get('/teacher/get-question-answer-details', [TeacherController::class, 'teacherGetQnaExamDetails'])->name('teacherGetQnaExamDetails');
    Route::get('/teacher/delete-answer', [TeacherController::class, 'teacherDeleteAnswer'])->name('teacherDeleteAnswer');
    Route::post('/teacher/edit-question-answer', [TeacherController::class, 'teacherEditQna'])->name('teacherEditQna');
    Route::get('/teacher/delete-question-answer', [TeacherController::class, 'teacherDeleteQna'])->name('teacherDeleteQna');
    Route::post('/teacher/import-question-answer', [TeacherController::class, 'teacherImportQna'])->name('teacherImportQna');
    
});







Route::group(['middleware'=>['web', 'checkStudent']], function(){
    Route::get('/dashboard', [AuthController::class, 'loadDashboard']);
    Route::get('/exam/{id}', [ExamController::class, 'loadExamDashboard']);

    Route::post('/exam-submit', [ExamController::class, 'examSubmit'])->name('examSubmit');

    Route::get('/results', [ExamController::class, 'resultDashboard'])->name('resultDashboard');
    Route::get('/review-student-qna', [ExamController::class, 'reviewQna'])->name('reviewStudentQna');
});



