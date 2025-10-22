<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $user = User::findOrFail($id);
        $cities = City::all();
        return view('dashboard.pages.locations.addresses.create', compact('user','cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request,string $id)
    {
        $user = User::findOrFail($id); 
        $user->addresses()->create($request->validated());

        return redirect()->route('dashboard.users.index')->with('success' , 'Address add successfully for: '.$user->name);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        return view('dashboard.address.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        $address->update($request->validated());

        return redirect()->route('dashboard.users.addresses', $address->user_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return redirect()->back()->with('success' , 'Address Deleted successfully');
    }
}
