<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Bundle extends Model
{
    use HasFactory;

    protected $casts = [
        'deadline' => 'datetime',
        'is_active' => 'boolean',
        'is_global' => 'boolean'
    ];

    protected $appends = [
        'deadline_days',
        'has_deadline',
        'full_price',
        'full_price_formatted',
        'price_formatted'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class)->orderBy('id', 'desc');
    }

    public function discounts()
    {
        return $this->morphToMany(Discount::class, 'discountable');
    }

    public function getEducatorIdsAttribute()
    {
        return $this->courses()->with('educator')->get()->map(function ($course) {
            return $course->educator->id;
        })->toArray();
    }

    public function getDeadlineDaysAttribute()
    {
        if (!isset($this->deadline)) return -1;

        $deadline = new Carbon($this->deadline);

        if ($deadline->isPast()) return -1;

        $now = Carbon::now();
        return $deadline->diff($now)->days;
    }

    public function getHasDeadlineAttribute()
    {
        return $this->deadline_days > -1;
    }

    public function getFullPriceAttribute()
    {
        return $this->courses->sum('price');
    }

    public function getFullPriceFormattedAttribute()
    {
        return format_money($this->full_price);
    }

    public function getPriceFormattedAttribute()
    {
        return format_money($this->price);
    }

    public function getHoursAttribute()
    {
        return getBundleHours($this);
    }

    public function getLessonCountAttribute()
    {
        return getBundleLessonCount($this);
    }

    public function getApplicableDiscount($code = null, $global = false)
    {
        $discount = null;

        if ($global) {
            $discount = Discount::where('is_global', true)
                ->where('bundle_id', $this->id)
                ->whereNull('course_id')
                ->where(function ($query) {
                    $query->whereNull('user_id')
                        ->orWhere('user_id', Auth::id());
                })
                ->where(function ($query) {
                    $query->where('start_date', '<=', Carbon::now())
                        ->where('end_date', '>=', Carbon::now());
                })
                ->orderBy('id', 'desc')
                ->first();
        } else {
            if ($code) {
                // Find discount by code
                // todo: add to check if bundle_id is not null?
                $discount = Discount::where('code', $code)
                    ->where('bundle_id', $this->id)
                    ->whereNull('course_id')
//                ->where('manual', true)
                    ->where(function ($query) {
                        $query->whereNull('user_id')
                            ->orWhere('user_id', Auth::id());
                    })
                    ->where(function ($query) {
                        $query->where('start_date', '<=', Carbon::now())
                            ->where('end_date', '>=', Carbon::now());
                    })
                    ->orderBy('id', 'desc')
                    ->first();
            }

            if (!$discount) {
                // Find discount for this course
                $discount = Discount::where('bundle_id', $this->id)
//                ->where(function ($query) use ($code) {
//                    if ($code) {
//                        $query->where('code', '!=', $code);
//                    }
//                })
                    ->where('manual', false)
                    ->where(function ($query) {
                        $query->whereNull('user_id')
                            ->orWhere('user_id', Auth::id());
                    })
                    ->where(function ($query) {
                        $query->where('start_date', '<=', Carbon::now())
                            ->where('end_date', '>=', Carbon::now());
                    })
                    ->orderBy('id', 'desc')
                    ->first();
            }

            if (!$discount) {
                // Find discount for all bundles
                $discount = Discount::whereNull('bundle_id')
                    ->whereNull('course_id')
                    ->where('manual', false)
                    ->where(function ($query) use ($code) {
                        if ($code) {
                            $query->where('code', '!=', $code);
                        }
                    })
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

        return $this->price - $discounted;
    }

    public function getFinalPriceFormatted($discount)
    {
        return format_money($this->getFinalPrice($discount));
    }

    public function getFullTitleAttribute($value)
    {
        if (str_contains(strtolower($value), '{final_price}')) {
            return str_replace('{final_price}', $this->getFinalPriceFormatted($this->getApplicableDiscount(null, true)), $value);
        }

        return $value;

    }
}
