<?php

namespace App\Http\Controllers;

use App\Imports\PemilihImport;
use App\Models\DataGanda;
use App\Models\Kecamatan;
use App\Models\Pemilih;
use App\Models\Kelurahan;
use App\Models\PenanggungJawab;
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
            'no_hp_pj' => 'required',
        ]);

        $pj_count = PenanggungJawab::where('nama', $request->nama_pj)->count();
        if ($pj_count == 0) {
            PenanggungJawab::create([
                'nama' => $request->nama_pj,
                'no_hp' => $request->no_hp_pj,
            ]);
        }

        $data_count = Pemilih::where('nik', $request->NIK)->count();
        if ($data_count > 0) {
            $data = Pemilih::where('nik', $request->NIK)->first();
            $data_pj = PenanggungJawab::where('nama', $data->nama_pj)->first();
            DataGanda::create([
                'nama' => $data->nama,
                'nik' => $data->nik,
                'no_hp' => $data->no_hp,
                'hub_keluarga' => $data->hub_keluarga,
                'tps' => $data->tps,
                'kelurahan' => $data->kelurahan,
                'kecamatan' => $data->kecamatan,
                'report' => 'Terdapat irisan data antara penanggung jawab atas nama ' . $data->nama_pj . ' (' . $data_pj->no_hp . ') dan ' . $request->nama_pj . ' (' . $request->no_hp_pj . ')',
            ]);
            Pemilih::where('nik', $request->NIK)->delete();
            return back()->with('error', 'Ditemukan data ganda atas nama ' . $data->nama . ' antara penanggung jawab ' . $data->nama_pj . ' dan ' . $request->nama_pj . '. Harap periksa halaman data ganda');
        }

        $data_count = DataGanda::where('nik', $request->NIK)->count();
        if ($data_count > 0) {
            return back()->with('error', 'Data telah dimasukkan ke dalam Data Ganda');
        }

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
                $imported_data = Excel::toArray(new PemilihImport(), $request->file('upload')->store('temp'))[0];

                $imported_pj_insert = [];
                $imported_pemilih_insert = [];
                $data_ganda_insert = [];

                $data_ganda_already_exist = false;

                foreach ($imported_data as $item) {
                    if (DataGanda::where('nik', $item[1])->count() == 0) {
                        if (Pemilih::where('nik', $item[1])->count() == 0) {
                            array_push($imported_pemilih_insert, [
                                'nama' => $item[0],
                                'nik' => $item[1],
                                'no_hp' => $item[2],
                                'hub_keluarga' => $item[3],
                                'tps' => $item[6],
                                'kelurahan' => $item[5],
                                'kecamatan' => $item[4],
                                'nama_pj' => $item[7],
                                'created_by' => auth()->user()->user,
                            ]);

                            if (PenanggungJawab::where('nama', $item[7])->count() == 0) {
                                $pj_is_exist = array_search($item[7], array_column($imported_pj_insert, 'nama'));
                                if ($pj_is_exist === false) {
                                    array_push($imported_pj_insert, [
                                        'nama' => $item[7],
                                        'no_hp' => $item[8],
                                    ]);
                                }
                            }
                        } else {
                            $existing_nama_pj = Pemilih::where('nik', $item[1])->first()->nama_pj;
                            $existing_no_hp_pj = PenanggungJawab::where('nama', $existing_nama_pj)->first()->no_hp;
                            array_push($data_ganda_insert, [
                                'nama' => $item[0],
                                'nik' => $item[1],
                                'no_hp' => $item[2],
                                'hub_keluarga' => $item[3],
                                'tps' => $item[6],
                                'kelurahan' => $item[5],
                                'kecamatan' => $item[4],
                                'report' => 'Terdapat irisan data antara penanggung jawab atas nama ' . $existing_nama_pj . ' (' . $existing_no_hp_pj . ') dan ' . $item[7] . ' (' . $item[8] . ')',
                            ]);
                            Pemilih::where('nik', $item[1])->delete();
                        }
                    } else {
                        $data_ganda_already_exist = true;
                    }
                }

                if (!empty($imported_pemilih_insert)) {
                    Pemilih::upsert($imported_pemilih_insert, uniqueBy: ['nik'], update: ['id']);
                }
                if (!empty($imported_pj_insert)) {
                    PenanggungJawab::upsert($imported_pj_insert, uniqueBy: ['nama'], update: ['nama']);
                }
                if (!empty($data_ganda_insert)) {
                    DataGanda::upsert($data_ganda_insert, uniqueBy: ['id'], update: ['id']);
                    return back()->with('error', 'Ditemukan 1 atau lebih data ganda. Harap periksa halaman data ganda');
                }
                if ($data_ganda_already_exist == true) {
                    return back()->with('error', 'Ditemukan 1 atau lebih data ganda. Harap periksa halaman data ganda');
                }
                return redirect()->back()->with('success', 'Data berhasil diimport!');
            } catch (\Throwable $th) {
                report($th);
                return redirect()->back()->with('error', 'Data gagal diimport. Pastikan tidak ada data yang kosong dan file sesuai dengan format, error: ' . $th);
            }
        }
        return redirect()->back()->with('error', 'Data gagal diimport. Pastikan file berbentuk excel');
    }
}
