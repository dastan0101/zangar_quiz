<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMaterials extends Model
{
    use HasFactory;

    protected $table = "course_materials";

    protected $fillable = [
        "course_id",
        "title",
        "description",
        "presentation",
        "video"
    ];
}
