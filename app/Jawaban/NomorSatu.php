<?php

namespace App\Jawaban;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NomorSatu {

    public function auth(Request $request) {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        $authData = [
            $loginField => $credentials['login'],
            'password' => $credentials['password']
        ];

        if (Auth::attempt($authData)) {
            $request->session()->regenerate();
            return redirect()->route('event.home')->with('message', ['Login successful!', 'success']);
        }

        return redirect()->route('event.home')->with('message', ['Invalid credentials', 'danger']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('event.home')->with('message', ['Logged out successfully!', 'success']);
    }
}
?>