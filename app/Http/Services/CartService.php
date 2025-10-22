<?php

namespace App\Http\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Helpers\ApiResponse;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use Illuminate\Support\ItemNotFoundException;

class CartService
{

    public static function addToCart($request)
    {
        $validated = $request->validated();
        $data = self::getCartWithProduct($request, $validated);
        $encriment = self::encrimentIfExists($data['cart'], $data['product'], $validated['quantity'], 'addToCart');
        if (!$encriment) {
            $data['cart']->products()->attach($data['product']->id, [
                'quantity' => $validated['quantity'] ?? 1
            ]);
        }
        $item = self::getItem($data['cart'], $data['product']->id);
        return ApiResponse::sendResponse(200, "Item added to your cart successfully", new CartResource($item));
    }

    public static function removeFromCart($request, $product)
    {
        $user = $request->user();
        $cart = $user->cart;
        if (! $cart) {
            return ApiResponse::sendResponse(404, "Cart not found");
        } elseif ($cart->products()->detach($product->id)) {
            return ApiResponse::sendResponse(200, "Item deleted successfully");
        } else
            return ApiResponse::sendResponse(404, "Item is not in your cart");
    }

    public static function updateCartItem($request, $productId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        $validated['product_id'] = $productId;
        $data = self::getCartWithProduct($request, $validated);
        $encriment = self::encrimentIfExists($data['cart'], $data['product'], $request->quantity, 'updateCartItem');
        if (!$encriment) {
            return ApiResponse::sendResponse(200, "Item not found", []);
        }
        $item = self::getItem($data['cart'], $data['product']->id);
        return ApiResponse::sendResponse(200, "Item encrimented successfully", new CartResource($item));
    }

    public static function getCartItems($user)
    {
        $cart = Cart::where('user_id', $user->id)->with(['products', 'products.image'])->first();
        if ($cart) {
            $cart->items = $cart ? $cart->products : collect();
            foreach ($cart->items as $item) {
                $item->product_id = $item->pivot->id;
                $item->price = $item->price - ($item->discount ?? 0);
                $item->quantity = $item->pivot->quantity;
                $item->price = $item->price * $item->quantity;
                $item->image = $item->image?->path;
                $cart->subtotal_price = ($cart->subtotal_price ?? 0) + $item->price;
            }
            $items = $cart ? $cart->items : collect();
            $subtotal_price = $cart ? $cart->subtotal_price : 0;
            $shipping_cost = $user->addresses()->latest()->first()->city->shipping_cost;
            $total = $subtotal_price + $shipping_cost;
            return [
                'items'         => $items,
                'subtotal_price'      => $subtotal_price,
                'shipping cost' => $shipping_cost,
                'total'         => $total,
            ];
        } else {
            return null;
        }
    }
    public static function getItem($cart, $producId)
    {
        if (!$cart) {
            return false;
        }
        $item = $cart->products()->where('product_id', $producId)->first();
        if ($item) {
            $item->product_id = $item->pivot->id;
            $item->price = $item->price - ($item->discount ?? 0);
            $item->quantity = $item->pivot->quantity;
            $item->price = $item->price * $item->quantity;
            return $item;
        }
        return null;
    }

    public static function getCartData($request)
    {
        $user = self::getUserFromRequest($request);
        $data = self::getCartItems($user);
        if ($data == null) {
            return ApiResponse::sendResponse(404, 'Cart Not found');
        }
        $cartItems = $data['items'];
        $subTotal = $data['subtotal_price'];
        $shipping_cost = $data['shipping cost'];
        $total = $data['total_price'];
        if ($cartItems->isEmpty()) {
            return ApiResponse::sendResponse(200, 'Cart is empty');
        }
        return ApiResponse::sendResponse(
            200,
            'Cart items retrieved successfully',
            CartResource::collection($cartItems),
            [
                'subtotal_price' => $subTotal,
                'shippingCost' => $shipping_cost,
                'total_price'    => $total,
            ]
        );
    }
    private static function getCartWithProduct($request, $data)
    {
        $user = self::getUserFromRequest($request);
        $cart = $user->cart;

        if (! $cart) {
            return ApiResponse::sendResponse(404, "Cart not found");
        }

        $product = Product::find($data['product_id']);
        if (! $product) {
            return ApiResponse::sendResponse(404, "Product not found");
        }

        return [
            'cart' => $cart,
            'product' => $product
        ];
    }
    private static function getUserFromRequest($request)
    {
        return $request->user();
    }
    private static function encrimentIfExists($cart, $product, $quantity, $cameFrom)
    {
        $pivot = $cart->products()->where('product_id', $product->id)->first();
        if ($pivot) {
            if ($cameFrom == 'addToCart') {
                $newQuantity = $pivot->pivot->quantity + $quantity;
            } else {
                $newQuantity = $quantity;
            }
            $cart->products()->updateExistingPivot($product->id, [
                'quantity' => $newQuantity
            ]);
            return true;
        }
        return false;
    }
}
