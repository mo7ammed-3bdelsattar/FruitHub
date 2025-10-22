<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereNot('is_admin','=',true)->get();
        return ApiResponse::sendResponse(200,'',$users);
    }
    public function show(Request $request){
        $user = $request->user();
        
        return ApiResponse::sendResponse(200,'',new UserResource($user));
    }

}
