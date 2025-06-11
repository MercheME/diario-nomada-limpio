<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{

    public function show(User $user)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::id() !== $user->id && !Auth::user()->esAmigoDe($user)) {
            abort(403, 'No tienes permiso para ver este perfil. Hazte amigo/a de esta persona para poder verlo.');
        }

        $diarios = $user->diarios()
                        ->where('is_public', true)
                        ->latest()
                        ->paginate(10);

        return view('perfils.show', [
            'user'    => $user,
            'diarios' => $diarios,
        ]);
    }

    public function edit()
    {
        return view('perfils.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // La regla 'unique' debe ignorar el ID del usuario actual para evitar un error de "email ya en uso" con su propio email
                Rule::unique('users')->ignore($user->id),
            ],
            'bio' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);


        if ($request->hasFile('profile_image')) {

            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $validatedData['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            // Si contraseña está vacío, se elimina del array de datos para no sobreescribir la contraseña existente con valor nulo
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('home')->with('status', '¡Perfil actualizado con éxito!');
    }
}
