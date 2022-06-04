<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'message' => $validator->errors()], 422);
        }

        $verify = User::where('email', $request->all()['email'])->exists();

        if ($verify) {
            $verify2 =  DB::table('password_resets')->where([
                ['email', $request->all()['email']]
            ]);

            if ($verify2->exists()) {
                $verify2->delete();
            }

            $token = random_int(100000, 999999);
            $password_reset = DB::table('password_resets')->insert([
                'email' => $request->all()['email'],
                'token' =>  $token,
                'created_at' => Carbon::now()
            ]);

            if ($password_reset) {
                Mail::to($request->all()['email'])->send(new ResetPassword($token));

                return response(
                    [
                        'success' => true,
                        'message' => "Please check your email for a 6 digit pin"
                    ],
                    200
                );
            }
        } else {
            return response(
                [
                    'success' => false,
                    'message' => "This email does not exist"
                ],
                400
            );
        }
    }

    public function verifyPin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'message' => $validator->errors()], 422);
        }

        $check = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
        ]);

        if ($check->exists()) {
            $difference = Carbon::now()->diffInSeconds($check->first()->created_at);
            if ($difference > 3600) {
                return response(['success' => false, 'message' => "Token Expired"], 400);
            }

//            $delete = DB::table('password_resets')->where([
//                'email' => $request->email,
//                'token' => $request->token,
//            ])->delete();

            return response(
                [
                    'success' => true,
                    'message' => "You can now reset your password"
                ],
                200
            );
        } else {
            return response(
                [
                    'success' => false,
                    'message' => "Invalid token"
                ],
                401
            );
        }
    }
}
