<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $with = [
//        'lessons'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'chapter_lesson')
            ->join('course_lesson', function ($join) {
                $join->on('course_lesson.lesson_id', '=', 'chapter_lesson.lesson_id')
                    ->where('course_lesson.course_id', $this->course_id);
            })
            ->orderBy('course_lesson.order');

//        return $this->belongsToMany(Lesson::class)
//            ->withPivot('order')
//            ->orderBy('pivot_order');
    }
}
