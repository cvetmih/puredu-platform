<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private $inputs;

    public function __construct()
    {
        $users = User::all()->pluck('name', 'id');
        $courses = Course::all()->pluck('title', 'id');

        $this->inputs = [
            'user_id' => [
                'label' => 'User',
                'type' => 'select',
                'required' => true,
                'options' => $users,
                'hidden' => false
            ],
            'course_id' => [
                'label' => 'Course ID',
                'type' => 'select',
                'required' => true,
                'options' => $courses,
                'hidden' => false
            ],
            'price' => [
                'label' => 'Price',
                'type' => 'text',
                'required' => true,
                'hidden' => false
            ],
            'status' => [
                'label' => 'Status',
                'type' => 'select',
                'required' => true,
                'options' => [
                    'paid' => 'Paid',
                    'waiting' => 'Waiting',
                    'error' => 'Error',
                ],
                'hidden' => false
            ],
            'method' => [
                'label' => 'Method',
                'type' => 'select',
                'required' => true,
                'options' => [
                    'paypal' => 'PayPal',
                    'card' => 'Card payment',
                    'bank' => 'Bank transfer',
                ],
                'hidden' => false
            ],
            'referrer' => [
                'label' => 'Referrer',
                'type' => 'text',
                'required' => true,
                'hidden' => false
            ],
        ];
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $coupons = Coupon::with('user', 'course')->latest()->get();
        return view('coupons.index')->with(compact('coupons'));
    }

    public function create()
    {
        return view('coupons.create')->with([
            'inputs' => $this->inputs
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'course_id' => 'required',
            'price' => 'required',
            'status' => 'required',
            'method' => 'required',
            'referrer' => 'required',
        ]);

        $coupon = Coupon::create([
            'user_id' => $request->input('user_id'),
            'course_id' => $request->input('course_id'),
            'price' => $request->input('price'),
            'status' => $request->input('status'),
            'method' => $request->input('method'),
            'referrer' => $request->input('referrer'),
        ]);

        notify()->success("Coupon #$coupon->id was created.", 'Success');

        return redirect()->to(route('coupons.show', $coupon));
    }

    public function show(Coupon $coupon)
    {
//        $coupon = $coupon->load('user', 'course');
        return view('coupons.show')->with(compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('coupons.edit')->with([
            'coupon' => $coupon,
            'inputs' => $this->inputs
        ]);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'user_id' => 'required',
            'course_id' => 'required',
            'price' => 'required',
            'status' => 'required',
            'method' => 'required',
            'referrer' => 'required',
        ]);

        $coupon->update([
            'user_id' => $request->input('user_id'),
            'course_id' => $request->input('course_id'),
            'price' => $request->input('price'),
            'status' => $request->input('status'),
            'method' => $request->input('method'),
            'referrer' => $request->input('referrer'),
        ]);

        notify()->success("Coupon #$coupon->id was updated.", 'Success');

        return redirect()->to(route('coupons.show', $coupon));
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        notify()->success("Coupon was deleted.", 'Success');
        return redirect()->back();
    }
}
