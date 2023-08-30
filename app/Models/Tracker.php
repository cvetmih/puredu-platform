<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'body'
    ];

    protected $casts = [
        'body' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
