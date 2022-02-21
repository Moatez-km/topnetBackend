<?php

namespace App\Http\Controllers\API;

use App\Models\User;

use Illuminate\Http\Request;





use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /* public function login()
    {

        $user = User::where('email', 'moatez.kamounn@gmail.com')->firstOrFail();
        $token = $user->createToken('myapptoken', ['user'])->plainTextToken;
        $response = [
            'status' => 200,
            'user' => $user,
            'token' => $token
        ];


        return response($response, 200);
    }*/
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|max:191|unique:users,email',
            'password' => 'required|min:8',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken($user->email . '_Token')->plainTextToken;
            return response()->json([
                'status' => 200,
                'username' => $user->name,
                'token' => $token,
                'message' => 'registred Succefully',
            ]);
        }
    }
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
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'validation_errors' => $validator->messages(),
                ]);
            } else {
                $token = $user->createToken($user->email . '_Token')->plainTextToken;
                return response()->json([
                    'status' => 200,
                    'username' => $user->name,
                    'token' => $token,
                    'message' => 'Logged in Succefully',
                ]);
            }
        }
    }
}
