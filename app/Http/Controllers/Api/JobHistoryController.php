<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HRPosisi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class JobHistoryController extends Controller
{
    public function show($emp_id)
    {
        try {
            $data = HRPosisi::where('hrpos_emp_id', $emp_id)->orderBy('hrpos_seq')->get();

            return response()->json([
                'status' => 'berhasil',
                'pesan' => 'berhasil memanggil data',
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
        $sequence = HRPosisi::where('hrpos_emp_id', $request->emp_id)->count();

        if (!$sequence) {
            $sequence = 1;
        } elseif ($sequence == 5) {
            return response()->json([
                'status' => 'redirected',
                'pesan' => 'kamu telah mencapai limit',
                'limit' => 5,
                'code' => 300
            ], 300);
        } else {
            $sequence++;
        }

        try {
            $data = HRPosisi::create([
                'hrpos_oid' => Str::uuid(),
                'hrpos_emp_id' => $request->emp_id,
                'hrpos_seq' => $sequence,
                'hrpos_posisi' => $request->posisiPosisi,
                'hrpos_start' => $request->startPosisi,
                'hrpos_end' => $request->endPosisi,
                'hrpos_remarks' => $request->remarksPosisi
            ]);

            return response()->json([
                'status' => 'berhasil',
                'pesan' => 'berhasil menginputkan data',
                'data' => $data,
                'code' => 200
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'gagal menginputkan data',
                'galat' => $th->getMessage(),
                'code' => 400
            ], 400);
        }
    }
}
