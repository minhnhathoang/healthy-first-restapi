<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'role_id' => $request->role_id,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        if ($user) {
            $verify = DB::table('password_resets')->where([
                'email' => $request->email
            ]);
            if ($verify->exists()) {
                $verify->delete();
            }
            $pin = $pin = rand(100000, 999999);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $pin
            ]);
        }
        Mail::to($request->email)->send(new VerifyEmail($request->name, $pin));
        return response(['success' => true, 'message' => "Add new user"], 200);
    }

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['message' => $validator->errors()]);
        }
        $select = DB::table('password_resets')
            ->where(
                ['email' => Auth::user()->email],
                ['token' => $request->token]
            );

        if ($select->get()->isEmpty()) {
            return response(['success' => false, 'message' => "Invalid PIN"], 400);
        }
        $select = DB::table('password_resets')
            ->where(
                ['email' => Auth::user()->email],
                ['token' => $request->token]
            )->delete();

        $user = User::find(Auth::user()->id);
        $user->email_verified_at = Carbon::now()->getTimestamp();
        $user->save();

        return response(['success' => true, 'message' => "Email is verified"], 200);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = !empty($request->remember);
        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'success' => false,
                'message' => "Invalid login. Please check and try again."
            ], 422);
        }

        $user = Auth::user();

        $token = $user->createToken('main')->plainTextToken;

        return response([
            'success' => true,
            'message' => "You are logged in",
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->currentAccessToken()->delete();
            return response([
                'success' => true,
                'message' => "You are logged out",
            ]);
        }
//        return response([
//            'success' => false,
//            'message' => "You aren't logged in"
//        ], 400);
    }
}
