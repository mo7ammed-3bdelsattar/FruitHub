<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Http\Services\CartService;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;


class CartController extends Controller
{
    public function index(Request $request)
    {
       return CartService::getCartData($request);
    }

    public function store(CartRequest $request)
    {
        return CartService::addToCart($request);
    }
    public function update(Request $request, string $producId)
    {
        return CartService::updateCartItem($request ,$producId);
    }

    public function show(Request $request,string $productId){
        $user = $request->user();
        $cart = $user->cart;
        $item = CartService::getItem($cart,$productId);
        return ApiResponse::sendResponse(200, "Item retrieved successfully", new CartResource($item));
    }

    public function destroy(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        if(!$product){
            return ApiResponse::sendResponse(404, "Product not found" );
        }
        return CartService::removeFromCart($request , $product);
    }
}
