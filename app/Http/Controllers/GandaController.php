<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Pemilih;
use Illuminate\Http\Request;

class GandaController extends Controller
{
    
    public function index(Request $request)
    {
        $size = $request->input('size', 50);
        $page = $request->input('page', 1);
        $search = $request->query('search', '');

        if (auth()->user()->level != 'penginput') {
            $items = Pemilih::where('nama', 'like', "%$search%")
                ->orderBy('updated_at', 'desc')->paginate($size);
            $countPemilih = Pemilih::count();
        } else {
            $items = Pemilih::where('nama', 'like', "%$search%")
                ->where('created_by', auth()->user()->user)
                ->orderBy('updated_at', 'desc')->paginate($size);
            $countPemilih = Pemilih::where('created_by', auth()->user()->user)->count();
        }

        $kecamatan = Kecamatan::get();
        return view(
            'pages.dataganda',
            [
                'page' => 'data-ganda',
                'title' => 'Data Ganda',
                'user' => auth()->user()->user,
                'level' => auth()->user()->level,
                'data' => $items,
                'search' => $search,
                'count' => $countPemilih,
                'selected_size' => $size,
                'current_page' => $page,
                'kecamatan'=> $kecamatan
            ]
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pemilih' => 'required',
            'NIK' => 'required',
            'no_hp' => 'required',
            'hub_keluarga' => 'required',
            'tps' => 'required',
            'kelurahan' => 'required',
            'nama_pj' => 'required'
        ]);

        if ($data) {
            Pemilih::create([
                'nama' => $request->nama_pemilih,
                'nik' => $request->NIK,
                'no_hp' => $request->no_hp,
                'hub_keluarga' => $request->hub_keluarga,
                'tps' => $request->tps,
                'kelurahan' => $request->kelurahan,
                'nama_pj' => $request->nama_pj
            ]);
            return back()->with('success', 'Data berhasil dimasukkan');
        }
        return back()->with('error', 'Data pemilih tidak dapat dimasukkan');
    }

    public function destroy($id)
    {
        Pemilih::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function getKelurahan(Request $request)
    {
        $search = $request->query('search');
        $kelurahan = Pemilih::where('kelurahan', 'like', "%$search%")
            ->groupBy('kelurahan') // Hindari duplikasi dengan grouping
            ->get(['kelurahan']); // Ambil hanya kolom kelurahan

        return response()->json($kelurahan);
    }

    public function getKecamatanByKelurahan(Request $request)
    {
        $kelurahan = $request->query('kelurahan');
        $kecamatan = Pemilih::where('kelurahan', $kelurahan)->first(['kecamatan']);

        return response()->json($kecamatan);
    }
}
