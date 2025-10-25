<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Services\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->get();
        if (count($orders) > 0) {
            return ApiResponse::sendResponse(200, 'Orders retreived successfully', OrderResource::collection($orders));
        }
        return ApiResponse::sendResponse(200, 'Non orders found');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $address_id = $request->validate(['address_id' => 'required|exists:addresses,id']);

        if ($request->user()->addresses()->find($address_id)->isEmpty()) {
            return ApiResponse::sendResponse(404, "This address is not belong to you or may not exist", []);
        }
        $data = OrderService::apiStore($request);
        if (!$data) {
            return ApiResponse::sendResponse(200, "'Payment failed, please try again.'", null);
        }
        return ApiResponse::sendResponse(201, "Order taken successfully", $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id',  $request->user()->id)->first();
        if ($order) {
            return ApiResponse::sendResponse(200, "Data retrieved successfully", new OrderResource($order));
        }
        return ApiResponse::sendResponse(404, "Order not found", null);
    }

    /**
     * Update the specified resource in storage.
     */
    public function cancel(Request $request, string $id)
    {
        $request->validate([
            'status' => 'nullable|in:cancelled',
        ]);
        if (OrderService::cancel($request, $id)) {
            return ApiResponse::sendResponse(200, "Order cancelled successfully", []);
        }
        return ApiResponse::sendResponse(403 , "You're not allowed to take this action",null);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
