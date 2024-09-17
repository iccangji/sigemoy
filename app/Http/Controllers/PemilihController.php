<?php

namespace App\Http\Controllers;

use App\Imports\PemilihImport;
use App\Models\Kecamatan;
use App\Models\Pemilih;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PemilihController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->input('size', 50);
        $page = $request->input('page', 1);
        $search = $request->query('search', '');

        if (auth()->user()->level != 'penginput') {
            $items = Pemilih::where('nama', 'like', "%$search%")
                ->orderBy('updated_at', 'desc')
                ->paginate($size);
            $countPemilih = Pemilih::where('nama', 'like', "%$search%")
                ->orderBy('updated_at', 'desc')->count();
        } else {
            $items = Pemilih::where('nama', 'like', "%$search%")
                ->where('created_by', auth()->user()->user)
                ->orderBy('updated_at', 'desc')
                ->paginate($size);
            $countPemilih = Pemilih::where('nama', 'like', "%$search%")
                ->where('created_by', auth()->user()->user)
                ->orderBy('updated_at', 'desc')->count();
        }

        $kecamatan = Kecamatan::get();
        return view('pages.pemilih', [
            'page' => 'pemilih',
            'title' => 'Data Pemilih',
            'user' => auth()->user()->user,
            'level' => auth()->user()->level,
            'data' => $items,
            'search' => $search,
            'count' => $countPemilih,
            'selected_size' => $size,
            'current_page' => $page,
            'kecamatan' => $kecamatan,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'nama_pemilih' => 'required',
            'NIK' => 'required',
            'no_hp' => 'required',
            'hub_keluarga' => 'required',
            'tps' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'nama_pj' => 'required',
        ]);
        $kecamatan = Kecamatan::where('id', $request->kecamatan)->first()->nama;
        if ($data) {
            Pemilih::create([
                'nama' => $request->nama_pemilih,
                'nik' => $request->NIK,
                'no_hp' => $request->no_hp,
                'hub_keluarga' => $request->hub_keluarga,
                'tps' => $request->tps,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $kecamatan,
                'nama_pj' => $request->nama_pj,
                'created_by' => auth()->user()->user,
            ]);
            return back()->with('success', 'Data berhasil dimasukkan');
        }
        return back()->with('error', 'Data pemilih tidak dapat dimasukkan');
    }

    public function update(Request $request, $id)
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
        ]);
        $kecamatan = Kecamatan::where('id', $request->kecamatan)->first()->nama;
        if ($data) {
            $item = Pemilih::findOrFail($id);
            $item->update([
                'nama' => $request->nama_pemilih,
                'nik' => $request->NIK,
                'no_hp' => $request->no_hp,
                'hub_keluarga' => $request->hub_keluarga,
                'tps' => $request->tps,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $kecamatan,
                'nama_pj' => $request->nama_pj,
                'created_by' => auth()->user()->user,
            ]);
            return back()->with('success', 'Data berhasil diubah');
        }
        return back()->with('error', 'Data pemilih tidak dapat diubah');
    }

    public function destroy($id)
    {
        Pemilih::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function location($kecamatan_id)
    {
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
        return response()->json($kelurahans);
    }

    public function importData(Request $request)
    {
        $data = $request->validate([
            'upload' => 'required|mimes:xls,xlsx',
        ]);
        if ($data) {
            try {
                Excel::import(new PemilihImport(auth()->user()->user), $request->file('upload')->store('temp'));
                return redirect()->back()->with('success', 'Data berhasil diimport!');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Data gagal diimport. Pastikan tidak ada data yang kosong dan file sesuai dengan format');
            }
        }
        return redirect()->back()->with('error', 'Data gagal diimport. Pastikan file berbentuk excel');
    }
}
