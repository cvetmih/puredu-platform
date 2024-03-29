<?php

use App\Http\Controllers\BundleController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Route;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    $total_revenue = Order::where('status', '=', 'success')->sum('price');
    $this_month_revenue = Order::where('status', '=', 'success')->where('created_at', '>', now()->subMonth())->sum('price');
    $total_users = User::all()->count();
    $users_this_month = User::where('created_at', '>', now()->subMonth())->count();
    $orders_this_month = Order::where('created_at', '>', now()->subMonth())->where('status', '=', 'success')->count();
    $latest_orders = Order::with(['user', 'course'])->where('status', '=', 'success')->latest()->limit(5)->get();

    return view('dashboard')->with([
        'total_revenue' => '$' . $total_revenue,
        'this_month_revenue' => '$' . $this_month_revenue,
        'users_this_month' => $users_this_month,
        'total_users' => $total_users,
        'orders_this_month' => $orders_this_month,
        'latest_orders' => $latest_orders
    ]);
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'users', 'middleware' => ['auth']], function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}/destroy', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/{user}/enroll', [UserController::class, 'enroll'])->name('users.enroll');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
});

Route::group(['prefix' => 'courses', 'middleware' => ['auth']], function () {
    Route::get('/', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/store', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/{course}/update', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/{course}/destroy', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::get('/{course}', [CourseController::class, 'show'])->name('courses.show');
});

Route::group(['prefix' => 'bundles', 'middleware' => ['auth']], function () {
    Route::get('/', [BundleController::class, 'index'])->name('bundles.index');
    Route::get('/create', [BundleController::class, 'create'])->name('bundles.create');
    Route::post('/store', [BundleController::class, 'store'])->name('bundles.store');
    Route::get('/{bundle}/edit', [BundleController::class, 'edit'])->name('bundles.edit');
    Route::put('/{bundle}/update', [BundleController::class, 'update'])->name('bundles.update');
    Route::delete('/{bundle}/destroy', [BundleController::class, 'destroy'])->name('bundles.destroy');
    Route::get('/{bundle}', [BundleController::class, 'show'])->name('bundles.show');
});

Route::group(['prefix' => 'lessons', 'middleware' => ['auth']], function () {
    Route::get('/', [LessonController::class, 'index'])->name('lessons.index');
//    Route::get('/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::get('/create/{type}', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/store', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/{lesson}/update', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/{lesson}/destroy', [LessonController::class, 'destroy'])->name('lessons.destroy');
    Route::get('/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
});

Route::group(['prefix' => 'videos', 'middleware' => ['auth']], function () {
    Route::get('/', [VideoController::class, 'index'])->name('videos.index');
    Route::get('/create', [VideoController::class, 'create'])->name('videos.create');
    Route::post('/store', [VideoController::class, 'store'])->name('videos.store');
    Route::get('/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
    Route::put('/{video}/update', [VideoController::class, 'update'])->name('videos.update');
    Route::delete('/{video}/destroy', [VideoController::class, 'destroy'])->name('videos.destroy');
    Route::get('/{video}', [VideoController::class, 'show'])->name('videos.show');
});

Route::group(['prefix' => 'orders', 'middleware' => ['auth']], function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/{order}/update', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/{order}/destroy', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
});

Route::group(['prefix' => 'coupons', 'middleware' => ['auth']], function () {
    Route::get('/', [CouponController::class, 'index'])->name('coupons.index');
    Route::get('/create', [CouponController::class, 'create'])->name('coupons.create');
    Route::post('/store', [CouponController::class, 'store'])->name('coupons.store');
    Route::get('/{video}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
    Route::put('/{video}/update', [CouponController::class, 'update'])->name('coupons.update');
    Route::delete('/{video}/destroy', [CouponController::class, 'destroy'])->name('coupons.destroy');
    Route::get('/{video}', [CouponController::class, 'show'])->name('coupons.show');
});

//Route::get('test', function () {
//    $models = [
//        'Activity',
//        'Chapter',
//        'Course',
//        'Image',
//        'Lesson',
//        'Order',
//        'User',
//        'Video',
//    ];
//
//    $excluded_methods = [
//        'factory',
//        'newFactory',
//
//        // User model
//        'tokens',
//        'tokenCan',
//        'createToken',
//        'currentAccessToken',
//        'withAccessToken',
//        'notifications',
//        'readNotifications',
//        'unreadNotifications',
//        'notify',
//        'notifyNow',
//        'routeNotificationFor'
//    ];
//
//    foreach ($models as $model) {
//        echo "<h2>$model</h2>";
//
//        foreach ((new ReflectionClass("\App\Models\\$model"))->getMethods() as $method) {
//            $is_non_vendor = strpos($method->class, 'App\Models') !== false;
//            $is_not_excluded = !in_array($method->name, $excluded_methods);
//
//            if ($is_non_vendor && $is_not_excluded) {
//                echo '$' . strtolower($model) . '->' . $method->name . '();<br>';
//            }
//        }
//    }
//});


require __DIR__ . '/auth.php';
