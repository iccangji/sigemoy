<?php

namespace App\Http\Controllers;

use App\Imports\DataKpuImport;
use App\Models\DataKpu;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


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
            $countkpu = DataKpu::where('nama', 'like', "%$search%")
                ->orderBy('updated_at', 'desc')->count();
        } else {
            $items = DataKpu::where('nama', 'like', "%$search%")
                ->where('created_by', auth()->user()->user)
                ->orderBy('updated_at', 'desc')->paginate($size);
            $countkpu = DataKpu::where('nama', 'like', "%$search%")
                ->where('created_by', auth()->user()->user)
                ->orderBy('updated_at', 'desc')->count();
        }

        $kelurahan = Kelurahan::get();
        // dd($search);
        return view(
            'pages.datakpu',
            [
                'page' => 'data-kpu',
                'title' => 'Data KPU',
                'user' => auth()->user()->user,
                'level' => auth()->user()->level,
                'data' => $items,
                'search' => $request->input('search', ''),
                'count' => $countkpu,
                'selected_size' => $size,
                'current_page' => $page,
                'kelurahan' => $kelurahan
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
    public function importData(Request $request)
    {
        $data = $request->validate([
            'upload' => 'required|mimes:xls,xlsx',
        ]);
        if ($data) {
            try {
                Excel::import(new DataKpuImport(), $request->file('upload')->store('temp'));
                return redirect()->back()->with('success', 'Data berhasil diimport!');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Error: ' . $th);
            }
            // Data gagal diimport. Pastikan tidak ada data yang kosong dan file sesuai dengan format
        }
        return redirect()->back()->with('error', 'Data gagal diimport, pastikan file berbentuk excel');
    }
}
