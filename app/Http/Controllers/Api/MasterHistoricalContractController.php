<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HRKontrak;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Str;

class MasterHistoricalContractController extends Controller
{
    public function show($emp_id)
    {
        try {
            $data = HRKontrak::where('hrkontrak_emp_id', $emp_id)->orderBy('hrkontrak_seq')->get();

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
                'code' => 400
            ], 400);
        }
    }

    public function store(Request $request)
    {
        $sequence = HRKontrak::where('hrkontrak_emp_id', $request->emp_id)->count();

        if (!$sequence) {
            $sequence = 1;
        } elseif ($sequence == 5) {
            return response()->json([
                'status' => 'redirected',
                'pesan' => 'input telah mencapai batas limit',
                'limit' => 5,
                'code' => 300
            ], 300);
        } else {
            $sequence++;
        }

        try {
            $historicalContract = HRKontrak::create([
                'hrkontrak_oid' => Str::uuid(),
                'hrkontrak_emp_id' => $request->emp_id,
                'hrkontrak_seq' => $sequence,
                'hrkontrak_start' => $request->tglAwalKontrak,
                'hrkontrak_end' => $request->tglAkhirKontrak,
                'hrkontrak_remarks' => $request->remarksKontrak,
                'hrkontrak_number' => $request->kontrakKeKontrak,
                'hrkontrak_name' => $request->tipeKontrak
            ]);

            return response()->json([
                'status' => 'berhasil',
                'pesan' => 'berhasil membuat data',
                'data' => $historicalContract,
                'code' => 200
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'gagal membuat pesan',
                'galat' => $th->getMessage(),
                'code' => 400
            ], 400);
        }
    }

    public function update(Request $request, $oid)
    {
        try {
            $employee = HRKontrak::where('hrkontrak_oid', $oid)->first();

            HRKontrak::where('hrkontrak_oid', $oid)->update([
                'hrkontrak_start' => ($request->tglAwalKontrak) ? $request->tglAwalKontrak : $employee->hrkontrak_start,
                'hrkontrak_end' => ($request->tglAkhirKontrak) ? $request->tglAkhirKontrak : $employee->hrkontrak_end,
                'hrkontrak_remarks' => ($request->remarksKontrak) ? $request->remarksKontrak : $employee->hrkontrak_remarks,
                'hrkontrak_number' => ($request->kontrakKeKontrak) ? $request->kontrakKeKontrak : $employee->hrkontrak_number,
                'hrkontrak_name' => ($request->tipeKontrak) ? $request->tipeKontrak : $employee->hrkontrak_name
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
