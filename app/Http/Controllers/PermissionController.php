<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('manage permissions'),403);
        $request->validate([
            'search' => 'nullable|string|max:255'
        ]);
        $permissions = app(Pipeline::class)
            ->send(Permission::query())
            ->through(
                [
                    \App\Filters\Permissions\SearchFilter::class
                ]
            )
            ->thenReturn()
            ->latest()
            ->paginate(5);
        return view('dashboard.pages.permissons.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        abort_if(!auth()->user()->can('manage permissions'),403);
        Permission::findOrCreate($request->name);
        return redirect()->back()->with('success', "Permission: $request->name created successfully.");
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
    public function edit(Permission $permission)
    {
        abort_if(!auth()->user()->can('manage permissions'),403);
        return view('dashboard.pages.permissons.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        abort_if(!auth()->user()->can('manage permissions'),403);
        $permission->update($request->validated());
        return redirect()->route('dashboard.permissions.index')->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        abort_if(!auth()->user()->can('manage permissions'),403);
        $permission->delete();
        return redirect()->back()->with('success', 'Permission deleted successfully.');
    }
}
