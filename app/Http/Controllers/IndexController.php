<?php

namespace App\Http\Controllers;

use App\Models\DataGanda;
use App\Models\DataKpu;
use App\Models\DataKpuInvalid;
use App\Models\Pemilih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        if (auth()->user()->level == "admin") {
            $data = $this->getCountData()['pemilih_per_kecamatan'];
            foreach ($data as $item) {
                echo $item->kecamatan . ': ' . $item->total_pemilih . ' posts<br>';
            }
            return response()->json($data);
        } else if (auth()->user()->level == "viewer") {
            $data = $this->getCountData()['pemilih_per_kecamatan'];
            foreach ($data as $item) {
                echo $item->kecamatan . ': ' . $item->total_pemilih . ' posts<br>';
            }
        } else if (auth()->user()->level == "penginput") {
            $data = $this->getCreatedData(auth()->user()->user);
            foreach ($data as $item) {
                echo $item->kecamatan;
            }
        }
    }

    private function getCountData()
    {
        $count_per_kecamatan = Pemilih::select('kecamatan', DB::raw('COUNT(*) as total_pemilih'))
            ->groupBy('kecamatan')
            ->get();
        return [
            'pemilih' => Pemilih::count(),
            'data_ganda' => DataGanda::count(),
            'data_kpu' => DataKpu::count(),
            'data_invalid' => DataKpuInvalid::count(),
            'pemilih_per_kecamatan' => $count_per_kecamatan
        ];
    }

    private function getCreatedData(string $user)
    {
        return Pemilih::where('created_by', $user)->get();
    }



    public function detailsKecamatan($nama_kecamatan)
    {
        $count_per_kelurahan = Pemilih::select('kelurahan', DB::raw('COUNT(*) as total_pemilih'))
            ->groupBy('kelurahan')
            ->where('kecamatan', $nama_kecamatan)
            ->get();
        foreach ($count_per_kelurahan as $item) {
            echo $item->kelurahan . ': ' . $item->total_pemilih . ' posts<br>';
        }
        return response()->json($count_per_kelurahan);
    }
    public function detailsKelurahan($nama_kecamatan = "", $nama_kelurahan)
    {
        $count_per_tps = Pemilih::select('tps', DB::raw('COUNT(*) as total_pemilih'))
            ->groupBy('tps')
            ->where('kelurahan', $nama_kelurahan)
            ->where('kecamatan', $nama_kecamatan)
            ->get();

        // foreach ($count_per_tps as $item) {
        //     echo $item->tps . ': ' . $item->total_pemilih . ' posts<br>';
        // }
        return response()->json($count_per_tps);
    }
}
