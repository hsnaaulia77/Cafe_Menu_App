<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// ... existing use statements ...
// ... existing code ... 

    public function edit()
    {
        $user = auth()->user();
        return view('customer.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        if (auth()->user()->role !== 'customer') {
            abort(403, 'Unauthorized');
        }
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
// ... existing code ... 