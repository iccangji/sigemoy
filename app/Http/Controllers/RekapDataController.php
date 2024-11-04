<?php

namespace App\Http\Controllers;

use App\Models\DataGanda;
use App\Models\DataKpuInvalid;
use App\Models\Pemilih;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\PenanggungJawab;
use Dompdf\Dompdf;
use Dompdf\Options;


class RekapDataController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');

        $items = Pemilih::where('nama_pj', "$search")
            ->orderBy('updated_at', 'desc')->get()->map(function ($item) {
                $item->status = 'Valid';
                return $item;
            });
        $itemsGanda = DataGanda::where('report', 'like', "%atas nama $search (%")
            ->orWhere('report', 'like', "%dan $search (%")
            ->orderBy('updated_at', 'desc')->get()->map(function ($item) {
                $item->status = 'Ganda';
                return $item;
            });
        $itemsInvalid = DataKpuInvalid::where('nama_pj', "$search")
            ->orderBy('updated_at', 'desc')->get()->map(function ($item) {
                $item->status = 'Tidak Valid';
                return $item;
            });

        $itemsPj = PenanggungJawab::where('nama', "$search")->get();
        $countPemilih = $items->count();
        $countGanda = $itemsGanda->count();
        $countInvalid = $itemsInvalid->count();

        $items = $items->concat($itemsGanda)->concat($itemsInvalid);
        $perPage = 50; // Jumlah item per halaman
        $currentPage = LengthAwarePaginator::resolveCurrentPage(); // Mendapatkan halaman saat ini
        $currentItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->all(); // Mengambil item sesuai halaman


        $query = request()->query();
        $query['search'] = $search;
        $paginatedItems = new LengthAwarePaginator($currentItems, $items->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => $query
        ]);
        return view('pages.rekapdata', [
            'page' => 'rekap-data',
            'title' => 'Rekap Data',
            'user' => auth()->user()->user,
            'level' => auth()->user()->level,
            'data' => $paginatedItems,
            'data_pj' => $itemsPj,
            'search' => $search,
            'count_pemilih' => $countPemilih,
            'count_ganda' => $countGanda,
            'count_invalid' => $countInvalid,
            'route' => route('rekap.index'),
        ]);
    }

    public function exportData(Request $request)
    {
        ini_set('memory_limit', -1);
        $search = $request->query('search', '');
        $items = Pemilih::where('nama_pj', "$search")
            ->orderBy('updated_at', 'desc')->get()->map(function ($item) {
                $item->status = 'Valid';
                return $item;
            });
        $itemsGanda = DataGanda::where('report', 'like', "%atas nama $search (%")
            ->orWhere('report', 'like', "%dan $search (%")
            ->orderBy('updated_at', 'desc')->get()->map(function ($item) {
                $item->status = 'Ganda';
                return $item;
            });
        $itemsInvalid = DataKpuInvalid::where('nama_pj', "$search")
            ->orderBy('updated_at', 'desc')->get()->map(function ($item) {
                $item->status = 'Tidak Valid';
                return $item;
            });

        $itemsPj = PenanggungJawab::where('nama', "$search")->get();
        $countPemilih = $items->count();
        $countGanda = $itemsGanda->count();
        $countInvalid = $itemsInvalid->count();

        $items = $items->concat($itemsGanda)->concat($itemsInvalid);

        $html = view('export.rekappdf', [
            'data' => $items,
            'data_pj' => $itemsPj,
            'search' => $search,
            'count_pemilih' => $countPemilih,
            'count_ganda' => $countGanda,
            'count_invalid' => $countInvalid,
        ]);


        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);


        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return $dompdf->stream("rekap-data-sigemoy-$search.pdf", ["Attachment" => true]);
    }

    public function suggestion(Request $request)
    {
        $query = $request->get('query');


        $suggestions = PenanggungJawab::where('nama', 'like', "%$query%")
            ->pluck('nama');

        return response()->json($suggestions);
    }
}
