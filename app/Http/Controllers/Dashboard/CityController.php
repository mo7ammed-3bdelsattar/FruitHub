<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::all();
        return view('dashboard.pages.locations.cities.index', compact('cities'));
    }

    public function edit(string $id)
    {
        abort_if(!auth()->user()->can('edit cities'), 403);
        $city = City::findOrFail($id);
        if ($city) {
            return ApiResponse::sendResponse(200, 'data retrieved successfully', new CityResource($city));
        }
        return ApiResponse::sendResponse(200, 'No data found');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request)
    {
        abort_if(!auth()->user()->can('create cities'), 403);
        City::create($request->validated());
        return redirect()->back()->with('success', 'City created successfuly');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, City $city)
    {
        abort_if(!auth()->user()->can('edit cities'), 403);
        $city->updated_at = now();
        $city->update($request->validated());
        return redirect()->back()->with('success', "City: ($city->name) updated successfully ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        abort_if(!auth()->user()->can('delete cities'), 403);
        $city->delete();
        return redirect()->back()->with('success', "City: ($city->name) deleted successfully ");
    }
}
