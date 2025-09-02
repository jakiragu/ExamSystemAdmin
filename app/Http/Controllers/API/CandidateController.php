<?php

namespace App\Http\Controllers\API;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class CandidateController extends Controller
{
    /**
     * Register a new candidate
     */
    public function register(Request $request)
    {
        $request->validate([
            'FullName' => 'required|string|max:255',
            'Email' => 'required|email|unique:candidates,Email',
            'Organization' => 'nullable|string|max:255',
            'Occupation' => 'nullable|string|max:255',
            'MobileNo' => 'nullable|string|max:20',
            'password' => 'required|string|min:8'
        ]);

        // Generate unique CertificationID
        do {
            $certificationID = rand(10000, 99999);
        } while (Candidate::where('CertificationID', $certificationID)->exists());

        $candidate = Candidate::create([
            'CertificationID' => $certificationID,
            'FullName' => $request->FullName,
            'Email' => $request->Email,
            'Organization' => $request->Organization,
            'Occupation' => $request->Occupation,
            'MobileNo' => $request->MobileNo,
            'password' => Hash::make($request->password),
            'ResultsReleased' => 0
        ]);
        Auth::login($candidate); 
        $request->session()->regenerate(); 

        return response()->json([
            'message' => 'Registration successful',
            'candidate' => $candidate
        ], 201);
    }

    /**
     * Login candidate
     */
    public function login(Request $request)
    {
        $request->validate([
            'Email' => 'required|email',
            'password' => 'required',
        ]);

        // Match DB column name exactly
        if (!Auth::attempt([
            'Email' => $request->Email,
            'password' => $request->password
        ])) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Login successful',
            'candidate' => Auth::user()
        ]);
    }
    

    /**
     * Logout candidate
     */
    public function logout(Request $request)
    {
        try {
            if (Auth::check()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return response()->json([
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get logged-in candidate profile
     */
    public function profile()
    {
        return response()->json([
            'candidate' => Auth::user()
        ]);
    }
}
