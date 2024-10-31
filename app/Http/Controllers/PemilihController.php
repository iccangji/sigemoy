<?php

namespace App\Http\Controllers;

use App\Exports\PemilihExport;
use App\Imports\PemilihImport;
use App\Models\DataGanda;
use App\Models\DataKpu;
use App\Models\DataKpuInvalid;
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
        $search = $request->query('search', '');

        if (auth()->user()->level != 'penginput') {
            $items = Pemilih::where('nama', 'like', "%$search%")
                ->orderBy('updated_at', 'desc')
                ->paginate($size);
            $countPemilih = $items->total();
        } else {
            $items = Pemilih::where('nama', 'like', "%$search%")
                ->where('created_by', auth()->user()->user)
                ->orderBy('updated_at', 'desc')
                ->paginate($size);
            $countPemilih = $items->total();
        }

        $kecamatan = Kecamatan::orderBy('nama', 'asc')->get();
        $kelurahan = Kelurahan::orderBy('nama', 'asc')->get();
        return view('pages.pemilih', [
            'page' => 'pemilih',
            'title' => 'Data Pemilih',
            'user' => auth()->user()->user,
            'level' => auth()->user()->level,
            'data' => $items,
            'search' => $search,
            'count' => $countPemilih,
            'selected_size' => $size,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'isFilter' => false,
            'route' => route('pemilih.index'),
        ]);
    }

    public function cari(Request $request)
    {
        $size = $request->input('size', 50);
        $search = $request->query('search', '');

        $filter_nama = $request->input('nama_pemilih', '');
        $filter_kecamatan = $request->input('kecamatan', '');
        $filter_kelurahan = $request->input('kelurahan', '');
        $filter_tps = $request->input('tps', '');

        if (auth()->user()->level != 'penginput') {
            $items = Pemilih::where('nama', 'like', "%$filter_nama%")
                ->where('kecamatan', 'like', "%$filter_kecamatan%")
                ->where('kelurahan', 'like', "%$filter_kelurahan%")
                ->where('tps', 'like', "%$filter_tps%")
                ->orderBy('updated_at', 'desc')
                ->paginate($size);
            $countPemilih = $items->total();
        } else {
            $items = Pemilih::where('nama', 'like', "%$search%")
                ->where('nama', 'like', "%$filter_nama%")
                ->where('kecamatan', 'like', "%$filter_kecamatan%")
                ->where('kelurahan', 'like', "%$filter_kelurahan%")
                ->where('tps', 'like', "%$filter_tps%")
                ->where('created_by', auth()->user()->user)
                ->orderBy('updated_at', 'desc')
                ->paginate($size);
            $countPemilih = $items->total();
        }
        // dd($items);
        $kecamatan = Kecamatan::get();
        $kelurahan = Kelurahan::get();
        return view('pages.pemilihfilter', [
            'page' => 'pemilih',
            'title' => 'Data Pemilih',
            'user' => auth()->user()->user,
            'level' => auth()->user()->level,
            'data' => $items,
            'search' => $search,
            'count' => $countPemilih,
            'selected_size' => $size,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'isFilter' => true,
            'namaQuery' => $filter_nama,
            'kecamatanQuery' => $filter_kecamatan,
            'kelurahanQuery' => $filter_kelurahan,
            'tpsQuery' => $filter_tps,
            'route' => route('pemilih.filter'),
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

        $dataGandaValidate = $this->dataGandaValidate($request);
        $dataKpuValidate = $this->dataKpuValidate($request);

        if (!$dataGandaValidate['result']) {
            return $dataGandaValidate['message'];
        }

        if (!$dataKpuValidate['result']) {
            return $dataKpuValidate['message'];
        }

        $kecamatan = Kecamatan::where('id', 'like', "%$request->kecamatan%")->first()->nama;
        if ($data) {
            if (PenanggungJawab::where('nama', 'like', "%$request->nama_pj%")->count() == 0) {
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
            'no_hp_pj' => 'required',
        ]);
        $kecamatan = Kecamatan::where('id', 'like', "%$request->kecamatan%")->first()->nama;
        if ($data) {
            $nama_pj_pemilih = Pemilih::where('id', $id)->first()->nama_pj;

            $pj_count = PenanggungJawab::where('nama', "$request->nama_pj")->count();
            if ($pj_count == 0) {
                PenanggungJawab::create([
                    'nama' => $request->nama_pj,
                    'no_hp' => $request->no_hp_pj,
                ]);
            } else {
                $existing_pj = PenanggungJawab::where('nama', "$request->nama_pj")->first();
                if ($existing_pj->no_hp != $request->no_hp_pj) {
                    PenanggungJawab::create([
                        'nama' => $request->nama_pj,
                        'no_hp' => $request->no_hp_pj,
                    ]);
                }
            }

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
                'no_hp_pj' => $request->no_hp_pj,
                'created_by' => auth()->user()->user,
            ]);

            $pj_count_pemilih = Pemilih::where('nama_pj', "$nama_pj_pemilih")->count();
            $pj_count_invalid = DataKpuInvalid::where('nama_pj', "$nama_pj_pemilih")->count();
            if ($pj_count_pemilih + $pj_count_invalid == 0) {
                PenanggungJawab::where('nama', "$nama_pj_pemilih")->delete();
            }
            return back()->with('success', 'Data berhasil diubah');
        }
        return back()->with('error', 'Data pemilih tidak dapat diubah');
    }

    public function destroy($id)
    {
        $nama_pj_pemilih = Pemilih::where('id', $id)->first()->nama_pj;
        Pemilih::destroy($id);

        $pj_count_pemilih = Pemilih::where('nama_pj', "$nama_pj_pemilih")->count();
        $pj_count_invalid = DataKpuInvalid::where('nama_pj', "$nama_pj_pemilih")->count();
        if ($pj_count_pemilih + $pj_count_invalid == 0) {
            PenanggungJawab::where('nama', "$nama_pj_pemilih")->delete();
        }
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function location($kecamatan_id)
    {
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
        return response()->json($kelurahans);
    }

    public function importData(Request $request)
    {
        set_time_limit(300);
        $data = $request->validate([
            'upload' => 'required|mimes:xls,xlsx',
        ]);
        if ($data) {
            try {
                $imported_data = Excel::toArray(new PemilihImport(), $request->file('upload')->store('temp'))[0];

                $imported_pj_insert = [];
                $imported_pemilih_insert = [];
                $data_ganda_insert = [];
                $data_invalid_insert = [];

                foreach ($imported_data as $item) {
                    if ($item[1] != null) {
                        if (
                            $item[6] != "000"
                        ) {
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
                                        'no_hp_pj' => $item[8],
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
                            }
                            // Tambahkan algoritma jika data telah terdapat di data ganda
                        } else {
                            array_push($data_invalid_insert, [
                                'nama' => $item[0],
                                'nik' => $item[1],
                                'no_hp' => $item[2],
                                'hub_keluarga' => $item[3],
                                'tps' => $item[6],
                                'kelurahan' => $item[5],
                                'kecamatan' => $item[4],
                                'nama_pj' => $item[7],
                                'no_hp_pj' => $item[8],
                            ]);
                        }
                    }
                }
                if (!empty($data_invalid_insert)) {
                    DataKpuInvalid::upsert($data_invalid_insert, uniqueBy: ['nik'], update: ['id']);
                }
                if (!empty($data_ganda_insert)) {
                    DataGanda::upsert($data_ganda_insert, uniqueBy: ['id'], update: ['id']);
                }
                if (!empty($imported_pemilih_insert)) {
                    Pemilih::upsert($imported_pemilih_insert, uniqueBy: ['nik'], update: ['id']);
                }
                if (!empty($imported_pj_insert)) {
                    PenanggungJawab::upsert($imported_pj_insert, uniqueBy: ['nama'], update: ['nama']);
                }

                if (!empty($data_ganda_insert) && empty($data_invalid_insert)) {
                    return back()->with('success', 'Ditemukan 1 atau lebih data ganda. Harap periksa halaman data ganda');
                } elseif (empty($data_ganda_insert) && !empty($data_invalid_insert)) {
                    return back()->with('success', 'Ditemukan 1 atau lebih data yang tidak valid dengan data KPU. Harap periksa halaman data tidak valid');
                } elseif (!empty($data_ganda_insert) && !empty($data_invalid_insert)) {
                    return back()->with('success', 'Ditemukan 1 atau lebih data ganda dan data yang tidak valid dengan data KPU. Harap periksa halaman data ganda dan halaman data tidak valid');
                }
                return redirect()->back()->with('success', 'Data berhasil diimport!');
            } catch (\Throwable $th) {
                $null_index = strpos($th->getMessage(), 'null');
                return back()->with('error', 'Error ditemukan pada data atas nama ' . $item[0] . ' (' . $item[1] . '). Error: ' . substr($th->getMessage(), 0, $null_index + strlen("null")));
            }
        }
        return redirect()->back()->with('error', 'Data gagal diimport. Pastikan file berbentuk excel');
    }

    public function exportData(Request $request)
    {
        ini_set('memory_limit', -1);
        return Excel::download(new PemilihExport, 'data-pemilih.xlsx');
    }

    public function dataGandaValidate(Request $request)
    {
        $pj_count = PenanggungJawab::where('nama', 'like', "%$request->nama_pj%")->count();
        if ($pj_count == 0) {
            PenanggungJawab::create([
                'nama' => $request->nama_pj,
                'no_hp' => $request->no_hp_pj,
            ]);
        }

        $data_count = Pemilih::where('nik', $request->NIK)->count();
        if ($data_count > 0) {
            $data = Pemilih::where('nik', $request->NIK)->first();
            $data_pj = PenanggungJawab::where('nama', 'like', "%$data->nama_pj%")->first();
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
            return [
                'result' => false,
                'message' => back()->with('error', 'Ditemukan data ganda atas nama ' . $data->nama . ' antara penanggung jawab ' . $data->nama_pj . ' dan ' . $request->nama_pj . '. Harap periksa halaman data ganda'),
            ];
        }
        return [
            'result' => true,
            'message' => '',
        ];
    }

    public function dataKpuValidate(Request $request)
    {
        $data_count = DataKpu::where('nama', 'like', "%$request->nama_pemilih%")
            ->where('kelurahan', 'like', "%$request->kelurahan%")
            ->where('tps', 'like', "%$request->tps%")
            ->count();
        if ($data_count == 0) {
            $kecamatan = Kecamatan::where('id', 'like', "%$request->kecamatan%")->first()->nama;
            DataKpuInvalid::create([
                'nama' => $request->nama_pemilih,
                'nik' => $request->NIK,
                'no_hp' => $request->no_hp,
                'hub_keluarga' => $request->hub_keluarga,
                'tps' => $request->tps,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $kecamatan,
                'nama_pj' => $request->nama_pj,
                'no_hp_pj' => $request->no_hp_pj,
            ]);
            return [
                'result' => false,
                'message' => back()->with('error', 'Tidak ditemukan kesamaan data dengan Data KPU atas nama ' . $request->nama_pemilih),
            ];
        }
        return [
            'result' => true,
            'message' => '',
        ];
    }
}
