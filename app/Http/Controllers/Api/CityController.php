<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $cities = City::all();
        if($cities){
            return ApiResponse::sendResponse(200, 'data retrieved successfully', CityResource::collection($cities));
        }
        return ApiResponse::sendResponse(200, 'No data found');
    }

}
