<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\CitiesMunicipalities;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $inviteCode = $request->query('invitation');
        $provinces = Province::all();
        return view('auth.register', compact('provinces', 'inviteCode'));
    }

    public function getCities($provinceId): \Illuminate\Http\JsonResponse
    {
        $cities = CitiesMunicipalities::where('province_id', $provinceId)->get();
        return response()->json($cities);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'role' => ['required', Rule::in(['reporter', 'officer'])],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'city' => 'required|exists:cities_municipalities,id',
            'invitation' => 'nullable|string',
        ]);

        $role = $request->input('role', 'reporter');
        $code = Invitation::where(['code' => $request->invitation, 'status' => 5])->exists();
        if ($request->filled('invitation') && $code) {
            $role = 'officer';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'city_municipality_id' => $request->city,
            'role' => $role,
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');

            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = $path;
            $user->save();
        }

        event(new Registered($user));

        Auth::login($user);

        Invitation::where('code', $request->invitation)->update(['status' => 1]);

        return redirect(route('dashboard', absolute: false));
    }
}
