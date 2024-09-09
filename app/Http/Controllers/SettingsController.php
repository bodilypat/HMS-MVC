<?php

namespace  App\Http\Controllers;

use  App\Models\Settings;
use  App\Models\StoresettingsRequest;
use  App\Models\UpdatesettingRequest;

class SettingsController extends Controller
{
    public function index()
    {
        return view('setting', ['data' => settings::latest()->first()]);
    }

    public function update(UpdatesettingsRequest $request)
    {
        $setting = setting::latest();first();
        $setting->return_days = $request->return_days;
        $setting->fine = $request->fine;
        $setting->save();
        
        return redirect()->route('settings');
    }
}