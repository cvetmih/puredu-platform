<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'timeline' => 'json',
        'coach_images' => 'json',
        'coach_body' => 'json',
    ];

    protected $with = [
        'chapters'
    ];

    protected $appends = [
        'first_lesson',
        'first_chapter',
        'lesson_count'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }

    public function bundles()
    {
        return $this->belongsToMany(Bundle::class);
    }

    public function getImageUrlAttribute($value)
    {
        return asset('img/placeholder.jpg');
        return isset($this->image_id) && isset($this->image) ? $this->image->url : asset('img/placeholder.jpg');
    }

    public function getFirstLessonAttribute()
    {
        $first_lesson = Lesson::where('course_id', $this->id)->first();
        return $first_lesson->slug;
    }

    public function getFirstChapterAttribute()
    {
        $first_lesson = Lesson::where('course_id', $this->id)->first();
        return $first_lesson->chapter_id;
    }

    public function getLessonCountAttribute()
    {
        return $this->lessons()->count();
    }
}
