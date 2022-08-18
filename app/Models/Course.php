<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
        'lesson_count',
        'is_presale',
        'launching_days',
        'final_price',
        'final_price_formatted',
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

//        if (isset($this->image_id) && isset($this->image)) {
//            return $this->image->url;
//        }
//
//        return asset('img/placeholder.jpg');
    }

    public function getFirstLessonAttribute()
    {
        $first_lesson = Lesson::where('course_id', $this->id);

        if (!$first_lesson->exists()) {
            return null;
        }

        return $first_lesson->first()->slug;
    }

    public function getFirstChapterAttribute()
    {
        $first_lesson = Lesson::where('course_id', $this->id);

        if (!$first_lesson->exists()) {
            return null;
        }

        return $first_lesson->first()->chapter_id;
    }

    public function getLessonCountAttribute()
    {
        return $this->lessons()->count();
    }

    public function getIsPresaleAttribute()
    {
        $available_at = new Carbon($this->available_at);

        if ($available_at->isPast()) return false;

        $now = Carbon::now();
        return $available_at->diff($now)->days > 0;
    }

    public function getLaunchingDaysAttribute()
    {
        $available_at = new Carbon($this->available_at);

        if ($available_at->isPast()) return 0;

        $now = Carbon::now();
        return $available_at->diff($now)->days;
    }

    public function getPriceFormattedAttribute()
    {
        return format_money($this->price);
    }

    public function getSaleFormattedAttribute()
    {
        return format_money($this->sale);
    }

    public function getFinalPriceAttribute()
    {
        return $this->price - $this->sale;
    }

    public function getFinalPriceFormattedAttribute()
    {
        return format_money($this->final_price);
    }
}
