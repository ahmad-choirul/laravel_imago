<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|min:3|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Mencari user berdasarkan username dan email
        $user = \App\Models\User::where('username', $validated['username'])
                    ->where('email', $validated['email'])
                    ->first();

        if ($user && Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Username, email, atau password salah.',
        ]);
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|min:3|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = \App\Models\User::create($validated);

        Auth::login($user);

        return redirect()->intended('/');
    }

    // proses logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}


