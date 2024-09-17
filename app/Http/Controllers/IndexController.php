<?php

namespace App\Http\Controllers;

use App\Models\DataGanda;
use App\Models\DataKpu;
use App\Models\DataKpuInvalid;
use App\Models\Pemilih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PemilihController;

class IndexController extends Controller
{
    public function index()
    {
        $level = auth()->user()->level;
        if ($level == 'penginput') {
            return redirect('/pemilih');   # code...
        }
        return view(
            'pages.dashboard',
            [
                'page' => 'dashboard',
                'title' => 'Dashboard',
                'user' => auth()->user()->user,
                'level' => $level
            ]
        );
    }

    public function indexData()
    {
        return $this->getCountData();
    }

    private function getCountData()
    {
        $data = Pemilih::select('kecamatan', 'kelurahan', 'tps', DB::raw('COUNT(*) as total_pemilih'))
            ->groupBy('kecamatan', 'kelurahan', 'tps')
            ->get()
            ->groupBy('kecamatan') // Mengelompokkan berdasarkan kecamatan
            ->map(function ($kelurahanGroup) {
                return [
                    'kelurahan' => $kelurahanGroup->groupBy('kelurahan') // Mengelompokkan berdasarkan kelurahan
                        ->map(function ($tpsGroup) {
                            return [
                                'tps' => $tpsGroup->sortBy(function ($item) { // Mengurutkan TPS
                                    return (int) $item->tps; // Mengonversi TPS ke integer untuk pengurutan numerik
                                })->map(function ($item) {
                                    return [
                                        'name' => $item->tps,
                                        'pemilih' => $item->total_pemilih,
                                    ];
                                })->values() // Reset indeks array
                            ];
                        })
                ];
            });
        return response()->json([
            'pemilih' => Pemilih::count(),
            'data_ganda' => DataGanda::count(),
            'data_kpu' => DataKpu::count(),
            'data_invalid' => DataKpuInvalid::count(),
            'data_grafik' => $data
        ]);
    }
}
