<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $shipping_fee = \App\Models\Setting::get('shipping_fee', 99.00);
        $free_shipping_threshold = \App\Models\Setting::get('free_shipping_threshold', 999.00);
        
        return view('admin.settings.index', compact('shipping_fee', 'free_shipping_threshold'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'shipping_fee' => 'required|numeric|min:0',
            'free_shipping_threshold' => 'required|numeric|min:0',
        ]);

        \App\Models\Setting::updateOrCreate(
            ['key' => 'shipping_fee'],
            ['value' => $request->shipping_fee]
        );

        \App\Models\Setting::updateOrCreate(
            ['key' => 'free_shipping_threshold'],
            ['value' => $request->free_shipping_threshold]
        );

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
