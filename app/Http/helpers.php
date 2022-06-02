<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Progress;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

function svg($path)
{
    $fullPath = public_path($path);
    return File::exists($fullPath) ? File::get($fullPath) : '!!!' . $fullPath . '!!!';
}

function format_money($value, $prefix = '$', $suffix = '')
{
    return $prefix . number_format($value, 2) . $suffix;
}

function recalculate_progress(User $user, Course $course)
{
    $total_lessons = $course->lessons()->count();
    $completed_lessons = DB::table('lesson_user')->where([
        ['user_id', '=', $user->id],
        ['course_id', '=', $course->id]
    ])->count();

    $percentage = (int)ceil($completed_lessons / $total_lessons * 100);

    $progress = Progress::where([
        ['user_id', '=', $user->id],
        ['course_id', '=', $course->id]
    ])->first();

    $progress->percentage = $percentage;
    $progress->save();

    return true;
}

function update_progress(User $user, Lesson $lesson)
{
    // add to table
    $record_exists = DB::table('lesson_user')->where([
        ['lesson_id', '=', $lesson->id],
        ['user_id', '=', $user->id],
        ['course_id', '=', $lesson->course->id]
    ])->exists();

    if (!$record_exists) {
        DB::table('lesson_user')->insert([
            'lesson_id' => $lesson->id,
            'user_id' => $user->id,
            'course_id' => $lesson->course->id
        ]);

        recalculate_progress($user, $lesson->course);
    }

    return true;
}
