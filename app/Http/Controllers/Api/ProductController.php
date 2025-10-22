<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductFilterRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductFilterRequest $request)
    {
        $products = app(Pipeline::class)
            ->send(Product::query())
            ->through([
                \App\Filters\Products\SearchFilter::class,
                \App\Filters\Products\CategoryFilter::class,
                \App\Filters\Products\TagFilter::class,
                \App\Filters\Products\PriceFilter::class,
            ])
            ->thenReturn()
            ->with(['image', 'category', 'tags'])
            ->paginate($request->input('per_page', 5));
        if ($products->isNotEmpty()) {
            $data = $this->formatProducts($products);
            return ApiResponse::sendResponse(200, "data retrieved successfully", $data);
        }
        return ApiResponse::sendResponse(200, 'No macthing data', []);
    }

    public function show($id)
    {
        $product = Product::with(['image', 'category'])->find($id);
        if ($product) {
            return ApiResponse::sendResponse(200, 'data retrieved successfully', new ProductResource($product));
        }
        return ApiResponse::sendResponse(200, 'No data found');
    }

    public function latest()
    {
        $products = Product::with(['image', 'category'])->latest()->take(5)->get();
        if ($products->isNotEmpty()) {
            return ApiResponse::sendResponse(200, 'data retrieved successfully', ProductResource::collection($products));
        }
        return ApiResponse::sendResponse(200, 'No data found', []);
    }


    



    private function formatProducts($products)
    {
        if ($products->total() > $products->perPage()) {
            $data = [
                'records' => ProductResource::collection($products),
                'paginationLinks' => [
                    'currentPage' => $products->currentPage(),
                    'lastPage'    => $products->lastPage(),
                    'perPage'     => $products->perPage(),
                    'total'        => $products->total(),
                    'links'        => [
                        'first'        => $products->url(1),
                        'last'         => $products->url($products->lastPage()),
                        'next'         => $products->nextPageUrl(),
                        'previous'     => $products->previousPageUrl(),
                    ]
                ]
            ];
        } else {
            $data = ProductResource::collection($products);
        }
        return $data;
    }
}
