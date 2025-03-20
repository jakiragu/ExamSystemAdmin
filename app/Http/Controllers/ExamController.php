<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Candidates;
use App\Models\Questions;
use App\Models\Answers;
use App\Models\Choices;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function viewStudentInfo(){
        $students=Candidates::all();
        return view('studentInfo',compact('students'));
    }
    public function viewSubmissions(){
        $students=Candidates::whereHas('Answers')->get();
        return view('ViewSubmissions',compact('students'));
    }
    public function registerCandidates(Request $request){
        $validatedData=$request->validate([
            'FullName'=>"required",
            'Email'=>"email|required",
            'CertificationID'=>'required',
            'Organization'=>'required',
            'Occupation'=>'required',
            'MobileNo'=>'required'
        ]);
        Candidates::create($validatedData);
     
    }
public function viewAnswers($id){
        $answers=Answers::where('CertificationID',$id)->get();
        $question=[];
        foreach($answers as $answer){
        $QID=$answer->QuestionID;
        $question[$QID]=Questions::where('QuestionID',$QID)->first();
        }
        $student=Candidates::where('CertificationID',$id)->first();
        return view('ViewAnswers',compact('answers','question','student'));	
  }
    public function showQuestions($id=null){
      $Question= $id?Questions::where('QuestionID',$id)->first(): Questions::orderby('QuestionID')->first();
      $Choices=Choices::where('QuestionID',$Question['QuestionID'])->get() ?? "";
      $Answer= session($Question['QuestionID'],"");
      return view('Questions',compact('Question','Answer','Choices'));

    }
    public function examOverview(){
        $Questions=Questions::select('QuestionID','title')->get();
        return view('ExamOverview',compact('Questions'));
    }
    public function submitExam(Request $request){
        //print_r($request->answers);
        $answers=json_decode($request->answers);
        //print_r($answers);
        $candidate=session('candidate');
        foreach($answers as $question=>$answer){
            $answer=strtolower($answer);
            Answers::create([
                'CertificationID'=>$candidate,
                'QuestionID'=>$question,
                'text'=>$answer
            ]);
        }
        session()->flush();
        return redirect()->route('register.create');
    }
}
