<?php

namespace App\Http\Controllers;

use App\Events\PauseTimer;
use App\Events\ResumeTimer;
use App\Events\StartTimer;
use App\Events\ResetTimer;
use App\Events\AdjustTimer;
use App\Events\SendQuestions;
use App\Models\Questions;
use App\Models\Choices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TimerController extends Controller
{
    public function StartTimer()
    {
        try {
            broadcast(new StartTimer());

            $questions = Questions::select('QuestionID', 'title', 'text', 'type', 'ImagePath')->get();
            $choices = Choices::select('ChoiceID', 'ChoiceText', 'QuestionID')->get();

            broadcast(new SendQuestions([
                'Questions' => $questions,
                'Choices' => $choices,
            ]));
        } catch (\Exception $e) {
            Log::error('StartTimer failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to start timer. Please check logs.');
        }

        return redirect()->back()->with('success', 'Timer started and questions broadcasted.');
    }

    public function ResumeTimer()
    {
        try {
            broadcast(new ResumeTimer());
        } catch (\Exception $e) {
            Log::error('ResumeTimer failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to resume timer.');
        }

        return redirect()->back()->with('success', 'Timer resumed.');
    }

    public function PauseTimer()
    {
        try {
            broadcast(new PauseTimer());
        } catch (\Exception $e) {
            Log::error('PauseTimer failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to pause timer.');
        }

        return redirect()->back()->with('success', 'Timer paused.');
    }

    public function ResetTimer()
    {
        try {
            broadcast(new ResetTimer());
        } catch (\Exception $e) {
            Log::error('ResetTimer failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to reset timer.');
        }

        return redirect()->back()->with('success', 'Timer reset.');
    }

    public function AdjustTimer(Request $request)
    {
        $validated = $request->validate([
            'hours' => 'required|integer|min:0|max:23',
            'minutes' => 'required|integer|min:0|max:59',
        ]);

        try {
            broadcast(new AdjustTimer($validated['hours'], $validated['minutes']));
        } catch (\Exception $e) {
            Log::error('AdjustTimer failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to adjust timer.');
        }

        return redirect()->back()->with('success', 'Timer adjusted successfully.');
    }
}