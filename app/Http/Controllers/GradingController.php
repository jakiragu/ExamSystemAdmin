<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answers;
use App\Models\Choices;
use App\Models\Questions;
use App\Models\CorrectAnswers;
use App\Events\markAnswers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GradingController extends Controller
{
    public function markAnswers()
    {
        // Step 1: Get marking scheme
        $markingScheme = $this->correctAnswers();

        // Step 2: Get all submitted answers
        $submittedAnswers = Answers::all();

        // Step 3: Loop over each submitted answer
        foreach ($submittedAnswers as $submittedAnswer) {
            $question = Questions::find($submittedAnswer->QuestionID);

            if (!$question) {
                continue; // skip if question not found
            }

            $correctAnswer = strtolower($markingScheme[$submittedAnswer->QuestionID] ?? '');
            $studentAnswer = strtolower($submittedAnswer->text);

            $status = 'incorrect';

            switch ($question->type) {
                case 'MCQ':
                    if ($studentAnswer === $correctAnswer) {
                        $status = 'correct';
                    }
                    break;

                case 'MRQ':
                    if ($this->isJson($correctAnswer) && $this->isJson($studentAnswer)) {
                        $correctArray = json_decode($correctAnswer, true);
                        $studentArray = json_decode($studentAnswer, true);
                        if (is_array($correctArray) && is_array($studentArray) && $this->compareArrays($correctArray, $studentArray)) {
                            $status = 'correct';
                        }
                    }
                    break;

                case 'Text':
                case 'Practical':
                    $status = 'pending_review'; // we want human to review these
                    break;

                default:
                    $status = 'incorrect';
                    break;
            }

            // Save result
            $submittedAnswer->Status = $status;
            $submittedAnswer->save();
        }

        return redirect()->back()->with('success', 'Answers have been graded successfully!');
    }

    /**
     * Helper to get correct answers
     */
    public function correctAnswers()
    {
        $markingScheme = [];
        $answers = CorrectAnswers::all();
        foreach ($answers as $answer) {
            $markingScheme[$answer->QuestionID] = $answer->AnswerText;
        }
        return $markingScheme;
    }

    /**
     * Helper to check if string is JSON
     */
    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Helper to compare two arrays regardless of order
     */
    private function compareArrays($array1, $array2)
    {
        sort($array1);
        sort($array2);
        return $array1 == $array2;
    }
    public function releaseResults()
{
    \App\Models\Candidates::query()->update(['ResultsReleased' => true]);

    return redirect()->back()->with('success', 'Results have been released to all students.');
}
public function makeQuestions(Request $request){

        //dd($request);
        $Validate=$request->validate([
            'QuestionTitle'=>'required',
            'QuestionText'=>'required',
            'Type'=>'required',
            'QuestionImage'=>'image',
            'Choices'=>'nullable|array',
            'CorrectAnswer'=>'required'
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
        if(is_array($Validate['CorrectAnswer'])){
           $Validate['CorrectAnswer']=json_encode($Validate['CorrectAnswer']);
        }
        CorrectAnswers::create([
            'QuestionID'=>$q->QuestionID,
            'AnswerText'=>$Validate['CorrectAnswer']
        ]);
        return redirect()->back();
        //dd($request);
    }
    public function viewQuestions()
{
    $questions = \DB::table('questions')->get();
    return view('ViewQuestions', compact('questions'));
}
public function deleteQuestion($id)
{
    \DB::table('questions')->where('QuestionID', $id)->delete();
    return redirect()->route('ViewQuestions')->with('success', 'Question deleted successfully!');
}




}
