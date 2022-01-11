<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
        $this->inputs = [
            'user_id' => [
                'label' => 'User ID',
                'type' => 'text',
                'required' => true
            ],
            'course_id' => [
                'label' => 'Course ID',
                'type' => 'text',
                'required' => true
            ],
            'price' => [
                'label' => 'Price',
                'type' => 'text',
                'required' => true
            ],
            'status' => [
                'label' => 'Status',
                'type' => 'text',
                'required' => true
            ],
            'method' => [
                'label' => 'Method',
                'type' => 'text',
                'required' => true
            ],
            'referrer' => [
                'label' => 'Referrer',
                'type' => 'text',
                'required' => true
            ],
        ];
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $orders = Order::with('user', 'course')->get();
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

        return redirect()->to(route('orders.show', $order))->with([
            'message' => 'New order created.'
        ]);
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

        return redirect()->to(route('orders.show', $order))->with([
            'message' => 'Order was updated.'
        ]);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->back()->with([
            'message' => 'Order was deleted.'
        ]);
    }
}
