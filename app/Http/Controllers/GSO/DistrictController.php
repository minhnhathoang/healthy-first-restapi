<?php

namespace App\Http\Controllers\GSO;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictResource;
use App\Imports\DistrictImport;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DistrictController extends Controller
{
    public function getDistrictsOfProvince(Request $request) {
        $province = Province::where('name', $request->name)->first();
        return DistrictResource::collection(District::where('province_id', $province->id)->get());
    }

    public function import(Request $request) {
        Excel::import(new DistrictImport(), $request->file('districts_import'));
    }
}
