<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Http\Requests\UserRequest;
use App\Http\Services\UserService;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('view users'), 403);
        $request->validate([
           'search'=> 'nullable|string|max:255'
        ]);
        $users = app(Pipeline::class)
        ->send(User::query())
        ->through(
            [
                \App\Filters\Users\SearchFilter::class
            ]
        )
        ->thenReturn()
        ->with(['image','roles'])
        ->latest()
        ->paginate(session('pagination'));  
        $roles = Role::all();
        return view('dashboard.pages.users.index', compact(['users','roles']));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        abort_if(!auth()->user()->can('create users'), 403);
        $user = UserService::create($request , $request->validated());
        return redirect()->route('dashboard.users.role',$user->id)->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        abort_if(!auth()->user()->can('edit users'), 403);
        return view('dashboard.pages.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        abort_if(!auth()->user()->can('edit users'), 403);
        $user = UserService::update($request,$request->validated(),$user);
        return redirect()->route('dashboard.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        abort_if(!auth()->user()->can('delete users'), 403);
        if ($user) {
            if ($user->image) {
                $imagePath = public_path('uploads/users/' . $user->image->filename);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $user->image->delete();
            }
            $user->delete();
        }
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
    public function addRole(string $id){
        abort_if(!auth()->user()->can('create users'), 403);
        $user = User::findOrFail($id);  
        $roles = Role::all();
        return view('dashboard.pages.users.assign-role',compact(var_name: ['roles','user']));
    }
    public function assignRole(string $id,Request $request){
        abort_if(!auth()->user()->can('create users'), 403);
        $user = User::findOrFail($id);  
        $request->validate([
           'role'=> 'required|string|max:255|exists:roles,name' 
        ]);
        $user->syncRoles([$request->input('role')]);
        return redirect()->route('dashboard.users.index')->with('success','Role assigned successfully to '.$user->name);
    }
    
}
