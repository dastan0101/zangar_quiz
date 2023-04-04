<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\QnaExam;
use App\Models\ExamAttempt;
use App\Models\ExamAnswer;

use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function loadExamDashboard($id) {
        $qnaExam = Exam::where('enterance_id', $id)->with('getQnaExam')->get();
        if (count($qnaExam) > 0) {
            
            if ($qnaExam[0]['date'] == date('Y-m-d')) {

                if (count($qnaExam[0]['getQnaExam']) > 0) {
                    
                    $qna = QnaExam::where('exam_id', $qnaExam[0]['id'])->with('question', 'answers')->inRandomOrder()->get();
                    return view('student.exam-dashboard', ['success'=>true, 'exam'=>$qnaExam, 'qna'=>$qna]);

                } else {
                    return view('student.exam-dashboard', ['success'=>false, 'msg'=>'This exam is not available for now!', 'exam'=>$qnaExam]);
                }
                

            } elseif ($qnaExam[0]['date'] > date('Y-m-d')) {
                return view('student.exam-dashboard', ['success'=>false, 'msg'=>'This exam will be start on '.$qnaExam[0]['date'], 'exam'=>$qnaExam]);
            } else {
                return view('student.exam-dashboard', ['success'=>false, 'msg'=>'This exam expired on '.$qnaExam[0]['date'], 'exam'=>$qnaExam]);
            }
            
        } else {
            return view('404');
        }
    }

    public function examSubmit(Request $request) {

        $attempt_id = ExamAttempt::insertGetId([
            'exam_id' => $request->exam_id,
            'user_id' => Auth::user()->id
        ]);

        $count = count($request->q);

        if ($count > 0) {
            
            for ($i=0; $i < $count; $i++) { 
                ExamAnswer::insert([
                    'attempt_id' => $attempt_id,
                    'question_id' => $request->q[$i],
                    'answer_id' => request()->input('answer_'.($i+1))
                ]);
            }


        }

        return view('thank-you');

    }
}
