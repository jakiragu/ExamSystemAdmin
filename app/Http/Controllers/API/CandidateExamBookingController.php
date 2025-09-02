<?php

namespace App\Http\Controllers\API;

use App\Models\CandidateExamBooking;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class CandidateExamBookingController extends Controller
{
    // GET /api/bookings
    public function index()
    {
        return CandidateExamBooking::with(['candidate', 'examCatalog'])->get();
    }

    // POST /api/bookings
    public function store(Request $request)
    {
        $user = $request->user();

    
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'exam_catalog_id' => 'required|exists:exam_catalogs,id',
            'scheduled_at' => 'required|date|after_or_equal:today',
        ]);

        // Check for existing booking
        $existing = CandidateExamBooking::where('candidate_id', $user->id)
            ->where('exam_catalog_id', $validated['exam_catalog_id'])
            ->where('status', 'booked')
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'You already have a booking for this exam.',
                'booking' => $existing
            ], 409);
        }

        // Create new booking
        $booking = CandidateExamBooking::create([
            'candidate_id' => $user->id,
            'exam_catalog_id' => $validated['exam_catalog_id'],
            'scheduled_at' => $validated['scheduled_at'],
            'status' => 'booked',
            'payment_status' => 'pending',
            'reschedule_count' => 0,
        ]);

        $booking->load(['candidate', 'examCatalog']);

        Log::info('New booking created', [
            'candidate_id' => $user->id,
            'exam_catalog_id' => $validated['exam_catalog_id'],
            'scheduled_at' => $validated['scheduled_at'],
        ]);

        return response()->json([
            'message' => 'Booking successful',
            'booking' => $booking,
        ], 201);
    }

    // GET /api/bookings/{id}
    public function show($id)
    {
        return CandidateExamBooking::with(['candidate', 'examCatalog'])->findOrFail($id);
    }

    // PUT /api/bookings/{id}
    public function update(Request $request, $id)
    {
        $booking = CandidateExamBooking::findOrFail($id);

        $validated = $request->validate([
            'status' => 'in:booked,paid,cancelled,missed,completed',
            'payment_status' => 'in:pending,confirmed,waived',
            'scheduled_at' => 'date',
        ]);

        $booking->update($validated);

        return response()->json($booking);
    }

    // DELETE /api/bookings/{id}
    public function destroy($id)
    {
        CandidateExamBooking::findOrFail($id)->delete();

        return response()->json(['message' => 'Booking cancelled']);
    }

    // GET /api/my-bookings
    public function myBookings(Request $request)
    {
        $candidateId = $request->user()->id;

        $bookings = CandidateExamBooking::with([
                'examCatalog:id,title,start_time,end_time,start_url'
            ])
            ->where('candidate_id', $candidateId)
            ->whereHas('examCatalog', function ($query) {
                $query->whereNotNull('start_time')
                      ->whereNotNull('end_time')
                      ->whereNotNull('title');
            })
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return response()->json($bookings);
    }

    // GET /api/student-bookings
    public function studentBookings(Request $request)
    {
        $studentId = $request->user()->id;

        $bookings = CandidateExamBooking::with('examCatalog')
            ->where('candidate_id', $studentId)
            ->where('status', 'booked')
            ->get();

        return response()->json($bookings);
    }
}