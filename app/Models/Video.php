<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'vimeo_id',
        'image_id',
        'play_count',
        'last_watched'
    ];

    protected $casts = [
        'last_watched' => 'datetime'
    ];

    public function lessons()
    {
        // belongs to many?
        return $this->hasMany(Lesson::class);
    }
}
