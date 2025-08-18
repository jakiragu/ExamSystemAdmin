<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = Admins::all();
        return view('indexAdmin', compact('admins'));
    }

    public function create()
    {
        return view('createAdmins');
    }

    public function store(Request $request)
    
    {
        $request->validate([
            'AdminName' => 'required|unique:admins',
            'Email' => 'required|email|unique:admins',
            'password' => 'required|min:6',
        ]);

        Admins::create([
            'AdminName' => $request->AdminName,
            'Email' => $request->Email,
            'password' => Hash::make($request->password),
            'is_super' => $request->has('is_super'),
        ]);

        return redirect()->route('manage-admins.index')->with('success', 'Admin added');
    }

    public function edit($id)
    {
        $admin = Admins::findOrFail($id);
        return view('editAdmins', compact('admin'));
    }

    public function update(Request $request, $id)
{
    $admin = Admins::findOrFail($id);

    $request->validate([
        'AdminName' => 'required',
        'Email' => 'required|email|unique:admins,Email,' . $id,
        'password' => 'nullable|min:6',
    ]);

    $admin->AdminName = $request->AdminName;
    $admin->Email = $request->Email;
    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }
    $admin->is_super = $request->has('is_super');

    $admin->save();

    return redirect()->route('manage-admins.index')->with('success', 'Admin updated');
}


    public function destroy($id)
    {
        Admins::destroy($id);
        return redirect()->route('manage-admins.index')->with('success', 'Admin deleted');
    }
}
