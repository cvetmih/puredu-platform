<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/courses', function () {
    return Course::whereIsActive(true)->get();
});

Route::get('/courses/{course}', function (Course $course) {
    return $course;
});

Route::get('/courses/{course}/lessons', function (Course $course) {
    return $course->lessons;
});

Route::get('/lessons/{lesson}', function (Lesson $lesson) {
    return $lesson;
});

Route::get('/courses/{course}', function (Course $course) {
    return $course;
});

Route::post('/orders/create', function () {
    Order::create([
        'user_id' => request('user_id'),
        'course_id' => request('course_id'),
        'price' => request('price'),
        'status' => request('status') ?? 'waiting',
        'method' => request('method'),
        'referrer' => request('referrer'),
    ]);

    return response()->json([
        'status' => 200,
        'message' => 'Order successfully created.'
    ]);
});
