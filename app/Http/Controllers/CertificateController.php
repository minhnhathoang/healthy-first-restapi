<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Certification;
use App\Http\Requests\StoreCertificationRequest;
use App\Http\Requests\UpdateCertificationRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {

    }


    public function store(Request $request)
    {
        $date1 = Carbon::createFromFormat('Y-m-d', $request->date_issued);
        $date2 = Carbon::createFromFormat('Y-m-d', $request->due_date);
        if ($date1->gt($date2)) {
            return response(['success' => false, 'message' => "Something went wrong. Please check and try again"], 422);
        }
        $reg_no = Certificate::max('registration_number');
        try {
            $certificate = Certificate::create([
                'establishment_id' => $request->establishment_id,
                'registration_number' => $reg_no + 1,
                'date_issued' => $request->date_issued,
                'due_date' => $request->due_date,
                'is_revoked' => 0
            ]);
        } catch (Exception $exception) {
            return response(['success' => false, 'message' => "Something went wrong. Please check and try again"], 422);
        }
        return response(['success' => true, 'message' => "Submit success!"], 200);
    }

    public function update(Request $request)
    {
        try {
            Certificate::where('establishment_id', $request->establishment_id)->update([
                'is_revoked' => $request->is_revoked
            ]);
        } catch (Exception $exception) {
            return response(['success' => false, 'message' => "Something went wrong. Please check and try again"], 422);

        }
        return response(['success' => true, 'message' => "Update Certificate success"], 200);
    }

    public function destroy($id)
    {
        try {
            Certificate::where('establishment_id', $id)->delete();
        } catch (Exception $exception) {
            return response(['success' => false, 'message' => "Something went wrong. Please check and try again"], 422);
        }
        return response(['success' => true, 'message' => "Delete this certificate success!"], 200);
    }
}
