<?php

namespace App\Http\Controllers\GSO;

use App\Http\Controllers\Controller;
use App\Imports\CommuneImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CommuneController extends Controller
{
    public function import(Request $request) {
        Excel::import(new CommuneImport(), $request->file('communes_import'));
    }
}
