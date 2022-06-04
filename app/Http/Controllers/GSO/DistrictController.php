<?php

namespace App\Http\Controllers\GSO;

use App\Http\Controllers\Controller;
use App\Imports\DistrictImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DistrictController extends Controller
{
    public function import(Request $request) {
        Excel::import(new DistrictImport(), $request->file('districts_import'));
    }
}
