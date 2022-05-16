<?php

namespace App\Http\Controllers;

use App\Models\Reponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReponseController extends Controller
{
    public function addReponse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required',
            'reponse' => 'required',
            'statut' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $reponse = new Reponse;
            $reponse->question_id = $request->input('question_id');
            $reponse->reponse = $request->input('reponse');
            $reponse->statut = $request->input('statut');
            $reponse->save();
            return response()->json([
                'status' => 200,
                'reponse' => $reponse,
                'message' => 'reponse added successfully',

            ]);
        }
    }
}
