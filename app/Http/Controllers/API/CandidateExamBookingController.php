<?php

namespace App\Http\Controllers\API;

use App\Models\CandidateExamBooking;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
        $validated = $request->validate([
            'exam_catalog_id' => 'required|exists:exam_catalogs,id',
            'scheduled_date' => 'required|date|after_or_equal:today',
        ]);

        $booking = CandidateExamBooking::create([
        'candidate_id' => $request->user()->id, // auto from session
        'exam_catalog_id' => $request->exam_catalog_id,
        'scheduled_at' => $request->scheduled_date,
    ]);
    $booking->load(['candidate', 'examCatalog']);

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
}