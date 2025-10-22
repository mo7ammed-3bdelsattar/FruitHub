<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderStatusRecource;

class OrderTrakingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(Request $request, $id)
    {
        $order = Order::with(['driver','orderTrackings'])->findOrFail($id);
        if ($order->user_id == $request->user()->id) {
            $order_statuses = $order->orderTrackings()->get();
            return ApiResponse::sendResponse(200, "Data retrieved successfully",
             OrderStatusRecource::collection($order_statuses),
            [
                "driverName" => $order->driver->name,
                "driverPhone" => $order->driver->phone,
                "userPhone"   => $order->user->phone
            ]
            );
        }
        return ApiResponse::sendResponse(403 , "You're not allowed to take this action",null);
    }
}
