<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('dashboard.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('dashboard.profile.edit')->with('status', 'profile-updated');
    }



    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $this->deleteImage();
            $filename = $image->store('/users', 'public');
            if (!auth()->user()) {
                return back()->with('error', 'User not found');
            }
            auth()->user()->image()->create([
                'path' => $filename,
            ]);
        }
        return redirect()->back()->with('success', 'Image updated successfully');
    }
    public function destroyImage()
    {
        if ($this->deleteImage()) {
            return redirect()->back()->with('success', 'your image has been deleted');
        }
        return redirect()->back()->with('error', 'you\'re not have a image');
    }
    private function deleteImage()
    {
        if (auth()->user()->image) {
            Storage::delete('public/' . auth()->user()->image->path);
            auth()->user()->image()->delete();
            return true;
        }
        return false;
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
