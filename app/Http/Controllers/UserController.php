<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Mail\AddNewUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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

    public function store(RegisterRequest $request) {
        $password = Str::random(15);
        try {
            Mail::to($request->email)->send(new AddNewUser($request->first_name. $request->last_name, $password));
        } catch (Exception $exception) {
            return response(['success' => false, 'message' => "Something went wrong"], 422);
        }
        $user = User::create([
            'first_name' => $request->first_name,
            'surname' => $request->surname,
            'last_name' => $request->last_name,
            'role' => $request->role,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'birthday' => Carbon::parse($request->birthday)->format('Y-m-d'),
            'gender' => $request->gender,
            'password' => bcrypt($password)
        ]);

        Mail::to($request->email)->send(new AddNewUser($user->full_name, $password));
        return response(['success' => true, 'message' => "Add new user"], 200);
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
        return response(['success' => true, 'message' => "Profile is updated"], 200);
    }

    public function show($id)
    {
        $profile = User::where('id', $id)->first();
        if ($profile) {
            return response([
                'success' => true,
                'message' => "success",
                'profile' => new UserResource($profile)
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
        if (Auth::user()->id == $id) {
            return response(['success' => false, 'message' => "Something went wrong, please check again"], 422);
        }
        $check = User::where('id', $id)->delete();
        if ($check) {
            return response(['success' => true, 'message' => "Deleted user"], 200);
        }
        return response(['success' => false, 'message' => "Something went wrong, please check again"], 422);
    }

    public function export() {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
