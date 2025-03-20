<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Events\PauseTimer;
use App\Events\ResumeTimer;
use App\Events\StartTimer;
use App\Events\ResetTimer;
use App\Events\AdjustTimer;
use App\Models\Questions;
use App\Models\Choices;
use App\Events\SendQuestions;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class TimerController extends Controller
{
    public function StartTimer(){
    //    broadcast(new StartTimer());
        $questions = Questions::select('QuestionID', 'title', 'text', 'type', 'ImagePath')->get()->toArray();
        $choices=Choices::select('ChoiceID','ChoiceText','QuestionID')->get()->toArray();
        broadcast(new SendQuestions(['Questions'=>$questions,'Choices'=>$choices]));
        //$response=Http::post('http://127.0.0.1:8001/receive-questions',$questions);
        return redirect()->back();
    }
    public function ResumeTimer(){
        broadcast(new ResumeTimer());
        return redirect()->back();
    }
    public function PauseTimer(){
        broadcast(new PauseTimer());
        return redirect()->back();
    }
    public function ResetTimer(){
        broadcast(new ResetTimer());
        return redirect()->back();
    }
    public function AdjustTimer(Request $request){
        broadcast(new AdjustTimer($request->hours, $request->minutes));
        return redirect()->back();
    }
}
