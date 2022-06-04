<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
//            return response(['success' => false, 'message' => $validator->errors()], 422);
            return response(['success' => false, 'message' => "Can't reset password. Please check and try again."], 422);
        }
        $check = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
        ]);

        if (!$check->exists()) {
            return response(['success' => false, 'message' => 'Invalid pin'], 422);
        }

        $user = User::where('email', $request->email);
        $user->update([
            'password'=> bcrypt($request->password)
        ]);

        $token = $user->first()->createToken('myapptoken')->plainTextToken;

        return response(
            [
                'success' => true,
                'message' => "Your password has been reset",
                'token'=> $token
            ],
            200
        );
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'message' => "Can't change password. Please check and try again."], 422);
        }

        if (!Hash::check($request->current_password, Auth::user()->getAuthPassword())) {
            return response(['success' => false, 'message' => "Can't change password. Please check and try again."], 422);
        }

        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response(
            [
                'success' => true,
                'message' => "Your password was changed.",
            ],
            200
        );
    }
}
