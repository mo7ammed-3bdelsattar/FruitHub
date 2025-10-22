<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Http\Controllers\Controller;
use App\Http\Requests\DriverRequest;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('view drivers'), 403);
        $request->validate([
            'search' => 'nullable|string|max:255'
        ]);
        $drivers = app(Pipeline::class)
            ->send(Driver::query())
            ->through(
                [
                    \App\Filters\Drivers\SearchFilter::class
                ]
            )
            ->thenReturn()
            ->latest()
            ->paginate(5);
        return view('dashboard.pages.drivers.index', compact('drivers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DriverRequest $request)
    {
        abort_if(!auth()->user()->can('create drivers'), 403);
        $driver = Driver::create($request->validated());
        return redirect()->back()->with('success','Driver created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        abort_if(!auth()->user()->can('edit drivers'), 403);
        return response()->json($driver);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DriverRequest $request, Driver $driver)
    {
        abort_if(!auth()->user()->can('edit drivers'), 403);
        $driver->update($request->validated());
        return redirect()->back()->with('success','Driver updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        abort_if(!auth()->user()->can('delete drivers'), 403);
        $driver->delete();
        return redirect()->back()->with('success','Driver deleted successfully');
        
    }
}
