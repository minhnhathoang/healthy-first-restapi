<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstablishmentRequest;
use App\Http\Resources\EstablishmentResource;
use App\Models\Establishment;
use Illuminate\Http\Request;

class EstablishmentController extends Controller
{
    protected $establishment;

    public function __construct(Establishment $establishment)
    {
        $this->establishment = $establishment;
    }

    protected array $sortFields = ['name', 'owner', 'address', 'kind_of_business', 'certificates.registration_number'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $sortFieldInput = $request->input('sort_field', self::DEFAULT_SORT_FIELD);
        $sortField = in_array($sortFieldInput, $this->sortFields) ? $sortFieldInput : self::DEFAULT_SORT_FIELD;
        $sortOrder = $request->input('sort_order', self::DEFAULT_SORT_ORDER);
        $searchInput = $request->input('search');

        $query = Establishment::with('certificate')->orderBy($sortField, $sortOrder);
        if ($sortField === 'certificates.registration_number') {
            $query = Establishment::select(['*', 'certificates.registration_number'])
                ->join('certificates', 'certificates.establishment_id', '=', 'establishments.id')
                ->orderBy('certificates.registration_number', $sortOrder);
        }

        $perPage = $request->input('per_page') ?? self::PER_PAGE;

        if (!is_null($searchInput)) {
            $searchQuery = "%$searchInput%";
            $query = $query->where('name', 'like', $searchQuery)
                ->orWhere('owner', 'like', $searchQuery)
                ->orWhere('address', 'like', $searchQuery)
                ->orWhere('kind_of_business', 'like', $searchQuery);
        }


        $etab = $query->paginate((int)$perPage);

        return EstablishmentResource::collection($etab);
    }

    public function store(StoreEstablishmentRequest $request) {

        $establishment = Establishment::create([
            'name' => $request->name,
            'owner' => $request->owner,
            'address' => $request->address.', '.$request->commune.', '.$request->district.', '.$request->province,
            'telephone' => $request->telephone,
            'kind_of_business' => $request->kind_of_business,
            'fax' => $request->fax,
            'description' => $request->description,
        ]);

        return response(['success' => true, 'message' => "Add new establishment success!"], 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $check = Establishment::where('id', $id)->update($request->except(['district', 'province', 'commune']));
        } catch (\Exception $exception) {
            return response(['success' => false, 'message' => "Something went wrong. Please check and try again"], 422);
        }
        return response(['success' => true, 'message' => "Establishment is updated"], 200);
    }

    public function show($id)
    {
        $establishment = Establishment::with('certificate')->where('id', $id)->first();
        if ($establishment) {
            return response([
                'success' => true,
                'message' => "success",
                'establishment' => new EstablishmentResource($establishment)
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
        $check = Establishment::where('id', $id)->delete();
        if ($check) {
            return response(['success' => true, 'message' => "Deleted establishment"], 200);
        }
        return response(['success' => false, 'message' => "Invalid"], 422);
    }

}
