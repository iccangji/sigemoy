<?php

namespace App\Http\Controllers;

use App\Models\PenanggungJawab;
use Illuminate\Http\Request;

class PenanggungJawabController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->input('size', 50);
        $page = $request->input('page', 1);
        $search = $request->query('search', '');

        $items = PenanggungJawab::where('nama', 'like', "%$search%")
            ->orderBy('updated_at', 'desc')
            ->paginate($size);
        $countPemilih = PenanggungJawab::where('nama', 'like', "%$search%")
            ->orderBy('updated_at', 'desc')->count();
        return view('pages.datapj', [
            'page' => 'datapj',
            'title' => 'Penanggung Jawab',
            'user' => auth()->user()->user,
            'level' => auth()->user()->level,
            'data' => $items,
            'search' => $search,
            'count' => $countPemilih,
            'selected_size' => $size,
            'current_page' => $page,
        ]);
    }
}
