<?php

namespace App\Http\Controllers\Api;

use App\Models\Driver;
use Spatie\FlareClient\Api;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $drivers = Driver::all();
        if ($drivers->isNotEmpty()) {
            return ApiResponse::sendResponse(200, 'data retrieved successfully', DriverResource::collection($drivers));
        }
        return ApiResponse::sendResponse(200, 'Non driver found');
    }
}
