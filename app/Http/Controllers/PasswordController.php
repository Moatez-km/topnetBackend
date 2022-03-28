<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class PasswordController extends Controller
{
    public function forgot(Request $request)
    {
        $email = $request->input('email');
        $token = Str::random(12);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        Mail::send('reset', ['token' => $token], function (Message $message) use ($email) {
            $message->subject('Reset your password');
            $message->to($email);
        });
        return response()->json([
            'status' => 200,
            'message' => 'Check your email !'
        ]);
    }
    public function reset(Request $request)
    {
        if ($request->input('password') !== $request->input('password_confirm')) {
            return response()->json([
                'status' => 400,
                'message' => 'password do not match !'
            ]);
        }

        $passwordResets = DB::table('password_resets')->where('token', $request->input('token'))->first();


        $user = User::where('email', $passwordResets['email'])->first();
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'user not found'
            ]);
        }
        $user->password = Hash::make($request->input('password'));
        $user->firstlogin = Carbon::now();
        $user->save();
        return response()->json([
            'status' => 200,
            'user' => $user,
            'message' => 'success'
        ]);
    }
}
