<?php

namespace App\Http\Controllers;

use App\Models\DataGanda;
use App\Models\Kecamatan;
use App\Models\Pemilih;
use App\Models\PenanggungJawab;
use Illuminate\Http\Request;

class GandaController extends Controller
{

    public function index(Request $request)
    {
        $size = $request->input('size', 50);
        $page = $request->input('page', 1);
        $search = $request->query('search', '');

        if (auth()->user()->level != 'penginput') {
            $items = DataGanda::where('nama', 'like', "%$search%")
                ->orderBy('updated_at', 'desc')->paginate($size);
            $countPemilih = $items->total();
        } else {
            $items = DataGanda::where('nama', 'like', "%$search%")
                ->where('created_by', auth()->user()->user)
                ->orderBy('updated_at', 'desc')->paginate($size);
            $countPemilih = $items->total();
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
                'kecamatan' => $kecamatan
            ]
        );
    }

    public function destroy($id)
    {
        DataGanda::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }
    public function store(PemilihController $pemilihController, Request $request)
    {
        $data = $request->validate([
            'nama_pemilih' => 'required',
            'NIK' => 'required',
            'no_hp' => 'required',
            'hub_keluarga' => 'required',
            'tps' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'nama_pj' => 'required',
            'no_hp_pj' => 'required',
        ]);

        $dataGandaValidate = $pemilihController->dataGandaValidate($request);
        $dataKpuValidate = $pemilihController->dataKpuValidate($request);

        if (!$dataGandaValidate['result']) {
            return $dataGandaValidate['message'];
        }

        if (!$dataKpuValidate['result']) {
            return $dataKpuValidate['message'];
        }

        $kecamatan = Kecamatan::where('id', $request->kecamatan)->first()->nama;
        if ($data) {
            if (PenanggungJawab::where('nama', $request->nama_pj)->count() == 0) {
                PenanggungJawab::create([
                    'nama' => $request->nama_pj,
                    'no_hp' => $request->no_hp_pj,
                ]);
            }

            Pemilih::create([
                'nama' => $request->nama_pemilih,
                'nik' => $request->NIK,
                'no_hp' => $request->no_hp,
                'hub_keluarga' => $request->hub_keluarga,
                'tps' => $request->tps,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $kecamatan,
                'nama_pj' => $request->nama_pj,
                'no_hp_pj' => $request->no_hp_pj,
                'created_by' => auth()->user()->user,
            ]);
            DataGanda::where('nik', $request->NIK)->first()->delete();
            return back()->with('success', 'Data berhasil dimasukkan');
        }
        return back()->with('error', 'Data pemilih tidak dapat dimasukkan');
    }
}
