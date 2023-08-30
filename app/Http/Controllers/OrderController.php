<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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
        $orders = Order::with('user', 'course')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('orders.index')->with(compact('orders'));
    }

    public function create()
    {
        return view('orders.create')->with([
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

        $order = Order::create([
            'user_id' => $request->input('user_id'),
            'course_id' => $request->input('course_id'),
            'price' => $request->input('price'),
            'status' => $request->input('status'),
            'method' => $request->input('method'),
            'referrer' => $request->input('referrer'),
        ]);

        notify()->success("Order #$order->id was created.", 'Success');

        return redirect()->to(route('orders.show', $order));
    }

    public function show(Order $order)
    {
//        $order = $order->load('user', 'course');
        return view('orders.show')->with(compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit')->with([
            'order' => $order,
            'inputs' => $this->inputs
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id' => 'required',
            'course_id' => 'required',
            'price' => 'required',
            'status' => 'required',
            'method' => 'required',
            'referrer' => 'required',
        ]);

        $order->update([
            'user_id' => $request->input('user_id'),
            'course_id' => $request->input('course_id'),
            'price' => $request->input('price'),
            'status' => $request->input('status'),
            'method' => $request->input('method'),
            'referrer' => $request->input('referrer'),
        ]);

        notify()->success("Order #$order->id was updated.", 'Success');

        return redirect()->to(route('orders.show', $order));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        notify()->success("Order was deleted.", 'Success');
        return redirect()->back();
    }
}
