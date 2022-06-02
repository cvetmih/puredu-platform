<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $types = [
        'video' => 'Video',
        'quiz' => 'Quiz',
        'multimedia' => 'Multimedia',
        'text' => 'Text',
        'survey' => 'Survey',
        'audio' => 'Audio',
        'download' => 'Download',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'is_downloadable' => 'boolean',
        'is_autoplay' => 'boolean',
        'questions' => 'json'
    ];

    protected $with = [
//        'video',
//        'chapter'
    ];

    protected $appends = [
        'next_lesson',
        'previous_lesson',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }

    public function getIconAttribute()
    {
        return $this->type;
    }

    public function getPreviousLessonAttribute()
    {
        $prev = Lesson::where([
            ['course_id', '=', $this->course_id],
            ['id', '<', $this->id]
        ])->orderBy('id', 'DESC');

        if ($prev->exists()) {
            $prev = $prev->first();
            return [
                'chapter_id' => $prev->chapter_id,
                'slug' => $prev->slug,
                'title' => $prev->title
            ];
        }

        return null;
    }

    public function getNextLessonAttribute()
    {
        $next = Lesson::where([
            ['course_id', '=', $this->course_id],
            ['id', '>', $this->id]
        ])->orderBy('id');

        if ($next->exists()) {
            $next = $next->first();
            return [
                'chapter_id' => $next->chapter_id,
                'slug' => $next->slug,
                'title' => $next->title
            ];
        }

        return null;
    }
}
