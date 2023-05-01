<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use App\Models\Answer;
use App\Models\QnaExam;
use App\Models\Subject;
use App\Models\Question;
use App\Imports\QnaImport;

use App\Models\ExamAnswer;
use App\Models\ExamAttempt;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CourseMaterials;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller {

    // Subject methods

    public function addSubject(Request $request) {
        try {
            Subject::insert([
                'subject' => $request->subject,
                'teacher_id' => $request->teacher_id
            ]);
            return response()->json(['success'=>true, 'msg'=>'Subject added successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }
    
    public function editSubject(Request $request) {
        try {
            $subject = Subject::find($request->id);
            $subject->subject = $request->subject;
            $subject->teacher_id = $request->teacher_id;
            $subject->save();
            return response()->json(['success'=>true, 'msg'=>'Subject edited successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function deleteSubject(Request $request) {
        try {
            Subject::where('id', $request->id)->delete();
            return response()->json(['success'=>true, 'msg'=>'Subject deleted successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }


    // Exam methods

    public function examDashboard() {
        $subjects = Subject::all();
        $exams = Exam::with('subjects')->get();
        return view('admin.exam-dashboard', ['subjects'=>$subjects, 'exams'=>$exams]);
    }

    public function addExam(Request $request) {
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
    
    public function getExamDetail($id) {
        try {
            $exam = Exam::where('id',$id)->get();
            return response()->json(['success'=>true, 'data'=>$exam]);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function editExam(Request $request) {
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

    public function deleteExam(Request $request) {
        try {
            Exam::where('id', $request->exam_id)->delete();
            return response()->json(['success'=>true, 'msg'=>'Exam deleted successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }
    
    public function questionAnswerDashboard() {
        $questions = Question::with('answers')->get();
        return view('admin.question-answer-dashboard', compact('questions'));
    }

    public function addQna(Request $request) {
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
    public function getQnaExamDetails(Request $request) {
        $qna = Question::where('id', $request->questionId)->with('answers')->get();
        return response()->json(['data'=>$qna]);
    }

    public function deleteAnswer(Request $request) {
        Answer::where('id', $request->id)->delete();
        return response()->json(['success'=>true, 'msg'=>'Answer is deleted successfully.']);
    }

    public function editQna(Request $request) {

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

    public function deleteQna(Request $request) {
        try {
            Question::where('id', $request->qna_id)->delete();
            Answer::where('question_id', $request->qna_id)->delete();
            return response()->json(['success'=>true, 'msg'=>'Question and Answers deleted successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function importQna(Request $request) {
        try {
            Excel::import(new QnaImport, $request->file('file'));

            return response()->json(['success'=>false, 'msg'=>'Import Q&A successfully!']);
            
        } catch (\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function studentsDashboard() {
        $students = User::where('is_admin', 0)->get();
        return view('admin.students-dashboard', compact('students'));
    }
    
    // add student
    public function addStudent(Request $request) {
        try {
            $password = Str::random(8);

            User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
            ]);

            $url = URL::to('/');

            $data['url'] = $url;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = $password;
            $data['title'] = "Student registration on Zangar-M";

            Mail::send('registrationMail', ['data'=>$data], function($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });

            return response()->json(['success'=>true, 'msg'=>"Student added succesfully!"]);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    // edit student
    public function editStudent(Request $request) {
        try {
            
            $user = User::find($request->id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $url = URL::to('/');

            $data['url'] = $url;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['title'] = "Student profile edited on Zangar-M";

            Mail::send('editProfileMail', ['data'=>$data], function($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });

            return response()->json(['success'=>true, 'msg'=>"Student edited succesfully!"]);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    // delete student
    public function deleteStudent(Request $request) {
        try {
            User::where('id', $request->id)->delete();
            return response()->json(['success'=>true, 'msg'=>"Student deleted succesfully!"]);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    // get questions 
    public function getQuestions(Request $request) {
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
    public function addQuestions(Request $request) {
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
    public function getExamQuestions(Request $request) {
        try {
            
            $data = QnaExam::where('exam_id', $request->exam_id)->with('question')->get();
            return response()->json(['success'=>true, 'msg'=>'Questions details', 'data'=>$data]);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    // delete question from exam
    public function deleteExamQuestions(Request $request) {
        try {
            
            QnaExam::where('id', $request->id)->delete();
            return response()->json(['success'=>true, 'msg'=>'Question deleted successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    // add marks
    public function marksDashboard() {

        $exams = Exam::with('getQnaExam')->get();

        return view('admin.marks-dashboard', compact('exams'));
    }

    // edit marks
    public function editMarks(Request $request) {

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

    // load review exams page
    public function reviewExams() {

        $attempts = ExamAttempt::with(['user', 'exam'])->orderBy('id')->get();
        return view('admin.review-exams', compact('attempts'));
    }
    

    public function reviewQna(Request $request) {

        try {
            $attemptData = ExamAnswer::where('attempt_id', $request->attempt_id)->with(['question', 'answers'])->get();
            return response()->json(['success'=>true, 'data'=>$attemptData]);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
        
        
    }

    public function approvedQna(Request $request) {

        try {
            $attemptId = $request->attempt_id;

            $examData = ExamAttempt::where('id', $attemptId)->with('user', 'exam')->get();
            $examMarks = $examData[0]['exam']['marks'];

            $attemptData = ExamAnswer::where('attempt_id', $attemptId)->with('answers')->get();

            $totalMarks = 0;

            if (count($attemptData) > 0) {
                
                foreach ($attemptData as $attempt) {
                    
                    if ($attempt->answers->is_correct == 1) {
                        $totalMarks += $examMarks;
                    }

                }

            } 
            
            ExamAttempt::where('id', $attemptId)->update([
                'status' => 1,
                'marks' => $totalMarks
            ]);

            $url = URL::to('/');
            $data['url'] = $url.'/results';
            $data['name'] = $examData[0]['user']['name'];
            $data['email'] = $examData[0]['user']['email'];
            $data['exam_name'] = $examData[0]['exam']['exam_name'];
            $data['title'] = $examData[0]['exam']['exam_name'].' Result';

            Mail::send('result-mail', ['data'=>$data], function($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
            });

            return response()->json(['success'=>true, 'msg'=>'Qna Approved Successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }

    }

    public function courseDashboard($id) {
        $subject = Subject::find($id);
        $teacher = User::find($subject->teacher_id);
        $course_material = CourseMaterials::where('course_id', $id)->get();
        return view('admin.course', compact('subject', 'course_material', 'teacher'));
    }

    public function addCourseMaterials(Request $request) {
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

    public function getCourseMaterial($id) {
        try {
            $course_material = CourseMaterials::where('id',$id)->get();
            return response()->json(['success'=>true, 'data'=>$course_material]);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function downloadCoursePresentation(Request $request, $presentation) {

        return response()->download(public_path('/uploads/slides/' . $presentation));

    }

    public function editCourseMaterial(Request $request) {
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

    public function deleteCourseMaterial(Request $request) {
        try {
            CourseMaterials::where('id', $request->id)->delete();
            return response()->json(['success'=>true, 'msg'=>'Course Material deleted successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }    

}
 