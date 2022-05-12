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

    public function getImageUrlAttribute($value)
    {
        return isset($this->image_id) && isset($this->image) ? $this->image->url : asset('img/placeholder.jpg');
    }
}
