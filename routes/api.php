<?php

use App\Models\Bundle;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::middleware('auth:sanctum')->get('/user/courses', function (Request $request) {
    return $request->user()->courses;
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

Route::post('/orders/create', function () {
    try {
        $order = Order::create([
            'user_id' => request('user_id'),
            'course_id' => request('course_id'),
            'bundle_id' => request('bundle_id'),
            'price' => request('price'),
            'status' => 'waiting',
            'method' => request('method'),
            'referrer' => request('referrer'),
            'token' => Str::random()
        ]);

        return response()->json([
            'status' => 200,
            'id' => $order->id,
            'token' => $order->token,
            'message' => 'Order successfully created.'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 500,
            'message' => $e->getMessage()
        ]);
    }
});

Route::post('/orders/confirm', function () {
    $order = Order::where([
        ['token', '=', request('token')],
        ['status', '=', 'waiting']
    ])->first();

    if ($order) {
        $order->status = 'success';
        $order->save();

        if ($order->type === 'course') {
            $order->user->courses()->attach($order->course_id);
        } else if ($order->type === 'bundle') {
            $bundle = Bundle::where('id', $order->bundle_id)->first();
            $order->user->courses()->attach($bundle->courses->pluck('id'));
        }

        return response()->json([
            'status' => 200,
            'message' => 'Payment was successful.'
        ]);
    }

    return response()->json([
        'status' => 404,
        'message' => 'Order was not found.'
    ]);
});
