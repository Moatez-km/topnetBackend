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
            'role_as' => 'string',

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
                'role_as' => 'user',
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
                if ($user->role_as === 'admin') {
                    $token = $user->createToken($user->email . '_AdminToken', ['server:admin'])->plainTextToken;
                } else {
                    $token = $user->createToken($user->email . '_Token', ['server:user'])->plainTextToken;
                }

                return response()->json([
                    'status' => 200,
                    'username' => $user->name,
                    'token' => $token,
                    'role' => $user->role_as,
                    'message' => 'Logged in Succefully',
                ]);
            }
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logged out Successfully',
        ]);
    }
    public function showUser()
    {
        $user = User::all();
        return response()->json([
            'status' => 200,
            'user' => $user
        ]);
    }
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|max:191|unique:users,email',
            'password' => 'required|min:8',
            'role_as' => 'string',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->role_as = $request->input('role_as');
            $user->save();


            return response()->json([
                'status' => 200,
                'user' => $user,

                'message' => 'registred Succefully',
            ]);
        }
    }
}
