<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use Illuminate\Http\Request;

class DaerahController extends Controller
{

    public function getKota()
    {
        $kota = Kota::where('id_provinsi', '36')->get();
        return response()->json(['status' => 200, 'data' => $kota]);
    }

    public function getKecamatan($id)
    {
        $kecamatan = Kecamatan::where('id_kota', $id)->get();
        return response()->json(['status' => 200, 'data' => $kecamatan]);
    }

    public function getKelurahan($id)
    {
        $kelurahan = Kelurahan::where('id_kecamatan', $id)->get();
        return response()->json(['status' => 200, 'data' => $kelurahan]);
    }
}
