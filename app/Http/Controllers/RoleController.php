<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(!auth()->user()->can('manage permissions'), 403);
        $roles = Role::all();
        return view('dashboard.pages.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('manage permissions'), 403);
        $permissions = Permission::all();
        return view('dashboard.pages.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('manage permissions'), 403);
        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }
        return redirect()->route('dashboard.roles.index')->with('Role created successfully');
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
    public function edit(Role $role)
    {
        abort_if(!auth()->user()->can('manage permissions'), 403);
        $permissions = Permission::orderByDesc('name')->get();
        return view('dashboard.pages.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        abort_if(!auth()->user()->can('manage permissions'), 403);
        $role->name = $request->name;
        $role->save();
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }
        return redirect()->route('dashboard.roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        abort_if(!auth()->user()->can('manage permissions'), 403);
        if ($role->name == 'admin') {
            return redirect()->back()->with('error', 'You cannot delete the admin role.');
        }
        $role->delete();
        return redirect()->route('dashboard.roles.index')->with('success', 'Role deleted successfully.');
    }
}
