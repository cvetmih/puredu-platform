<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
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
            'order_id' => [
                'label' => 'Order ID',
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
        ];
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $payments = Payment::all();
        return view('payments.index')->with(compact('payments'));
    }

    public function create()
    {
        return view('payments.create')->with([
            'inputs' => $this->inputs
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
            'method' => 'required',
        ]);

        $payment = Payment::create([
            'order_id' => $request->input('order_id'),
            'user_id' => $request->input('user_id'),
            'status' => $request->input('status'),
            'method' => $request->input('method'),
        ]);

        return redirect()->to(route('payments.show', $payment))->with([
            'message' => 'New payment created.'
        ]);
    }

    public function show(Payment $payment)
    {
        return view('payments.show')->with(compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('payments.edit')->with([
            'payment' => $payment,
            'inputs' => $this->inputs
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'order_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
            'method' => 'required',
        ]);

        $payment->update([
            'order_id' => $request->input('order_id'),
            'user_id' => $request->input('user_id'),
            'status' => $request->input('status'),
            'method' => $request->input('method'),
        ]);

        return redirect()->to(route('payments.show', $payment))->with([
            'message' => 'Payment was updated.'
        ]);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->back()->with([
            'message' => 'Payment was deleted.'
        ]);
    }
}
