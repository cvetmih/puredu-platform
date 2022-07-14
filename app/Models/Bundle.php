<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Bundle extends Model
{
    use HasFactory;

    protected $casts = [
        'deadline' => 'datetime',
        'is_active' => 'boolean'
    ];

    protected $appends = [
        'deadline_days',
        'has_deadline',
        'full_price',
        'full_price_formatted',
        'final_price',
        'final_price_formatted',
        'price_formatted',
        'sale_formatted',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function getDeadlineDaysAttribute()
    {
        if (!isset($this->deadline)) return 0;

        $deadline = new Carbon($this->deadline);
        $now = Carbon::now();
        return $deadline->diff($now)->days;
    }

    public function getHasDeadlineAttribute()
    {
        return $this->deadline_days > 0;
    }

    public function getFullPriceAttribute()
    {
        $full_price = 0;

        // todo: make elegant
        foreach ($this->courses as $course) {
            $full_price += $course->price;
        }

        return $full_price;
    }

    public function getFullPriceFormattedAttribute()
    {
        return format_money($this->full_price);
    }

    public function getFinalPriceAttribute()
    {
        return $this->price - $this->sale;
    }

    public function getFinalPriceFormattedAttribute()
    {
        return format_money($this->final_price);
    }

    public function getPriceFormattedAttribute()
    {
        return format_money($this->price);
    }

    public function getSaleFormattedAttribute()
    {
        return format_money($this->sale);
    }

}
