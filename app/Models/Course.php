<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean'
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

    public function getImageUrlAttribute($value)
    {
        return isset($this->image_id) && isset($this->image) ? $this->image->url : asset('img/placeholder.jpg');
    }
}
