<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answers;
use App\Models\Choices;
use App\Models\Questions;
use App\Models\CorrectAnswers;
use Illuminate\Http\Request;

class GradingController extends Controller
{
    public function makeQuestions(Request $request){

        //dd($request);
        $Validate=$request->validate([
            'QuestionTitle'=>'required',
            'QuestionText'=>'required',
            'Type'=>'required',
            'QuestionImage'=>'image',
            'Choices'=>'nullable|array'
        ]);
       
       Questions::create([
            'title' => $Validate['QuestionTitle'],
            'text' => $Validate['QuestionText'],
            'type' => $Validate['Type'],
            	
        ]);
        $q= Questions::where('title', $request->QuestionTitle)->first();
       if(isset($request->QuestionImage)){
        $path = $request->file('QuestionImage')->storeAs('images', "Question_".$q->QuestionID . '.' . $request->file('QuestionImage')->extension(),'public');
        Questions::where('QuestionID', $q->QuestionID)->update(['ImagePath' => "storage/".$path]);
    
        }
        if($Validate['Choices']!=null){
            $choices=array_filter($Validate['Choices']);
            foreach($choices as $choice){
                Choices::create([
                    'QuestionID'=>$q->QuestionID,
                    'ChoiceText'=>$choice
                ]);
            }
        }
        return redirect()->back();
        //dd($request);
    }

    public function correctAnswers(){
        $markingscheme=[];
        $answers= CorrectAnswers::all();
        foreach($answers as $answer){
            $markingscheme[$answer->QuestionID]=$answer->AnswerText;
        }
        return $markingscheme;
    }
    public function markAnswers(){
        $markingscheme= $this->correctAnswers();
        print_r($markingscheme);
        $submittedanswers= Answers::all();
        foreach($submittedanswers as $submittedanswer){
            $submittedanswer->text==strtolower($markingscheme[$submittedanswer->QuestionID]) ?
                $submittedanswer->Status="correct" : $submittedanswer->Status="incorrect";
            
            Answers::where('AnswerID',$submittedanswer->AnswerID)->update(['Status'=>$submittedanswer->Status]);
        } 
    }
}
