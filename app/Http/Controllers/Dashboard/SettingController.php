<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;

class SettingController extends Controller
{



    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        abort_if(!auth()->user()->can('edit settings'), 403);
        $settings = Setting::first();
        return view('dashboard.pages.settings',compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingRequest $request)
    {
        abort_if(!auth()->user()->can('edit settings'), 403);
        $setting = Setting::first();
        $setting->update($request->validated());
        return redirect()->back()->with('success', 'Settings updated successfully');
    }

}
