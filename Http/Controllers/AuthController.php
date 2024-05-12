<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }

    public function registerSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        // Add custom validation rule to ensure email starts with "admin"
        $validator->sometimes('email', 'starts_with:admin', function ($input) {
            return !Str::startsWith($input->email, 'admin');
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 'Admin'
        ]);

        return redirect()->route('login');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function loginAction(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        // Check if the email starts with "admin"
        if (!Str::startsWith($request->email, 'admin')) {
            throw ValidationException::withMessages([
                'email' => 'Unauthorized Access! Only admin are allowed to login.'
            ]);
        }
    
        // Attempt the login
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        } else {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }
    }
    

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
