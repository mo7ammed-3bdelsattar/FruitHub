<?php


namespace App\Http\Services;

use PDOException;
use Carbon\Carbon;
use App\Models\Order;
use App\Helpers\ApiResponse;
use App\Http\Services\CartService;
use Illuminate\Support\Facades\DB;

class OrderService
{


    public static function apiStore($request)
    {
        $user = $request->user();
        $cartData = CartService::getCartItems($user);
        $cartData['user_id'] = $user->id;
        $cartData['address_id'] = $request->input('address_id');
        $isCreated = self::create($cartData);
        if ($isCreated) {
            $user->cart->products()->detach();
            return true;
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
                'status'  => 'taken',
                'created_at' => now()
            ]);
            $order->order_number='ORD'.Carbon::now()->year.''.$order->id;
            $order->save();
            $order->orderTrackings()->create(['status' => 'taken']);

            foreach ($data['items'] as $item) {
                $order->products()->attach($item['product_id'], [
                    'quantity' => $item['quantity']
                ]);
            }
            DB::commit();
            return $order;
        } catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
}
