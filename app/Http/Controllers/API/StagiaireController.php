<?php

namespace App\Http\Controllers\API;

use App\Models\Stagiaire;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StagiaireController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|max:191',
            'prenom' => 'required|max:191',
            'cin' => 'required|max:8',
            'passeport' => 'string',
            'email' => 'required|max:191|unique:users,email',
            'password' => 'required|min:8',
            'adresse' => 'required',
            'tel' => 'required|max:8',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',


        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            /*$stagiaire = Stagiaire::create([
                'nom' => $request->nom,
                'prenom'=>$request->prenom,
                'cin'=>$request->cin,
                'passeport'=>$request->passeport,
                'addresse'=>$request->addresse,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_as' => 'user',
                'statut' => 'activer',
                'firstlogin' => Carbon::now(),
            ]);*/
            $stagiaire = new Stagiaire();
            $stagiaire->nom = $request->input('nom');
            $stagiaire->prenom = $request->input('prenom');
            $stagiaire->email = $request->input('email');
            $stagiaire->password = Hash::make($request->input('password'));
            $stagiaire->cin = $request->input('cin');
            $stagiaire->tel = $request->input('tel');
            $stagiaire->passeport = $request->input('passeport');
            $stagiaire->adresse = $request->input('adresse');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/profile/', $filename);
                $stagiaire->image = 'uploads/profile/' . $filename;
            }
            $stagiaire->save();
            $token = $stagiaire->createToken($stagiaire->email . '_TokenStagiaire')->plainTextToken;
            return response()->json([
                'status' => 200,
                'nom' => $stagiaire->nom,
                'token' => $token,
                'stagiaire' => $stagiaire,
                'message' => 'registred Succefully',
            ]);
        }
    }
    //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|max:191',
            'password' => 'required|min:8',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        } else {

            $stagiaire = Stagiaire::where('email', $request->email)->first();

            if (!$stagiaire || !Hash::check($request->password, $stagiaire->password)) {
                return response()->json([
                    'status' => 401,
                    'validation_errors' => $validator->messages(),
                ]);
            } else {

                $token = $stagiaire->createToken($stagiaire->email . '_StagiaireToken', ['server:stagiaire'])->plainTextToken;
            }

            return response()->json([
                'status' => 200,
                'stagiaire' => $stagiaire,

                'token' => $token,

                'message' => 'Logged in Succefully',
            ]);
        }
    }
}
