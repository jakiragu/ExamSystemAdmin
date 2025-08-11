<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidates;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    /**
     * Register a new candidate and log them in via session.
     */
    public function register(Request $request)
    {
        // ✅ Validate input
        $validator = Validator::make($request->all(), [
            'FullName' => 'required|string|max:255',
            'Email' => 'required|email|unique:candidates,Email',
            'Organization' => 'required|string|max:255',
            'Occupation' => 'required|string|max:255',
            'MobileNo' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // ✅ Create candidate
        $certificationID = rand(10000, 99999);

        try {
            $candidate = Candidates::create([
                'CertificationID' => $certificationID,
                'FullName' => $request->FullName,
                'Email' => $request->Email,
                'Organization' => $request->Organization,
                'Occupation' => $request->Occupation,
                'MobileNo' => $request->MobileNo,
                'ResultsReleased' => 0
            ]);

            // ✅ Log in using session (web guard)
            Auth::guard('web')->login($candidate);

            return response()->json([
                'status' => 'success',
                'message' => 'Student registered successfully!',
                'candidate' => $candidate
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log in a candidate using session-based auth.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $request->session()->regenerate();

        return response()->json(['message' => 'Login successful']);
    }

    /**
     * Return the authenticated candidate's profile.
     */
    public function profile(Request $request)
    {
        $user = $request->user(); // Sanctum will resolve this via session

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return response()->json([
            'id' => $user->id,
            'FullName' => $user->FullName,
            'Email' => $user->Email,
            'Organization' => $user->Organization,
            'Occupation' => $user->Occupation,
            'MobileNo' => $user->MobileNo,
        ]);
    }

    /**
     * Log out the candidate and invalidate session.
     */
    public function logout(Request $request)
    {
        try {
            // ✅ Token-based logout (if used)
            if ($request->user() && method_exists($request->user(), 'currentAccessToken')) {
                // $request->user()->currentAccessToken()->delete();
            }

            // ✅ Session-based logout
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
}