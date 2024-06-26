<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserActivationController extends Controller
{
    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Invalid activation token.');
        }

        return view('auth.activate', ['token' => $token]);
    }

    public function setPassword(Request $request, $token)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect('/login')->withErrors(['message' => 'Invalid activation token.']);
        }

        $user->password = Hash::make($request->password);
        $user->activation_token = null;
        $user->save();

        return redirect('/login')->with('success', 'Account activated! You can now log in.');
    }
}
