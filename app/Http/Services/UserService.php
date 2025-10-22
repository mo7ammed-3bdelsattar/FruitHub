<?php

namespace App\Http\Services;

use App\Models\Cart;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{


    public static function create($request, $validated)
    {
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        Cart::create([
            "user_id" => $user->id,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        Wishlist::create([
            "user_id" => $user->id,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->store('/users', 'public');
            if (!$user) {
                return back()->with('error', 'User not found');
            }
            $user->image()->create([
                'path' => $filename,
            ]);
        }
        return $user;
    }
    public static function update($request,$validated, $user)
    {
        if($validated['password'] != $user->password) $validated['password'] = Hash::make($validated['password']);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($user->image) {
                Storage::delete('public/' . $user->image->path);
                $user->image()->delete();
            }
            $filename = $image->store('/users', 'public');
            if (!$user) {
                return back()->with('error', 'User not found');
            }
            $user->image()->create([
                'path' => $filename,
            ]);
            $user->update($validated);
        }
        return $user;
    }
}
