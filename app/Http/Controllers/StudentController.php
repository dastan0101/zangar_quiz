<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\CourseMaterials;

class StudentController extends Controller
{
    public function loadCoursesDashboard() {
        $subjects = Subject::all();
        $teachers = User::where('is_admin', '2')->get();
        return view('student.courses-dashboard', compact('subjects', 'teachers'));
    }

    public function loadCourse($id) {
        $subject = Subject::find($id);
        $teacher = User::find($subject->teacher_id);
        $course_material = CourseMaterials::where('course_id', $id)->get();
        return view('student.course', compact('subject', 'course_material', 'teacher'));
    }

    public function loadExam() {
        $exams = Exam::with('subjects')->orderBy('date')->get();
        return view('student.dashboard', ['exams'=>$exams]);
    }
    
}
