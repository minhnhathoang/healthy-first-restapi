<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;
use function Illuminate\Support\Arr;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    protected array $sortFields = ['first_name', 'address', 'email', 'role'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
//        return $request->sort_field;
        $sortFieldInput = $request->input('sort_field', self::DEFAULT_SORT_FIELD);
        $sortField = in_array($sortFieldInput, $this->sortFields) ? $sortFieldInput : self::DEFAULT_SORT_FIELD;
        $sortOrder = $request->input('sort_order', self::DEFAULT_SORT_ORDER);
        $searchInput = $request->input('search');
//        return $sortField;
        $query = User::orderBy($sortField, $sortOrder);
        $perPage = $request->input('per_page') ?? self::PER_PAGE;
        if (!is_null($searchInput)) {
            $searchQuery = "%$searchInput%";
            $query = $query->where('first_name', 'like', $searchQuery)
                ->orWhere('last_name', 'like', $searchQuery)
                ->orWhere('surname', 'like', $searchQuery)
                ->orWhere('email', 'like', $searchQuery)
                ->orWhere(
                    'address',
                    'like',
                    $searchQuery
                );
        }


        $users = $query->paginate((int)$perPage);

        return UserResource::collection($users);
    }

    public function update(UpdateProfileRequest $request, $id)
    {
        $avatar = $request->file('avatar');
        if ($avatar) {
            $path = $avatar->store('/images', 'public');
            $request->avatar = $path;
            User::where('id', $id)->update([
                'avatar' => $path
            ]);
        }

        $check = User::where('id', $id)->update($request->except('avatar'));
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
     * @param int $id
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

    public function export() {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
