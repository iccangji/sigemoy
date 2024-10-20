<?php

namespace App\Http\Controllers;

use App\Models\DataGanda;
use App\Models\DataKpu;
use App\Models\DataKpuInvalid;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Pemilih;
use App\Models\PenanggungJawab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\FlareClient\Http\Exceptions\InvalidData;

class InvalidController extends Controller
{
    //
    public function index(Request $request)
    {
        $size = $request->input('size', 50);
        $page = $request->input('page', 1);
        $search = $request->query('search', '');

        if (auth()->user()->level != 'penginput') {
            $items = DataKpuInvalid::where('nama', 'like', "%$search%")
                ->orderBy('updated_at', 'desc')->paginate($size);
            $countPemilih = $items->total();
        } else {
            $items = DataKpuInvalid::where('nama', 'like', "%$search%")
                ->where('created_by', auth()->user()->user)
                ->orderBy('updated_at', 'desc')->paginate($size);
            $countPemilih = $items->total();
        }

        $kecamatan = Kecamatan::get();
        $kelurahan = Kelurahan::get();
        return view(
            'pages.datatidakvalid',
            [
                'page' => 'data-invalid',
                'title' => 'Data Tidak Valid',
                'user' => auth()->user()->user,
                'level' => auth()->user()->level,
                'data' => $items,
                'search' => $search,
                'count' => $countPemilih,
                'selected_size' => $size,
                'kecamatan' => $kecamatan->toArray(),
                'kecamatan_edit' => $kecamatan,
                'kelurahan' => $kelurahan,
            ]
        );
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

        if (!$dataGandaValidate['result']) {
            return $dataGandaValidate['message'];
        }
        if ($data) {
            Pemilih::create([
                'nama' => $request->nama_pemilih,
                'nik' => $request->NIK,
                'no_hp' => $request->no_hp,
                'hub_keluarga' => $request->hub_keluarga,
                'tps' => $request->tps,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $request->kecamatan,
                'nama_pj' => $request->nama_pj,
                'no_hp_pj' => $request->no_hp_pj,
                'created_by' => auth()->user()->user,
            ]);

            DataKpuInvalid::where('nik', $request->NIK)->delete();
            return redirect()->route('pemilih.index')->with('success', 'Data berhasil dimasukkan');
        }
        return back()->with('error', 'Data pemilih tidak dapat dimasukkan');
    }

    public function destroy($id)
    {
        $nama_pj_pemilih = DataKpuInvalid::where('id', $id)->first()->nama_pj;
        DataKpuInvalid::destroy($id);

        $pj_count_pemilih = Pemilih::where('nama_pj', "$nama_pj_pemilih")->count();
        $pj_count_invalid = DataKpuInvalid::where('nama_pj', "$nama_pj_pemilih")->count();
        if ($pj_count_pemilih + $pj_count_invalid == 0) {
            PenanggungJawab::where('nama', "$nama_pj_pemilih")->delete();
        }
        return back()->with('success', 'Data berhasil dihapus');
    }

