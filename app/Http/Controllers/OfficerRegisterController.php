<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OfficerRegisterController extends Controller
{
    public function create()
    {
        $provinces = Province::all();
        return view('auth.officer-register', compact('provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => "required",
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'city' => 'required|exists:cities_municipalities,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'city_municipality_id' => $request->city,
            'role' => 'officer',
        ]);

        Auth::login($user);

        return redirect('/officer/dashboard');
    }
}
