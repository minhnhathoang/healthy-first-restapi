<?php

namespace App\Http\Controllers\GSO;

use App\Http\Controllers\Controller;
use App\Imports\ProvinceImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProvinceController extends Controller
{
    public function import(Request $request) {
        Excel::import(new ProvinceImport(), $request->file('provinces_import'));
    }
}
