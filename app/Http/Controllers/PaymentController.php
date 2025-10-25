<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\PaymentGatewayInterface;

class PaymentController extends Controller
{
    protected PaymentGatewayInterface $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {

        $this->paymentGateway = $paymentGateway;
    }


    public function paymentProcess(Request $request)
    {
        return $this->paymentGateway->sendPayment($request);
    }

    public function callBack(Request $request): \Illuminate\Http\RedirectResponse
    {
        $response = $this->paymentGateway->callBack($request);
        // dd($request->merchant_order_id);
        if ($response) {

            $orderId = $request->merchant_order_id;
            $order = Order::find($orderId);
            if ($order) {
                $order->update(['payment_status' => 'paid']);
            }
            return redirect()->route('payment.success',$orderId);
        }

        return redirect()->route('payment.failed');
    }


    public function success($orderId)
    {
        if(auth()->user()->is_admin){
        return to_route('dashboard.orders.invoice',$orderId )->with('success', 'order taken successfully');
        }
        return view('payment-success');
    }
    public function failed()
    {

        return view('payment-failed');
    }
}
