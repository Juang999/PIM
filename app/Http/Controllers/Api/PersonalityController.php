<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmpMaster;
use App\Models\HRPersonality;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PersonalityController extends Controller
{
    public function show($emp_id)
    {
        try {
            $data = DB::table('hris.hr_personality')
            ->select(DB::raw('hris.hr_personality.hr_persnlt_oid, hris.hr_personality.hr_persnlt_date, hris.hr_personality.hr_persnlt_exm, public.code_mstr.code_name'))
            ->leftJoin('public.code_mstr', 'hris.hr_personality.hr_persnlt_code_id', '=', 'public.code_mstr.code_id')
            ->where('hris.hr_personality.hr_persnlt_emp_id', '=', $emp_id)
            ->get();

            return response()->json([
                'status' => 'berhasil',
                'pesan' => 'berhasil mengambil data',
                'data' => $data,
                'code' => 200
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'gagal mengambil data',
                'galat' => $th->getMessage(),
                'line' => $th->getLine(),
                'code' => 400
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $total = HRPersonality::where('hr_persnlt_emp_id', $request->emp_id)->count();

            if ($total == 5) {
                return response()->json([
                    'status' => 'gagal',
                    'pesan' => 'input telah mencapai limit',
                    'total limit' => 5,
                    'code' => 300
                ], 300);
            }

            DB::beginTransaction();
            $data = HRPersonality::create([
                    'hr_persnlt_oid' => Str::uuid(),
                    'hr_persnlt_emp_id' => $request->emp_id,
                    'hr_persnlt_code_id' => $request->codeIdPersonality,
                    'hr_persnlt_date' => $request->datePersonality,
                    'hr_persnlt_exm' => $request->exmPersonality
                ]);

                EmpMaster::where('emp_id', $request->emp_id)->update([
                    'emp_persnlt_code_id' => $data->hr_persnlt_code_id
                ]);
            DB::commit();

            return response()->json([
                'status' => 'berhasil',
                'pesan' => 'berhasil membuat data personality',
                'data' => $data,
                'code' => 200
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'gagal membuat data personality',
                'galat' => $th->getMessage(),
                'line' => $th->getLine(),
                'code' => 400
            ], 400);
        }
    }

    public function update(Request $request, $hr_persnlt_oid)
    {
        try {
            $employee = HRPersonality::where('hr_persnlt_oid', $hr_persnlt_oid)->first();

            HRPersonality::where('hr_persnlt_oid', $hr_persnlt_oid)->update([
                'hr_persnlt_code_id' => ($request->codeIdPersonality) ? $request->codeIdPersonality : $employee->hr_perslt_code_id,
                'hr_persnlt_date' => ($request->datePersonality) ? $request->datePersonality : $employee->hr_persnlt_date,
                'hr_persnlt_exm' => ($request->exmPersonality) ? $request->exmPersonality : $employee->hr_persnlt_exm
            ]);

            return response()->json([
                'status' => 'berhasil',
                'pesan' => 'berhasil update data',
                'code' => 200
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'gagal update data',
                'galat' => $th->getMessage(),
                'code' => 400
            ], 400);
        }
    }
}
