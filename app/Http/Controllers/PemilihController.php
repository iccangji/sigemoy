<?php

namespace App\Http\Controllers;

use App\Models\Pemilih;
use Illuminate\Http\Request;

class PemilihController extends Controller
{
    public function index()
    {
        $dataPemilih = Pemilih::limit(1)->get();
        // foreach ($dataPemilih as $item) {
        //     echo $item;
        // }
        return view(
            'pages.pemilih',
            [
                'page' => 'pemlih',
                'user' => auth()->user()->user,
                'level' => auth()->user()->level,
                'data' => $dataPemilih
            ]
        );
    }

    public function getPemilihData(Request $request)
    {
        $size = $request->input('size');
        $offset = $request->input('offset');
        if ($size && $offset >= 0) {
            $dataPemilih = Pemilih::limit($size)->offset($offset)->get();
            return $dataPemilih;
        }   
        $data =  Pemilih::get();
        return response()->json($data);
    }
}
