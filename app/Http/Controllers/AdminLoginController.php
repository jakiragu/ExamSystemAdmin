<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admins;

class AdminLoginController extends Controller
{
    public function create()
    {
        return view('AdminLogin'); // your Blade file: resources/views/AdminLogin.blade.php
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admins::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            return redirect()->route('adminDashboard');
        }

        return back()->withErrors([
            'login' => 'Invalid email or password.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('Admin');
    }

    // Optional for Admin Sign Up
    public function index()
    {
        return view('AdminSignup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'AdminName' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Admins::create([
            'AdminName' => $request->AdminName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('Admin')->with('success', 'Admin created successfully!');
    }
}
