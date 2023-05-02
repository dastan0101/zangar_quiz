<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use App\Models\Answer;
use App\Models\QnaExam;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\CourseMaterials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TeacherController extends Controller
{
    public function teacherCourseDashboard($id) {
        $subject = Subject::find($id);
        $teacher = User::find($subject->teacher_id);
        $course_material = CourseMaterials::where('course_id', $id)->get();
        return view('teacher.course', compact('subject', 'course_material', 'teacher'));
    }

    public function teacherAddCourseMaterials(Request $request) {
        try {
            $course_material = new CourseMaterials();
            $course_material->course_id = $request->input('course_id');
            $course_material->title = $request->input('title');
            $course_material->description = request('description');
            
            if ($request->hasFile('presentation')) {
                $file = $request->file('presentation');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . "." . $extension;
                $file->move('uploads/slides/', $filename);
                $course_material->presentation = $filename;
            } else {
                $course_material->presentation = 'nofile';
            }
            if ($request->hasFile('video')) {
                $file = $request->file('video');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . "." . $extension;
                $file->move('uploads/videos/', $filename);
                $course_material->video = $filename;
            } else {
                $course_material->video = 'nofile';
            }
            $course_material->save();
            
            return response()->json(['success'=>true, 'msg'=>'Course Materials added successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function teacherGetCourseMaterial($id) {
        try {
            $course_material = CourseMaterials::where('id',$id)->get();
            return response()->json(['success'=>true, 'data'=>$course_material]);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function teacherDownloadCoursePresentation(Request $request, $presentation) {

        return response()->download(public_path('/uploads/slides/' . $presentation));

    }

    public function teacherEditCourseMaterial(Request $request) {
        try {
            $course_material = CourseMaterials::find($request->id);
            $course_material->title = $request->title;
            $course_material->description = $request->description;
            if ($request->hasFile('presentation')) {
                $destination = 'uploads/slides/'.$course_material->presentation;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('presentation');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . "." . $extension;
                $file->move('uploads/slides/', $filename);
                $course_material->presentation = $filename;
            } else {
                $course_material->presentation = 'nofile';
            }
            if ($request->hasFile('video')) {
                $destination = 'uploads/videos/'.$course_material->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('video');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . "." . $extension;
                $file->move('uploads/videos/', $filename);
                $course_material->video = $filename;
            } else {
                $course_material->video = 'nofile';
            }
            
            $course_material->update();
            return response()->json(['success'=>true, 'msg'=>'Course Material edited successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function teacherDeleteCourseMaterial(Request $request) {
        try {
            CourseMaterials::where('id', $request->id)->delete();
            return response()->json(['success'=>true, 'msg'=>'Course Material deleted successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    } 

    public function teacherExamDashboard() {
        
        $subjects = Subject::where('teacher_id', Auth::user()->id)->get();
        $all_exams = Exam::with('subjects')->get();
        $exams = collect();
        foreach ($subjects as $subject) {
            foreach ($all_exams as $exam) {
                if ($exam->subject_id === $subject->id) {
                    $exams->push($exam);
                }
            }
            
        }
                        
        return view('teacher.exam-dashboard', ['subjects'=>$subjects, 'exams'=>$exams]);
    }

    public function teacherAddExam(Request $request) {
        try {
            $unique_id = uniqid('exid');
            Exam::insert([
                'exam_name' => $request->exam_name,
                'subject_id' => $request->subject_id,
                'date' => $request->date,
                'time' => $request->time,
                'attempt' => $request->attempt,
                'enterance_id' => $unique_id
            ]);
            return response()->json(['success'=>true, 'msg'=>'Exam added successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }
    
    public function teacherGetExamDetail($id) {
        try {
            $exam = Exam::where('id',$id)->get();
            return response()->json(['success'=>true, 'data'=>$exam]);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function teacherEditExam(Request $request) {
        try {
            $exam = Exam::find($request->exam_id);
            $exam->exam_name = $request->exam_name;
            $exam->subject_id = $request->subject_id;
            $exam->date = $request->date;
            $exam->time = $request->time;
            $exam->attempt = $request->attempt;
            $exam->save();
            return response()->json(['success'=>true, 'msg'=>'Exam edited successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function teacherDeleteExam(Request $request) {
        try {
            Exam::where('id', $request->exam_id)->delete();
            return response()->json(['success'=>true, 'msg'=>'Exam deleted successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    // get questions 
    public function teacherGetQuestions(Request $request) {
        try {

            $questions = Question::all();

            if (count($questions) > 0) {
                $data = [];
                $counter = 0;
                foreach($questions as $question) {
                    $qnaExam = QnaExam::where(['exam_id'=>$request->exam_id, 'question_id'=>$question->id])->get();
                    if (count($qnaExam) == 0) {
                        $data[$counter]['id'] = $question->id;
                        $data[$counter]['questions'] = $question->question;
                        $counter++;
                    }
                } 
                return response()->json(['success'=>true, 'msg'=>'Question data!', 'data'=>$data]);
            } else {
                return response()->json(['success'=>false, 'msg'=>'Question not found!']);
            }
            
        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    // add questions to exam
    public function teacherAddQuestions(Request $request) {
        try {
            
            if (isset($request->questions_ids)) {
                
                foreach ($request->questions_ids as $question_id) {
                    QnaExam::insert([
                        'exam_id' => $request->exam_id,
                        'question_id' => $question_id,

                    ]);
                }
            }
            return response()->json(['success'=>true, 'msg'=>'Question added to exam successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    // show exam questions
    public function teacherGetExamQuestions(Request $request) {
        try {
            
            $data = QnaExam::where('exam_id', $request->exam_id)->with('question')->get();
            return response()->json(['success'=>true, 'msg'=>'Questions details', 'data'=>$data]);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    // delete question from exam
    public function teacherDeleteExamQuestions(Request $request) {
        try {
            
            QnaExam::where('id', $request->id)->delete();
            return response()->json(['success'=>true, 'msg'=>'Question deleted successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    // add marks
    public function teacherMarksDashboard() {
        $subjects = Subject::where('teacher_id', Auth::user()->id)->get();
        $all_exams = Exam::with('subjects')->with('getQnaExam')->get();
        $exams = collect();
        foreach ($subjects as $subject) {
            foreach ($all_exams as $exam) {
                if ($exam->subject_id === $subject->id) {
                    $exams->push($exam);
                }
            }
            
        }
        // $exams = Exam::where('subject_id', )->with('getQnaExam')->get();

        return view('teacher.marks-dashboard', compact('exams'));
    }

    // edit marks
    public function teacherEditMarks(Request $request) {

        try {
            
            Exam::where('id', $request->exam_id)->update([
                'marks' => $request->marks,
                'pass_marks' => $request->pass_marks
            ]);

            return response()->json(['success'=>true, 'msg'=>'Marks edited successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }

    }

        
    public function teacherQuestionAnswerDashboard() {
        $questions = Question::with('answers')->get();
        return view('teacher.question-answer-dashboard', compact('questions'));
    }

    public function teacherAddQna(Request $request) {
        try {

            $explanation = null;

            if (isset($request->explanation)) {
                $explanation = $request->explanation;
            }

            $questionId = Question::insertGetId([
                'question' => $request->question,
                'explanation' => $explanation
            ]);

            foreach ($request->answers as $answer) {

                $is_correct = 0;

                if ($request->is_correct == $answer) {
                    $is_correct = 1;
                }
                Answer::insert([
                    'question_id' => $questionId,
                    'answer' => $answer,
                    'is_correct' => $is_correct
                ]);
            }

            return response()->json(['success'=>true, 'msg'=>'Question and answer added successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }
    public function teacherGetQnaExamDetails(Request $request) {
        $qna = Question::where('id', $request->questionId)->with('answers')->get();
        return response()->json(['data'=>$qna]);
    }

    public function teacherDeleteAnswer(Request $request) {
        Answer::where('id', $request->id)->delete();
        return response()->json(['success'=>true, 'msg'=>'Answer is deleted successfully.']);
    }

    public function teacherEditQna(Request $request) {

        try {

            Question::where('id', $request->question_id)->update([
                'question'=>$request->question,
                'explanation'=>$request->explanation
            ]);
            
            // old answer edit
            if (isset($request->answers)) {
                
                foreach($request->answers as $key => $value) {

                    $is_correct = 0;

                    if ($request->is_correct == $value) {
                        $is_correct = 1;
                    }

                    Answer::where('id', $key)->update([
                        'question_id'=>$request->question_id,
                        'answer'=>$value,
                        'is_correct'=>$is_correct
                    ]);
                }

            }
            
            // new answer add
            if (isset($request->new_answers)) {
                
                foreach($request->new_answers as $answer) {

                    $is_correct = 0;

                    if ($request->is_correct == $answer) {
                        $is_correct = 1;
                    }

                    Answer::insert([
                        'question_id'=>$request->question_id,
                        'answer'=>$answer,
                        'is_correct'=>$is_correct
                    ]);
                }

            }

            return response()->json(['success'=>true, 'msg'=>'Question and Answer edited successfully.']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }

    }

    public function teacherDeleteQna(Request $request) {
        try {
            Question::where('id', $request->qna_id)->delete();
            Answer::where('question_id', $request->qna_id)->delete();
            return response()->json(['success'=>true, 'msg'=>'Question and Answers deleted successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

}
