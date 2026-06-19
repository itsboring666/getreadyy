<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->latest()->get();
        return view('profile.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('profile.addresses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address_name' => ['required', 'string', 'max:255'],
            'name'         => ['required', 'string', 'min:2', 'max:100'],
            'phone'        => ['required', 'regex:/^[6-9]\d{9}$/'],
            'address'      => ['required', 'string', 'min:10', 'max:255'],
            'city'         => ['required', 'string', 'max:50'],
            'state'        => ['required', 'string', 'max:50'],
            'zip'          => ['required', 'regex:/^\d{5,6}$/'],
        ], [
            'name.required' => 'Full name is required.',
            'phone.regex' => 'Enter a valid Indian mobile number.',
            'zip.regex' => 'ZIP code should be 5 or 6 digits.',
            'address.min' => 'Address should be at least 10 characters.',
        ]);

        $user = Auth::user();
        $isFirst = $user->addresses()->count() === 0;

        $address = new UserAddress($validated);
        $address->user_id = $user->id;
        $address->is_default = $isFirst ? true : (request()->has('is_default') ? true : false);

        if ($address->is_default) {
            // Unset all other defaults
            $user->addresses()->update(['is_default' => false]);
        }

        $address->save();

        return redirect()->route('addresses.index')->with('success', 'Address saved successfully.');
    }

    public function edit($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        return view('profile.addresses.edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);

        $validated = $request->validate([
            'address_name' => ['required', 'string', 'max:255'],
            'name'         => ['required', 'string', 'min:2', 'max:100'],
            'phone'        => ['required', 'regex:/^[6-9]\d{9}$/'],
            'address'      => ['required', 'string', 'min:10', 'max:255'],
            'city'         => ['required', 'string', 'max:50'],
            'state'        => ['required', 'string', 'max:50'],
            'zip'          => ['required', 'regex:/^\d{5,6}$/'],
        ], [
            'name.required' => 'Full name is required.',
            'phone.regex' => 'Enter a valid Indian mobile number.',
            'zip.regex' => 'ZIP code should be 5 or 6 digits.',
            'address.min' => 'Address should be at least 10 characters.',
        ]);

        $address->fill($validated);

        if ($request->has('is_default')) {
            $address->is_default = true;
            Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->save();

        return redirect()->route('addresses.index')->with('success', 'Address updated successfully.');
    }

    public function destroy($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        $wasDefault = $address->is_default;

        $address->delete();

        // If the deleted address was default, set another one as default
        if ($wasDefault) {
            $nextAddress = Auth::user()->addresses()->first();
            if ($nextAddress) {
                $nextAddress->is_default = true;
                $nextAddress->save();
            }
        }

        return redirect()->route('addresses.index')->with('success', 'Address deleted successfully.');
    }

    public function setDefault($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        
        Auth::user()->addresses()->update(['is_default' => false]);
        
        $address->is_default = true;
        $address->save();

        return redirect()->route('addresses.index')->with('success', 'Default address updated.');
    }
}
