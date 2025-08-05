<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidates;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FullName' => 'required|string|max:255',
            'Email' => 'required|email|unique:candidates,Email',
            'Organization' => 'required|string',
            'Occupation' => 'required|string',
            'MobileNo' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $certificationID = rand(10000, 99999); // or use a custom generator

        $candidate = Candidates::create([
            'CertificationID' => $certificationID,
            'FullName' => $request->FullName,
            'Email' => $request->Email,
            'Organization' => $request->Organization,
            'Occupation' => $request->Occupation,
            'MobileNo' => $request->MobileNo,
            'ResultsReleased' => 0
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Student registered successfully!',
            'candidate' => $candidate
        ]);
    }
}
