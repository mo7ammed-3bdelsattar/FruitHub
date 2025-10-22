<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Address;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $addresses = $user->addresses;
        if ($addresses){
            return ApiResponse::sendResponse(200, 'data retrieved successfully', AddressResource::collection($addresses));
        }
        return ApiResponse::sendResponse(200, 'No data found');

    }
    public function show(Address $address){
        if($address){
            return ApiResponse::sendResponse(200, 'data retrieved successfully',new  AddressResource($address));
        }
        return ApiResponse::sendResponse(200, 'No data found');
    }
    public function store(AddressRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();
        $data['user_id'] = $user->id;
        $address = $user->addresses()->create($data);
        if(!$address){
            return ApiResponse::sendResponse(400, 'Failed to create address');
        }
        return ApiResponse::sendResponse(201, 'Address created successfully', new AddressResource($address));
    }
    public function update(AddressRequest $request, Address $address)
    {
        if(!$address) {
            return ApiResponse::sendResponse(404, 'Address not found');
        }
        $updated = $address->update($request->validated());

        if(!$updated) {
            return ApiResponse::sendResponse(400, 'Failed to update address');
        }
        return ApiResponse::sendResponse(200, 'Address updated successfully', new AddressResource($address));
    }
    public function destroy(Address $address)
    {
        if(!$address) {
            return ApiResponse::sendResponse(404, 'Address not found');
        }
        try {
            $address->delete();
        } catch (\Exception $e) {
            return ApiResponse::sendResponse(400, $e->getMessage());
        }
        return ApiResponse::sendResponse(200, 'Address deleted successfully');
    }
    
    public function getUserAddresses(string $id){
     
        $user = User::find($id);
        if($user) $addresses = $user->addresses;
        if ($addresses){
            return ApiResponse::sendResponse(200, 'data retrieved successfully', AddressResource::collection($addresses));
        }
        return ApiResponse::sendResponse(200, 'No data found');

    }
    
}
    