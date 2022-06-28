<?php

namespace App\Http\Controllers\GSO;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProvinceResource;
use App\Imports\ProvinceImport;
use App\Models\Province;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProvinceController extends Controller
{

    public function index()
    {
        return ProvinceResource::collection(Province::all());
    }

    public function import(Request $request)
    {
        Excel::import(new ProvinceImport(), $request->file('provinces_import'));
    }
}
