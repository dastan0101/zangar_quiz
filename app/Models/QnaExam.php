<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QnaExam extends Model
{
    use HasFactory;

    public $table = "exams_qna";
    protected $fillable = [
        'exam_id',
        'question_id'
    ];
}
