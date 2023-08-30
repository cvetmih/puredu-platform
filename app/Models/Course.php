<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
        'available_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'timeline' => 'json',
        'is_available' => 'boolean',
        'previews' => 'json',
        'available_at' => 'datetime',
    ];

    protected $with = [
//        'chapters',
//        'educator'
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

    protected static function booted()
    {
        static::created(function ($course) {
            static::flushCache($course);
        });

        static::updated(function ($course) {
            static::flushCache($course);
        });

        static::saved(function ($course) {
            static::flushCache($course);
        });
    }

    protected static function flushCache($course)
    {
        Cache::forget('courses');
        Cache::forget('course_' . $course->slug);
        Cache::forget('course_' . $course->slug . '_with_chapters');
        Cache::forget('chapters_' . $course->slug);
    }

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
        return $this->belongsToMany(Lesson::class)
            ->using(CourseLesson::class)
            ->withPivot('chapter_id', 'order')
            ->orderBy('order');


//        return $this->belongsToMany(Lesson::class, 'course_lesson')
//            ->withPivot('chapter_id')
//            ->orderBy('number');

//        return $this->hasMany(Lesson::class)->orderBy('number');
    }

//    public function bundles()
//    {
//        return $this->belongsToMany(Bundle::class);
//    }

    public function educator()
    {
        return $this->belongsTo(Educator::class);
    }

    public function discounts()
    {
        return $this->morphToMany(Discount::class, 'discountable');
    }

    public function getFirstLessonAttribute()
    {
        return $this->lessons()->orderBy('order', 'ASC')->first();
    }

    public function getFirstChapterAttribute()
    {
        return $this->first_lesson ? $this->first_lesson->chapter_id : null;
    }

    public function getLessonCountAttribute()
    {
        return getLessonCount($this->slug);
    }

    public function getIsPresaleAttribute()
    {
        if ($this->is_available) return false;

        if ($this->available_at->isPast()) return false;

        $now = Carbon::now();

//        return $this->available_at->diff($now)->days > 0;
        return $this->available_at->diffInSeconds($now) > 0;
    }

    public function getLaunchingDaysAttribute()
    {
        if ($this->available_at->isPast()) return 0;

        $now = Carbon::now();
        return $this->available_at->diff($now)->days;
    }

    public function getLaunchingInAttribute()
    {
        if ($this->available_at->isPast()) return '-';

        $now = Carbon::now();

        $days = $this->available_at->diffInDays($now);
        $hours = $this->available_at->diffInHours($now) - ($days * 24);
        $minutes = $this->available_at->diffInMinutes($now) - ($days * 24 * 60) - ($hours * 60);

        return $days . 'D ' . $hours . 'H ' . $minutes . 'M';
    }

    public function getLaunchingMonthAttribute()
    {
        return $this->available_at->format('M');
    }

    public function getPriceFormattedAttribute()
    {
        return format_money($this->price);
    }

    public function getPresalePriceFormattedAttribute()
    {
        return format_money($this->presale_price);
    }

    public function getIsNewAttribute()
    {
        return $this->available_at->diffInDays(Carbon::now()) <= 30;
    }

    public function getHeroImageAttribute()
    {
        return asset('img/courses/' . $this->slug . '/hero.jpg');
    }

    public function getHeroImageMobileAttribute()
    {
        return asset('img/courses/' . $this->slug . '/hero_mobile.jpg');
    }

    public function gtm_data($event = 'add_to_cart', $discount = null)
    {
        return getGtmFullData($event, $this, $discount);
    }

    public function getFullTitleLengthAttribute()
    {
        return strlen($this->full_title);
    }

    public function getHoursFormattedAttribute()
    {
        return $this->hours . 'h';
    }

    public function getApplicableDiscount($code = null)
    {
        $discount = null;

        if ($code) {
            // Find discount by code
            $discount = Discount::where('code', $code)
                ->whereNull('bundle_id')
                ->where('manual', true)
                ->where(function ($query) {
                    $query->whereNull('user_id')
                        ->orWhere('user_id', Auth::id());
                })
                ->where(function ($query) {
                    $query->where('start_date', '<=', Carbon::now())
                        ->where('end_date', '>=', Carbon::now());
                })
                ->first();
        }

        if (!$discount) {
            // Find discount for this course
            $discount = Discount::where('course_id', $this->id)
                ->where(function ($query) use ($code) {
                    if ($code) {
                        $query->where('code', '!=', $code);
                    }
                })
                ->where('manual', false)
                ->where(function ($query) {
                    $query->whereNull('user_id')
                        ->orWhere('user_id', Auth::id());
                })
                ->where(function ($query) {
                    $query->where('start_date', '<=', Carbon::now())
                        ->where('end_date', '>=', Carbon::now());
                })
                ->first();
        }

        if (!$discount) {
            // Find discount for all courses
            $discount = Discount::whereNull('course_id')
                ->whereNull('bundle_id')
                ->where('manual', false)
                ->where(function ($query) {
                    $query->whereNull('user_id')
                        ->orWhere('user_id', Auth::id());
                })
                ->where(function ($query) {
                    $query->where('start_date', '<=', Carbon::now())
                        ->where('end_date', '>=', Carbon::now());
                })
                ->first();
        }

        return $discount;
    }

    public function getFinalPrice($discount)
    {
        $discounted = 0;

        if ($discount) {
            $discount_type = $discount->discount_type;
            if ($discount_type === 'fixed') {
                $discounted = $discount->discount_value;
            } else if ($discount_type === 'percent') {
                $discounted = $this->price * $discount->discount_value / 100;
            } else if ($discount_type === 'final') {
                return $discount->discount_value;
            }
        }

        if ($this->is_presale) {
            return $this->presale_price - $discounted;
        }

        return $this->price - $discounted;
    }

    public function getFinalPriceFormatted($discount)
    {
        return format_money($this->getFinalPrice($discount));
    }

    public function hasLesson($lesson)
    {
        return $this->lessons()->where('lessons.id', $lesson->id)->exists();
    }
}
