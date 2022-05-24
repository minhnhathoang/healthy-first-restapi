<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'message' => $validator->errors()], 422);
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
}
