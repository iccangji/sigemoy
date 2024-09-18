<?php

namespace App\Http\Controllers;

use App\Models\DataGanda;
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
            $items = DataGanda::where('nama', 'like', "%$search%")
                ->orderBy('updated_at', 'desc')->paginate($size);
            $countPemilih = DataGanda::where('nama', 'like', "%$search%")
                ->orderBy('updated_at', 'desc')->count();
        } else {
            $items = DataGanda::where('nama', 'like', "%$search%")
                ->where('created_by', auth()->user()->user)
                ->orderBy('updated_at', 'desc')->paginate($size);
            $countPemilih = DataGanda::where('nama', 'like', "%$search%")
                ->where('created_by', auth()->user()->user)
                ->orderBy('updated_at', 'desc')->count();
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
                'kecamatan' => $kecamatan
            ]
        );
    }

    public function destroy($id)
    {
        DataGanda::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }
}
