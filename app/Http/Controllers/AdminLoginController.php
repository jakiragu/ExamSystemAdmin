<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admins;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('AdminSignUp');
    }

    public function create()
    {
        return view('AdminLogin');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
        'AdminName' => 'required',
        'Email' => 'required|email',
        'password' => 'required',
    ]);
    
    Admins::create([
        'AdminName' => $validated['AdminName'],
        'Email'=> $validated['Email'],
        'password' => Hash::make($validated['password']), 
    ]);
    
    return redirect()->route('Admin');
    }
    
    public function login(Request $request)
    {
        $validated=$request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        
        $admin=Admins::where('Email',$validated['email'])->first();
        if($admin && Hash::check($validated['password'],$admin->password)){
            session()->flush();            
            session(['admin'=>$admin, 'admin_logged_in'=>true, 'admin_name'=>$admin->AdminName]);
            //dd(session()->all());
            return redirect()->route('adminDashboard');

        }
        // $credentials=['Email'=>$validated['Email'],'password'=>$validated['password']];
        // if (Auth::attempt($credentials)) {

        //     return redirect()->intended('/adminDashboard'); 
        // }
        return back()->withErrors([
            'login' => 'These credentials do not match our records.',
        ])->withInput();
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/Admin');
    }

}
