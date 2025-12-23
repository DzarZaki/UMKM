<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login'); 
    }

    public function authentication(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $role = Auth::user()->role;

        // ADMIN
        if ($role === 'admin') {
            return redirect()->intended(route('dashboard'));
        }

        // FOTOGRAFER / VIDEOGRAFER
        if (in_array($role, ['fotografer', 'videografer', 'fotografer_videografer'])) {
            return redirect()->intended(route('dashboard.fotografer'));
        }

        // fallback (harusnya gak kejadian)
        Auth::logout();
    }

    return back()->with('loginError', 'Username atau password salah!');
}

}
