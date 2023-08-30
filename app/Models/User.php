<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'newsletter',
        'ip_address',
        'name_on_certificate'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_signed_in' => 'datetime',
        'newsletter' => 'boolean'
    ];

    public function courses()
    {
        // hasMany?
        return $this->belongsToMany(Course::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function progresses()
    {
        return $this->hasMany(Progress::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    public function trackers()
    {
        return $this->hasMany(Tracker::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function getAmountSpentAttribute()
    {
        return $this->orders->where('status', '=', 'paid')->sum('price');
    }

    public function getEnrollmentsCountAttribute()
    {
        return $this->courses->count();
    }

    public function lastLesson($course_id)
    {
        // todo: fix this
        // $lessons = $this->lessons()->where([
        // ['course_id', '=', $course_id]
        // ])->get();

        $last_lesson = DB::table('lesson_user')->where([
            ['user_id', '=', $this->id],
            ['course_id', '=', $course_id]
        ])->orderBy('lesson_id', 'DESC');

        if ($last_lesson->exists()) {
            $last_lesson_id = $last_lesson->first()->lesson_id;
            $last_lesson = Lesson::where('id', $last_lesson_id)->first();
        } else {
            $last_lesson = Course::where('id', $course_id)->first()->lessons->first();
        }

        return $last_lesson;
    }

    public function hasCourse($slug)
    {
        return $this->courses()->where('slug', $slug)->exists();
    }

    public function getFinishedLessons($course_id)
    {
//        $finished = DB::table('lesson_user')->where([
//            ['user_id', '=', $this->id],
//            ['course_id', '=', $course_id]
//        ])->pluck('lesson_id');
//
//
//        $finished = $this->lessons()->where('course_id', $course_id)->pluck('id');
//
//        dd($finished);

        return DB::table('lesson_user')->where([
            ['user_id', '=', $this->id],
            ['course_id', '=', $course_id]
        ])->pluck('lesson_id')->toArray();
    }

    public function getCourseProgress($course_id)
    {
        $progress = $this->progresses()->where('course_id', $course_id);

        if ($progress->exists()) {
            return $progress->first()->percentage;
        }

        Progress::create([
            'user_id' => $this->id,
            'course_id' => $course_id,
            'percentage' => 0
        ]);

        return 0;
    }

    public function updateCourseProgress($course, $lesson)
    {
        // add to table
        $record_exists = DB::table('lesson_user')->where([
            ['lesson_id', '=', $lesson->id],
            ['user_id', '=', $this->id],
            ['course_id', '=', $course->id]
        ])->exists();

        if (!$record_exists) {
            DB::table('lesson_user')->insert([
                'lesson_id' => $lesson->id,
                'user_id' => $this->id,
                'course_id' => $course->id
            ]);

        }

        recalculate_progress($this, $course);

        return true;
    }

    public function getSurveyData($lesson_id)
    {
        $survey = $this->surveys()->where('lesson_id', $lesson_id);

        if ($survey->exists()) {
            return json_decode($survey->orderBy('created_at', 'DESC')->first()->data);
        }

        return null;
    }

    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
    }

    public function getLastNameAttribute()
    {
        $names = explode(' ', $this->name);

        if (isset($names[1])) {
            return $names[1];
        }

        return $names[0];
    }

    public function generateCertificate($course, $size = 'square')
    {
        $template = create_certificate($this->name_on_certificate, $course, $size);
        $filename = 'amos_academy_certificate_' . $course->slug . '_' . Str::slug($this->name_on_certificate) . '.jpg';
        header('Content-Type: image/jpeg');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        imagejpeg($template);
        imagedestroy($template);
    }
}
