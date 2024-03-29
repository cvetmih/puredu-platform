<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = [
        'course',
        'bundle'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }
}
