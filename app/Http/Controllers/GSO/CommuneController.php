<?php

namespace App\Http\Controllers\GSO;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommuneResource;
use App\Imports\CommuneImport;
use App\Models\Commune;
use App\Models\District;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CommuneController extends Controller
{
    public function getCommunesOfDistrict(Request $request) {
        $district = District::where('name', $request->name)->first();
        return CommuneResource::collection(Commune::where('district_id', $district->id)->get());
    }

    public function import(Request $request) {
        Excel::import(new CommuneImport(), $request->file('communes_import'));
    }
}
