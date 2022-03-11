<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'expiry_date',
        'amount',
        'type',
        'codes'
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'codes' => 'json'
    ];
}