    private function dataGandaValidate(Request $request)
    {
        $pj_count = PenanggungJawab::where('nama', 'like', "$request->nama_pj")->count();
        if ($pj_count == 0) {
            PenanggungJawab::create([
                'nama' => $request->nama_pj,
                'no_hp' => $request->no_hp_pj,
            ]);
        }

        $data_count = Pemilih::where('nik', 'like', $request->NIK)->count();
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
            DataKpuInvalid::where('nik', $request->NIK)->delete();
            return [
                'result' => false,
                'message' => back()->with('error', 'Ditemukan data ganda atas nama ' . $data->nama . ' antara penanggung jawab ' . $data->nama_pj . ' dan ' . $request->nama_pj . '. Harap periksa halaman data ganda')
            ];
        }
        return [
            'result' => true,
            'message' => ''
        ];
    }
    public function sync()
    {
        $data_pemilih = Pemilih::get();
        $data_invalid = DataKpuInvalid::get();
        $data_batch = [];
        $data_batch_valid = [];

        try {
            foreach ($data_pemilih as $item) {
                if (DataKpu::where('nama', 'like', "%$item->nama%")->where('kelurahan', 'like', "%$item->kelurahan%")->where('tps', 'like', "%$item->tps%")->count() == 0) {
                    array_push($data_batch, [
                        'nama' => $item->nama,
                        'nik' => $item->nik,
                        'no_hp' => $item->no_hp,
                        'hub_keluarga' => $item->hub_keluarga,
                        'tps' => $item->tps,
                        'kelurahan' => $item->kelurahan,
                        'kecamatan' => $item->kecamatan,
                        'nama_pj' => $item->nama_pj,
                        'no_hp_pj' => $item->no_hp_pj,
                    ]);
                    $item->delete();
                }
            }
            foreach ($data_invalid as $item) {
                if (DataKpu::where('nama', 'like', "%$item->nama%")->where('kelurahan', 'like', "%$item->kelurahan%")->where('tps', 'like', "%$item->tps%")->count() == 0) {
                    array_push($data_batch, [
                        'nama' => $item->nama,
                        'nik' => $item->nik,
                        'no_hp' => $item->no_hp,
                        'hub_keluarga' => $item->hub_keluarga,
                        'tps' => $item->tps,
                        'kelurahan' => $item->kelurahan,
                        'kecamatan' => $item->kecamatan,
                        'nama_pj' => $item->nama_pj,
                        'no_hp_pj' => $item->no_hp_pj,
                    ]);
                } else {
                    array_push($data_batch_valid, [
                        'nama' => $item->nama,
                        'nik' => $item->nik,
                        'no_hp' => $item->no_hp,
                        'hub_keluarga' => $item->hub_keluarga,
                        'tps' => $item->tps,
                        'kelurahan' => $item->kelurahan,
                        'kecamatan' => $item->kecamatan,
                        'nama_pj' => $item->nama_pj,
                        'no_hp_pj' => $item->no_hp_pj,
                    ]);
                }
            }

            if (!empty($data_batch)) {
                DataKpuInvalid::upsert($data_batch, uniqueBy: ['nik'], update: ['id']);
            }
            if (!empty($data_batch_valid)) {
                Pemilih::upsert($data_batch_valid, uniqueBy: ['nik'], update: ['id']);
            }
            return back()->with('success', 'Data Berhasil Disinkronisasi');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Data gagal divalidasi' . $th);
        }
    }

    public function pemilihValidate()
    {
        try {
            $count = DataKpuInvalid::select('nama', 'nik', 'no_hp', 'hub_keluarga', 'tps', 'kelurahan', 'kecamatan', 'nama_pj', 'no_hp_pj', DB::raw("'" . auth()->user()->user . "' as created_by"), DB::raw(now()->toDateTimeString() . " as created_at"), DB::raw(now()->toDateTimeString() . " as updated_at"))
                ->where('tps', '!=', '000')
                ->where('id', '>=', value: 1203)
                ->count();
            $count = DataKpuInvalid::select('nama', 'nik', 'no_hp', 'hub_keluarga', 'tps', 'kelurahan', 'kecamatan', 'nama_pj', 'no_hp_pj', DB::raw("'" . auth()->user()->user . "' as created_by"), DB::raw(now()->toDateTimeString() . " as created_at"), DB::raw(now()->toDateTimeString() . " as updated_at"))
                ->where('tps', '!=', '000')
                ->where('id', '>=', value: 1203)
                ->count();

            $data_valid = DataKpuInvalid::where('tps', '!=', '000')
                ->where('id', '>=', value: 1203)
                ->get()
                ->toArray();
            // dd($data_valid);
            $imported_pemilih_insert = [];
            $imported_pj_insert = [];
            foreach ($data_valid as $item) {
                array_push($imported_pemilih_insert, [
                    'nama' => $item['nama'],
                    'nik' => $item['nik'],
                    'no_hp' => $item['no_hp'],
                    'hub_keluarga' => $item['hub_keluarga'],
                    'tps' => $item['tps'],
                    'kelurahan' => $item['kelurahan'],
                    'kecamatan' => $item['kecamatan'],
                    'nama_pj' => $item['nama_pj'],
                    'no_hp_pj' => $item['no_hp_pj'],
                    'created_by' => auth()->user()->user,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if (PenanggungJawab::where('nama', $item['nama_pj'])->count() == 0) {
                    $pj_is_exist = array_search($item['nama_pj'], array_column($imported_pj_insert, 'nama'));
                    if ($pj_is_exist === false) {
                        array_push($imported_pj_insert, [
                            'nama' => $item['nama_pj'],
                            'no_hp' => $item['no_hp_pj'],
                        ]);
                    }
                }
            }

            if (!empty($imported_pemilih_insert)) {
                Pemilih::upsert($imported_pemilih_insert, uniqueBy: ['nik'], update: ['id']);
            }
            if (!empty($imported_pj_insert)) {
                PenanggungJawab::upsert($imported_pj_insert, uniqueBy: ['nama'], update: ['nama']);
            }


            // dd($imported_pj_insert);
            DB::statement("
                DELETE FROM data_kpu_invalid
                WHERE NOT tps = '000' AND id>=1203;
            ");
            return back()->with('success', 'Data berhasil divalidasi<br>Total Data: ' . $count);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Data gagal divalidasi' . $th);
        }
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
            $item = DataKpuInvalid::findOrFail($id);
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
            ]);
            return back()->with('success', 'Data berhasil diubah');
        }
        return back()->with('error', 'Data pemilih tidak dapat diubah');
    }
}
