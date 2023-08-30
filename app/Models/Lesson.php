<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
        'questions' => 'json',
        'data' => 'json'
    ];

    //    protected $with = [
    //        'video',
    //        'chapter'
    //    ];

    protected $appends = [
        //        'next_lesson',
        //        'previous_lesson',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)
            ->using(CourseLesson::class)
            ->withPivot('chapter_id');
//        return $this->belongsToMany(Course::class, 'course_lesson');
    }

    public function chapters()
    {
        return $this->belongsToMany(Chapter::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getIconAttribute()
    {
        $resolved_types = [
            'audio' => 'audio',
            'certificate' => 'certificate',
            'download' => 'download',
            'file' => 'download',
            'json' => 'text',
            'letters' => 'text',
            'text' => 'text',
            'multimedia' => 'download',
            'quiz' => 'survey',
            'survey' => 'survey',
            'video' => 'video',
            'youtube' => 'video',
        ];

        if (!isset($resolved_types[$this->type])) {
            return svg('icons/lesson-type/text.svg');
        }


        return svg('icons/lesson-type/' . $resolved_types[$this->type] . '.svg');
    }

    public function getTypeForHumansAttribute()
    {
        switch ($this->type) {
            case 'audio':
                return 'Audio';
            case 'certificate':
                return 'Certificate';
            case 'download':
            case 'file':
                return 'Assets';
            case 'json':
            case 'letters':
            case 'text':
                return 'Text';
            case 'multimedia':
                return 'Multimedia';
            case 'quiz':
                return 'Quiz';
            case 'survey':
                return 'Survey';
            case 'video':
                return 'Video';
            default:
                return 'Unknown';
        }
    }

    public function previous_lesson($course_id)
    {
        $order = DB::table('course_lesson')
            ->where('course_id', $course_id)
            ->where('lesson_id', $this->id)
            ->first()
            ->order;

        return DB::table('course_lesson')
            ->join('lessons', 'lessons.id', '=', 'course_lesson.lesson_id')
            ->select('lessons.*')
            ->where('course_id', $course_id)
            ->where('order', '<', $order)
            ->orderBy('order', 'desc')
            ->first();
    }

    public function next_lesson($course_id)
    {
        $order = DB::table('course_lesson')
            ->where('course_id', $course_id)
            ->where('lesson_id', $this->id)
            ->first()
            ->order;

        return DB::table('course_lesson')
            ->join('lessons', 'lessons.id', '=', 'course_lesson.lesson_id')
            ->select('lessons.*')
            ->where('course_id', $course_id)
            ->where('order', '>', $order)
            ->orderBy('order')
            ->first();
    }

    private function getSubtitlesPath()
    {
        $path = str_replace('.mp4', '.vtt', $this->file_url);

        if (File::exists('subtitles/' . $path)) {
            return asset('subtitles/' . $path);
        }

        return false;
    }

    public function getSubtitlesAttribute()
    {
        if ($this->type !== 'video') return false;

        return $this->getSubtitlesPath();
    }

    public function getLengthFormattedAttribute()
    {
        if (!$this->length) return '';
        $minutes = floor($this->length / 60);
        $seconds = $this->length % 60;

        return sprintf("%02d:%02d", $minutes, $seconds);
    }

    public function getChapterFromCourse($course_id)
    {
        $chapter_id = $this->courses()->where('courses.id', $course_id)->first()->pivot->chapter_id;
        return Chapter::find($chapter_id);
    }
}
