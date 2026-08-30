<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string']]);
        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember) || ! $request->user()->is_admin) {
            Auth::logout();
            throw ValidationException::withMessages(['email' => 'These credentials do not match an administrator account.']);
        }

        $request->session()->regenerate();
        return to_route('admin.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('admin.login');
    }
}
