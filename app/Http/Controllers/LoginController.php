<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status === 0) {
                Auth::logout();
                return redirect()->route('login')->with('status', 'Your account is deactivated.');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }
}
