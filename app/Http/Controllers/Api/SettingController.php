<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $settings = Setting::find(1);
        if($settings){
            return ApiResponse::sendResponse(200, 'data retrieved successfully', new SettingResource($settings));
        }
        return ApiResponse::sendResponse(200, 'No data found');
    }

}
