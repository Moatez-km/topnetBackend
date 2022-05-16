<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    //
    public function addquestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'time' => 'required',
            'niveau' => 'required',
            'type' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $question = Question::create([
                'question' => $request->question,
                'time' => $request->time,
                'niveau' => $request->niveau,
                'type' => $request->type,
            ]);
            return response()->json([
                'status' => 200,

                'question' => $question,
                'message' => 'question added Succefully',
            ]);
        }
    }
    public function showQuestion()
    {
        $question = Question::all();
        return response()->json([
            'status' => 200,
            'question' => $question
        ]);
    }
    public function editQuestion($_id)
    {
        $question = Question::find($_id);
        if ($question) {
            return response()->json([
                'status' => 200,
                'question' => $question,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'this question not found',
            ]);
        }
    }
    public function updateQuestion(Request $request, $_id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'time' => 'required',
            'niveau' => 'required',
            'type' => 'required|string|max:191',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $question = Question::find($_id);
            if ($question) {
                $question->question = $request->input('question');
                $question->time = $request->input('time');

                $question->niveau = $request->input('niveau');
                $question->type = $request->input('type');
                $question->save();


                return response()->json([
                    'status' => 200,
                    'question' => $question,

                    'message' => 'question updated Succefully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,


                    'message' => 'No question Id found',
                ]);
            }
        }
    }
    public function destroy($id)
    {
        $question = Question::find($id);
        if ($question) {
            $question->delete();
            return response()->json([
                'status' => 200,


                'message' => 'Question deleted',
            ]);
        } else {
            return response()->json([
                'status' => 404,


                'message' => 'No question Id found',
            ]);
        }
    }
}
