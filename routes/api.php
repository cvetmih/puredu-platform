<?php

use App\Models\Bundle;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

// USER
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user/courses', function (Request $request) {
    return $request->user()->courses;
});

Route::middleware('auth:sanctum')->get('/user/has-course/{slug}', function (Request $request, $slug) {
    // todo: return response()->json()
    return [
        'status' => 200,
        'message' => $request->user()->courses()->where('slug', $slug)->exists()
    ];
});

Route::middleware('auth:sanctum')->get('/user/course-progress/{id}', function (Request $request, $id) {
    $progress = Progress::where([
        ['course_id', '=', $id],
        ['user_id', '=', $request->user()->id]
    ])->first();

    return response()->json([
        'status' => 200,
        'percentage' => $progress->percentage,
    ]);
});

Route::middleware('auth:sanctum')->get('/user/last-lesson/{id}', function (Request $request, $id) {
    $last_lesson = DB::table('lesson_user')->where([
        ['user_id', '=', $request->user()->id],
        ['course_id', '=', (int) $id]
    ]);

    if ($last_lesson->exists()) {
        $last_lesson = $last_lesson->orderBy('lesson_id', 'DESC')->first();
        $last_lesson = Lesson::where('id', $last_lesson->lesson_id)->first();
    } else {
        $last_lesson = Course::where('id', $id)->first()->lessons->first();
    }

    return response()->json([
        'status' => 200,
        'last_lesson' => $last_lesson,
    ]);
});

Route::middleware('auth:sanctum')->get('/user/orders', function (Request $request) {
    return $request->user()->orders()->orderBy('created_at', 'DESC')->get();
});

// NEW USER CREATED
Route::post('/user/new', function (Request $request) {
    $user_id = $request->get('user_id');

    $progress_exists = Progress::where('user_id', $user_id)->exists();

    if (!$progress_exists) {
        $courses = Course::all();

        foreach ($courses as $course) {
            Progress::create([
                'user_id' => $user_id,
                'course_id' => $course->id,
                'percentage' => 0
            ]);
        }
    }

    return response()->json([
        'status' => 200,
        'message' => 'User prepared successfully.'
    ]);
});

// UPDATING USER
Route::middleware('auth:sanctum')->post('/user/update', function (Request $request) {
    $user = $request->user();
    $user->update($request->only('name', 'email', 'password'));

    return response()->json([
        'status' => 200,
        'message' => 'User successfuly updated.'
    ]);
});

// COURSES
Route::get('/courses', function () {
    return Course::whereIsActive(true)->get();
});

Route::get('/courses/{course}', function ($course) {
    return Course::where('slug', $course)->firstOrFail();
});

// BUNDLES
Route::get('/bundles', function () {
    return Bundle::whereIsActive(true)->get();
});

Route::get('/bundles/{bundle}', function ($bundle) {
    return Bundle::where('slug', $bundle)->firstOrFail();
});

// CHAPTERS
Route::get('/courses/{course}/chapters', function ($course) {
    $course = Course::where('slug', $course)->with('lessons')->firstOrFail();

    // todo: get real final number
    $users_final_number = 0;

    $chapters = new \Illuminate\Support\Collection();
    foreach ($course->chapters as $chapter) {
        $c = $chapter;
        $lessons = new \Illuminate\Support\Collection();
        foreach ($chapter->lessons as $lesson) {
            $l = $lesson;
            $l->finished = false;
//            $l->finished = rand(0, 100) < 50;
            $lessons->add($l);
        }

        $c->lessons = $lessons;
        $chapters->add($c);
    }

    return $chapters;
});

Route::get('/courses/{course}/lessons', function (Course $course) {
    return $course->lessons;
});

// LESSONS
Route::middleware('auth:sanctum')->get('/courses/{course}/{chapter}/{lesson}', function (Request $request, $course, $chapter, $lesson) {
    // todo: validate if user can see course

    $course = Course::where('slug', $course)->firstOrFail();

    $lesson = Lesson::where([
        ['course_id', '=', $course->id],
        ['chapter_id', '=', $chapter],
        ['slug', '=', $lesson]
    ])->with('chapter')->firstOrFail();

    update_progress($request->user(), $lesson);

    return $lesson;
});


// ORDERS
Route::post('/orders/create', function () {
    try {
        $order = Order::create([
            'user_id' => request('user_id'),
            'course_id' => request('course_id'),
            'bundle_id' => request('bundle_id'),
            'price' => request('price'),
            'type' => request('type'),
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


// NEWSLETTER
Route::post('/newsletter', function () {
    \App\Models\Lead::create([
        'email' => request('email'),
        'ip' => 0
    ]);

    return response()->json([
        'status' => 200,
        'message' => 'Lead successfuly created.'
    ]);
});

// SURVEY
Route::middleware('auth:sanctum')->post('/surveys/create', function (Request $request) {
    $data = [
        'user_id' => $request->user()->id,
        'course_id' => $request->get('course_id'),
        'lesson_id' => $request->get('lesson_id'),
        'data' => json_encode($request->except('course_id', 'lesson_id'))
    ];

    \App\Models\Survey::create($data);

    return response()->json([
        'status' => 200,
        'message' => 'Survey successfully saved.'
    ]);
});
