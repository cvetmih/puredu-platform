<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $total_revenue = Order::where('status', '=', 'paid')->sum('price');
    $users_this_month = User::where('created_at', '>', now()->subMonth())->count();
    $orders_this_month = Order::where('created_at', '>', now()->subMonth())->count();
    $latest_orders = Order::with(['user', 'course'])->latest()->limit(5)->get();

    return view('dashboard')->with([
        'total_revenue' => '$' . $total_revenue,
        'users_this_month' => $users_this_month,
        'orders_this_month' => $orders_this_month,
        'latest_orders' => $latest_orders
    ]);
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}/destroy', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/{user}/enroll', [UserController::class, 'enroll'])->name('users.enroll');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
});

Route::group(['prefix' => 'courses', 'middleware' => 'auth'], function () {
    Route::get('/', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/store', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/{course}/update', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/{course}/destroy', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::get('/{course}', [CourseController::class, 'show'])->name('courses.show');
});

Route::group(['prefix' => 'lessons', 'middleware' => 'auth'], function () {
    Route::get('/', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/store', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/{lesson}/update', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/{lesson}/destroy', [LessonController::class, 'destroy'])->name('lessons.destroy');
    Route::get('/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
});

Route::group(['prefix' => 'videos', 'middleware' => 'auth'], function () {
    Route::get('/', [VideoController::class, 'index'])->name('videos.index');
//    Route::get('/create', [VideoController::class, 'create'])->name('videos.create');
//    Route::post('/store', [VideoController::class, 'store'])->name('videos.store');
    Route::get('/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
    Route::put('/{video}/update', [VideoController::class, 'update'])->name('videos.update');
    Route::delete('/{video}/destroy', [VideoController::class, 'destroy'])->name('videos.destroy');
    Route::get('/{video}', [VideoController::class, 'show'])->name('videos.show');
});

Route::group(['prefix' => 'payments', 'middleware' => 'auth'], function () {
    Route::get('/', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/store', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/{payment}/update', [PaymentController::class, 'update'])->name('payments.update');
    Route::delete('/{payment}/destroy', [PaymentController::class, 'destroy'])->name('payments.destroy');
    Route::get('/{payment}', [PaymentController::class, 'show'])->name('payments.show');
});

Route::group(['prefix' => 'orders', 'middleware' => 'auth'], function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/{order}/update', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/{order}/destroy', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
});


require __DIR__ . '/auth.php';
