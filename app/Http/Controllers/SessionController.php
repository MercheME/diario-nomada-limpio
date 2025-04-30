<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        // Invalidar la sesión
        $request->session()->invalidate();

        // Redirección a la página de inicio
        return redirect( route('login'));
    }
}
