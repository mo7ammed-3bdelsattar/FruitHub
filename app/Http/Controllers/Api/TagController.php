<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $tags = Tag::all();
        if ($tags->isEmpty()) {
            return ApiResponse::sendResponse(200, "Non tags exists", []);
        }
        return ApiResponse::sendResponse(200, "Tags retrieved successfully", TagResource::collection($tags));
    }
}
