<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wishlist = $request->user()->wishlist;
        if (!$wishlist) {
            return ApiResponse::sendResponse(404, 'This user does not have a wishlist');
        }
        $products = $wishlist->products()->with(['image', 'category'])->latest()->get();
        if ($products->isEmpty()) {
            return ApiResponse::sendResponse(200, 'No products in wishlist', []);
        }
        return ApiResponse::sendResponse(200, 'Products retrieved successfully', ProductResource::collection($products));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $productId)
    {
        $product = Product::find($productId);
        return $this->addOrRemoveItem($request, $product, 'add');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $productId)
    {
        $product = Product::find($productId);
        return $this->addOrRemoveItem($request, $product, 'remove');
    }

    private function addOrRemoveItem(Request $request, $product, $action)
    {
        $wishlist = $request->user()->wishlist;
        if (!$wishlist) {
            return ApiResponse::sendResponse(404, 'This user does not have a wishlist');
        } elseif ($product === null) {
            return ApiResponse::sendResponse(404, 'Product not found');
        }
        if ($action === 'add') {
            if ($wishlist->products()->where('product_id', $product->id)->exists()) {
                return ApiResponse::sendResponse(409, 'Product already in wishlist');
            }
            $wishlist->products()->syncWithoutDetaching($product->id);
            return ApiResponse::sendResponse(200, "The item: $product->title added to wishlist successfully");
        } elseif ($action === 'remove') {
            if (!$wishlist->products()->where('product_id', $product->id)->exists()) {
                return ApiResponse::sendResponse(404, 'Product not found in wishlist');
            }
            $wishlist->products()->detach($product->id);
            return ApiResponse::sendResponse(200, "The item: $product->title removed from wishlist successfully");
        }
    }
}
