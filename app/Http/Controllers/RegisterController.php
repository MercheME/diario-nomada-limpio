<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase() // al menos una mayúscula y una minúscula
                    ->numbers()
                    ->symbols()
            ],
            'bio' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
        'name.required' => 'Por favor, introduce tu nombre.',
        'email.required' => 'El correo electrónico es necesario para registrarte.',
        'email.unique' => 'Este correo electrónico ya está en uso, por favor elige otro.',
        'password.required' => 'El campo de contraseña no puede estar vacío.',
        'password.confirmed' => 'Las contraseñas no coinciden. Por favor, inténtalo de nuevo.',
        'password.min' => 'Tu contraseña debe tener como mínimo :min caracteres.',
        ]);

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        } else {
            $imagePath = null;
        }

        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'bio' => $request->bio,
            'profile_image' => $imagePath,
        ]);

        Auth::login($usuario);
        return redirect('/home');
    }
}
