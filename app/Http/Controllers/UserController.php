<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {

        return UserResource::collection(User::paginate(15));
    }

    public function update(UpdateProfileRequest $request, $id)
    {
        $check = User::where('id', $id)->update($request->all());
        if ($check) {
            return response(['success' => true, 'message' => "Profile is updated"], 200);
        }
        return response(['success' => false, 'message' => "Invalid"], 422);
    }

    public function show($id)
    {
        $profile = User::where('id', $id)->first();
        if ($profile) {
            return response([
                'success' => true,
                'message' => "success",
                'profile' => $profile
            ], 200);
        }
        return response([
            'success' => false,
            'message' => "Something went wrong, please check again"
        ], 422);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = User::where('id', $id)->delete();
        if ($check) {
            return response(['success' => true, 'message' => "Deleted user"], 200);
        }
        return response(['success' => false, 'message' => "Invalid"], 422);
    }
}
