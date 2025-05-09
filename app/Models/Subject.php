<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'subject_code',
        'teacher_id',
        'description'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function student_grade()
    {
        return $this->hasMany(StudentGrade::class, 'subject_id');
    }
}
