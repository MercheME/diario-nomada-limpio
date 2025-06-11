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
            return redirect('/home');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect( route('login'));
    }
}
