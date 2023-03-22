<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
    ];

    // connection tables
    public function answers() {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }
}
