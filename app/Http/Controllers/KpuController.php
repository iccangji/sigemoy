<?php

namespace App\Http\Controllers;

use App\Models\DataKpu;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Pemilih;
use Illuminate\Http\Request;

class KpuController extends Controller
{
    //
    public function index(Request $request)
    {
        $size = $request->input('size', 50);
        $page = $request->input('page', 1);
        $search = $request->query('search', '');

        if (auth()->user()->level != 'penginput') {
            $items = DataKpu::where('nama', 'like', "%$search%")
                ->orderBy('updated_at', 'desc')->paginate($size);
            $countkpu = DataKpu::count();
        } else {
            $items = DataKpu::where('nama', 'like', "%$search%")
                ->where('created_by', auth()->user()->user)
                ->orderBy('updated_at', 'desc')->paginate($size);
            $countkpu = DataKpu::where('created_by', auth()->user()->user)->count();
        }

        $kelurahan = Kelurahan::get();
        return view(
            'pages.datakpu',
            [
                'page' => 'data-kpu',
                'title' => 'Data KPU',
                'user' => auth()->user()->user,
                'level' => auth()->user()->level,
                'data' => $items,
                'search' => $search,
                'count' => $countkpu,
                'selected_size' => $size,
                'current_page' => $page,
                'kelurahan'=> $kelurahan
            ]
        );
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'usia' => 'required',
            'alamat' => 'required',
            'tps' => 'required',
            'kelurahan' => 'required',
            
        ]);
        // $ke = Kecamatan::where('id', $request->kecamatan)->first()->nama;
        if ($data) {
            DataKpu::create([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia' => $request->usia,
                'alamat' => $request->alamat,
                'tps' => $request->tps,
                'kelurahan' => $request->kelurahan,
                'created_by' => auth()->user()->user
            ]);
            return back()->with('success', 'Data berhasil dimasukkan');
        }
        return back()->with('error', 'Data pemilih tidak dapat dimasukkan');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'usia' => 'required',
            'alamat' => 'required',
            'tps' => 'required',
            'kelurahan' => 'required',
        ]);
        // $kecamatan = Kecamatan::where('id', $request->kecamatan)->first()->nama;
        if ($data) {
            $item = DataKpu::findOrFail($id);
            $item->update([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia' => $request->usia,
                'alamat' => $request->alamat,
                'tps' => $request->tps,
                'kelurahan' => $request->kelurahan,
                'created_by' => auth()->user()->user
            ]);
            return back()->with('success', 'Data KPU berhasil diubah');
        }
        return back()->with('error', 'Data KPU tidak dapat diubah');
    }

    public function destroy($id)
    {
        DataKpu::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }

    // public function location($kecamatan_id){
    //     $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
    //     return response()->json($kelurahans);
    // }

    // public function getPemilihData(Request $request)
    // {
    //     // $page = $request->input('page');
    //     // $offset = ($page * $size) - $size;
    //     // if ($size && $offset >= 0) {
    //     //     return $dataPemilih;
    //     // }
    //     // $data =  Pemilih::get();
    //     $size = $request->input('size');
    //     $dataPemilih = Pemilih::paginate($size);
    //     return response()->json($dataPemilih);
    // }


    // Endpoint untuk auto-complete kelurahan
    public function getKelurahan(Request $request)
    {
        $search = $request->query('search');
        $kelurahan = DataKpu::where('kelurahan', 'like', "%$search%")
            ->groupBy('kelurahan') // Hindari duplikasi dengan grouping
            ->get(['kelurahan']); // Ambil hanya kolom kelurahan

        return response()->json($kelurahan);
    }

    // Endpoint untuk mendapatkan kecamatan berdasarkan kelurahan
    public function getKecamatanByKelurahan(Request $request)
    {
        $kelurahan = $request->query('kelurahan');
        $kecamatan = Pemilih::where('kelurahan', $kelurahan)->first(['kecamatan']);

        return response()->json($kecamatan);
    }
}
