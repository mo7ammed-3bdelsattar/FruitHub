<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $categories = Category::all();
        if ($categories->isNotEmpty()) {
            return ApiResponse::sendResponse(200, "Data retrieved successfully", CategoryResource::collection($categories));
        }
        return ApiResponse::sendResponse(200, "No categories exist!", []);
    }
}
