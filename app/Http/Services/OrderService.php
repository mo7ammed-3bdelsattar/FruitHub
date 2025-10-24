<?php


namespace App\Http\Services;

use PDOException;
use Carbon\Carbon;
use App\Models\Order;
use App\Mail\OrderMail;
use App\Helpers\ApiResponse;
use App\Http\Services\CartService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderService
{


    public static function apiStore($request)
    {
        $user = $request->user();
        $cartData = CartService::getCartItems($user);
        // dd($cartData);
        $cartData['user_id'] = $user->id;
        $cartData['address_id'] = $request->input('address_id');
        $cartData['payment_method'] = $request->input('payment_method');
        $order = self::create($cartData);
        if (!empty($order)) {
            $user->cart->products()->detach();
            $data = self::getPaymentData($order);
            $paymentService = app(\App\Http\Services\PaymobPaymentService::class);
            $paymentResponse = $paymentService->sendPayment($data);
            if ($paymentResponse['success']) {
                return $paymentResponse['url'];
            } else {
                return false;
            }
        }
        return false;
    }


    public static function cancel($request, $id)
    {
        $order = Order::findOrFail($id);
        if (($order->user_id == $request->user()->id) && ($order->status == 'taken' || $order->status == 'preparing')) {
            $order->status = "cancelled";
            $order->save();
            $order->orderTrackings()->create(['status' => 'cancelled']);
            return true;
        }
        return false;
    }
    public static function create($data)
    {
        try {

            DB::beginTransaction();
            if (count($data['items']) < 1) {
                return false;
            }
            $order = Order::create([
                'user_id' => $data['user_id'],
                'address_id' => $data['address_id'],
                'total_price' => $data['total_price'],
                'subtotal_price' => $data['subtotal_price'],
                'payment_method' => $data['payment_method'],
                'status'  => 'taken',
                'created_at' => now()
            ]);

            $order->order_number = 'ORD' . Carbon::now()->year . '' . $order->id;
            $order->save();
            $order->orderTrackings()->create(['status' => 'taken']);
            foreach ($data['items'] as $item) {
                $order->products()->attach($item['product_id'], [
                    'quantity' => $item['quantity']
                ]);
            }
            // Mail::to($order->user->email)->send(new OrderMail($order, 'Your Order has been taken!'));
            DB::commit();
            return $order;
        } catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    public static function getPaymentData($order)
    {
        $paymentData = [
            'amount_cents' => $order->total_price * 100,
            'currency' => "EGP",
            'shipping_data' =>
            [
                'first_name' => $order->user->name,
                'last_name' => $order->user->name,
                'phone_number' => $order->user->phone,
                'email' => $order->user->email
            ],
            'merchant_order_id' => $order->id,
        ];
        return $paymentData;
    }
    public static function orderPayment($order)
    {
        $data = self::getPaymentData($order);
        $paymentService = app(\App\Http\Services\PaymobPaymentService::class);
        $paymentResponse = $paymentService->sendPayment($data);
        if ($paymentResponse['success']) {
            return redirect($paymentResponse['url']);
        } else {
            return redirect()->back()->with('error', 'Payment failed, please try again.');
        }
    }
}
